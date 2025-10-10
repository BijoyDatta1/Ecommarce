<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\helper\JWTtoken;

class TokenVeryfy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->cookie('token')){
            $token = $request->cookie('token');
            $result = JWTtoken::varifyToken($token);
            if($result ===  'Unauthorized'){
                return redirect("/loginpage");
            }else{
                $request->headers->set('email', $result->email);
                $request->headers->set('id',$result->user_id);
                $request->headers->set('role', $result->role);
                return $next($request);
            }

        }else{
            return redirect("/loginpage");
        }

    }
}
