<?php

namespace App\Http\Controllers\Authintication;

use App\helper\JWTtoken;
use App\helper\Role;
use App\Http\Controllers\Controller;
use App\Mail\OtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function loginPage(){
        return view('login.login');
    }
    public function registerPage(){
        return view('login.registation');
    }
    public function otpPage(){
        return view('login.otp');
    }
    public function recoveryPage(){
        return view('login.recovery');
    }
    public function resetPasswordPage(){
        return view('login.resetPassword');
    }
    public function login(Request $request){
        $vlidator = Validator::make($request->all(),[
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);
        if($vlidator->fails()){
            return response()->json([
                'status' => "failed",
                'message' => $vlidator->errors()
            ]);
        }
        $user = User::where('email', $request->email)->where('password', $request->password )->first();
        if($user){
            $token = JWTtoken::createToken($user->id,$user->email,$user->role);
            return response()->json([
                'status' => "success",
                'message' => "You are logged in successfully",
                'token' => $token,
            ],200)->cookie('token',$token,60);
        }else{
            return response()->json([
                'status' => "failed",
                'message' => "Invalid email or password"
            ]);
        }
    }
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        if ($user) {
            return response()->json([
                'status' => "success",
                'message' => "User registered successfully"
            ],200);
        }else{
            return response()->json([
                'status' => "failed",
                'message' => "Something went wrong in Registration"
            ]);
        }
    }
    public function logout(Request $request){
        if ($request->hasCookie('token')) {
            return response()->json([
                "status" => "success",
                "message" => "Logged out successfully!"
            ],200)->withCookie(Cookie::forget('token'));
        }else{
            return response()->json([
                "status" => "failed",
                "message" => "Token not found in cookie!"
            ]);
        }
    }
    public function SendOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }
        $user = User::where('email',$request->email)->first();
        if($user){
            $otp = rand(10000, 99999);
            if(Mail::to($user->email)->send(new OtpMail($otp))){
                $user->otp = $otp;
                $user->save();
                return response()->json([
                    'status' => "success",
                    'message' => "OTP sent successfully!"
                ],200);
            }else{
                return response()->json([
                    'status' => "failed",
                    'message' => "Something went wrong in Send OTP"
                ]);
            }

        }
    }
    public function verifyOtp(Request $request){
        $validator = Validator::make($request->all(), [
            'otp' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }
        $user = User::where('email',$request->email)->where('otp', $request->otp)->first();
        if($user){
            $user->otp = 0;
            $user->save();
            $token = JWTtoken::createToken($user->id,$user->email,$user->role,5);
            if ($token){
                return response()->json([
                    'status' => "success",
                    'message' => "OTP Verified"
                ],200)->cookie('token',$token,5);
            }else{
                return response()->json([
                    'status' => "failed",
                    'message' => "Otp not Verified"
                ]);
            }
        }else{
            return response()->json([
                'status' => "failed",
                'message' => "otp and email not match"
            ]);
        }
    }
    public function resetPassword(Request $request){
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => "failed",
                'message' => $validator->errors()
            ]);
        }
        $user = User::where('email',$request->header('email'))->first();
        if($user){
            $user->update([
                'password' => $request->password
            ]);
            return response()->json([
                'status' => "success",
                'message' => "Password reset successfully!"
            ],200);
        }
    }

}
