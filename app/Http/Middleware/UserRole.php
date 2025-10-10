<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($request->header('role') === null){
            //if role not set redirect loginpage
            return  redirect('/loginpage');
        }elseif ($request->header('role') != 0){
            //if role is not user redirect to loginPage
            return  redirect('/loginpage');
        }
        return $next($request);
    }
}
