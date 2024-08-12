<?php

namespace App\Http\Middleware;

use App\Api\Controllers\HomeService;
use App\Models\Member;
use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Symfony\Component\HttpFoundation\Response;

class CheckUserLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if($MEMBER_ID = \Help::getSessionMemberId($request)){
            $member = Member::where(['id'=>$MEMBER_ID])->first();
            if($member){
                define('MEMBER_ID', $MEMBER_ID);
                define('MEMBER_TYPE', $member->idMemberGroup);
                define('JWT_TOKEN', $request->session()->get('JWT_TOKEN'));
            }
        }
        if(!defined('MEMBER_ID') ){
            define('MEMBER_ID', 0);
            define('MEMBER_TYPE', 0);
            define('JWT_TOKEN', '');
            $request->session()->remove('member');
        }

        $HomeService = new HomeService();

        View::share('header', $HomeService->header($request));
        View::share('footer', $HomeService->footer($request));
        View::share('configGeneral', Setting::getConfigGeneral());
        View::share('seoSettings',  Setting::getSeoSettings());
        View::share('text', $request->input('text'));
        return $next($request);
    }
}
