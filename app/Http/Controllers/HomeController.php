<?php

namespace App\Http\Controllers;

use App\Api\Controllers\HomeService;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class HomeController extends Controller {
    public function index(Request $request){

        return $this->indexPHP($request);
    }
    private function indexVjs(Request $request){
        $data = [];
        return view('home.index',$data);
    }
    private function indexPHP(Request $request){
        $HomeService = new HomeService();
        $data['content'] = $HomeService->content($request);
        return view('home.index',$data);
    }
}
