<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($userToken = \Amele::getRequestToken($request)){
            define('MEMBER_ID', $userToken->id);
            define('MEMBER_TYPE', $userToken->membergroup);
            define('JWT_TOKEN', $userToken);
        } else {
            define('MEMBER_ID', 0);
            define('MEMBER_TYPE', 0);
            define('JWT_TOKEN', '');
        }
        return $next($request);
    }
}
