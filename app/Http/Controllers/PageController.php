<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;


class PageController extends Controller {
    public function index(Request $request, $pageSlug){
        $data['config_general']   =  [];
        if(\View::exists('page.'.$pageSlug)){
            $data['page'] = Page::where(['permalink'=>$pageSlug])->first() ;
            return view('page.'.$pageSlug, $data);
        }else {
            $page = Page::where(['permalink'=>$pageSlug])->first();
            if($page){
                $page['content'] = Blade::compileString($page['content']);
                $data['page'] = $page ;
                return view('page.index', $data);
            }
        }
        return view('page.404', $data);
    }

}
