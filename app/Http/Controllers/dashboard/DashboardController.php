<?php

namespace App\Http\Controllers\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request){
        if($request->header('role') == 1){
            return view('dashboard.app');
        }
        if ($request->header('role') == 2){
            return "Welcome to Dashbord You are moderator";
        }
        return "this is admin and moderator";
    }

    public function profile(){
        return "this is profile";
    }
}
