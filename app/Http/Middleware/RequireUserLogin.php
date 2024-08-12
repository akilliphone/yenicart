<?php

namespace App\Http\Middleware;

use App\Api\Controllers\HomeService;
use App\Models\Member;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class RequireUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(defined('MEMBER_ID') && !empty(MEMBER_ID)){
            return $next($request);
        } else{
            $request->session()->flash('flash-error', ['Üzgünüz', 'Bu sayfayı görmek için oturum açmalısınız']);
            return redirect(route('home'));
        }
    }
}
