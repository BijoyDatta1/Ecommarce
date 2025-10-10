<?php

namespace App\Http\Middleware;

use App\helper\Role;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminModaretRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $role = $request->header('role');
        if($request->header('role') === null){
            //if role not set redirect loginpage
            return  redirect('/loginpage');
        }elseif (!in_array($role, [Role::ADMIN,Role::Moderator])){
            //if role will be user redirect loginpage
            return  redirect('/loginpage');
        }
        return $next($request);
    }
}
