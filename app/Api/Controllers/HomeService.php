<?php

namespace App\Api\Controllers;

use App\Api\Models\Home;
use App\Api\Models\Member;
use App\Api\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HomeService extends Controller {
    const CACHE_DURATIN=300; // saniye
    const YEDEK_PARCLAR = 179;
    const TAMIR_MALZEMELERI = 168;
    function content(Request $request){
        $start = time();
        $cachedata = null;//Cache::get('home.load.data', null);
        if($cachedata){
            $data = ($cachedata);
            $data['cached'] = true;
        } else {
            $data['providers'] = $this->getProviders($request);
            $data['main_slider'] = $this->main_slider($request);
            $data['mega_menu'] = $this->mega_menu($request);
            $data['tall_banner'] = $this->tall_banner($request);
            $data['product_slider'] = $this->product_slider($request);
            $data['three_banner'] = $this->three_banner($request);
            $data['newly']=$this->newly($request);
            $data['bestseller']=$this->bestseller($request);
            $data['restock']=$this->restock($request);
            $data['onsale']=$this->onsale($request);
            $data['cat_accessory']=$this->cat_section($request, '207');
            $data['cat_car']=$this->cat_section($request, '280');
            $data['cat_home']=$this->cat_section($request, '327');
            $data['cat_powerbank']=$this->cat_section($request, '203');
            $data['cat_converters']=$this->cat_section($request, '209');
            $data['cat_sound']=$this->cat_section($request, '157');
            $data['cat_personel']=$this->cat_section($request, '337');
            $data['home_providers']=$this->home_providers($request);
            Cache::put('home.load.data', ($data), self::CACHE_DURATIN);
            $data['cache_date'] = date('Y-m-d H:i:s');
        }
        $data['times']['start'] = $start;
        $data['times']['end'] = time();
        return $data;
    }
    function header(Request $request){
        $data = Cache::get('home.header.data', null);
        if($data){
            $data['cached'] = true;
        } else {
            $data['mega_menu'] = $this->mega_menu($request);
            Cache::put('home.header.data', $data, self::CACHE_DURATIN);
            $data['cache_date'] = date('Y-m-d H:i:s');
        }
        $data['member'] = $this->member($request);
        return $data;
    }
    function footer(Request $request){
        $data = Cache::get('home.footer.data', null);
        if($data){
            $data['cached'] = true;
        } else {
            $data['providers'] = $this->getProviders($request);
            Cache::put('home.footer.data', $data, self::CACHE_DURATIN);
            $data['cache_date'] = date('Y-m-d H:i:s');
        }
        return $data;
    }
    function member(Request $request){
        $member = Member::getMemberInfo();
        if($member){
            $member->logged = 1;
        }
        return $member;

    }
    function cat_section(Request $request, $idCategory){
        $productService = new ProductService();
        $response = $productService->cat_section($request, $idCategory);
        return isset($response['data'])?$response['data']:[];
    }
    function getProviders(Request $request){
        return Product::getProviders();
    }
    function three_banner(Request $request){
        return Home::three_banner();
    }
    function home_providers(Request $request){
        return Home::home_providers();
    }
    function product_slider(Request $request){
        return Home::product_slider();
    }
    function tall_banner(Request $request){
        return Home::tall_banner();
    }
    function main_slider(Request $request){
        return Home::main_slider();
    }
    function mega_menu(Request $request){
        $items = Home::mega_menu();
        if(isset($items['categories'][self::YEDEK_PARCLAR]) && isset($items['categories'][self::TAMIR_MALZEMELERI])){
            $item = $items['categories'][self::TAMIR_MALZEMELERI];
            unset($items['categories'][self::TAMIR_MALZEMELERI]);
            $items['categories'][self::YEDEK_PARCLAR]->children = array_merge($items['categories'][self::YEDEK_PARCLAR]->children, $item->children);
        }
        return $items;
    }
    function newly(Request $request){
        $productService = new ProductService();
        $response = $productService->newly($request);
        return isset($response['data'])?$response['data']:[];
    }
    function bestseller(Request $request){
        $productService = new ProductService();
        $response = $productService->bestseller($request);
        return isset($response['data'])?$response['data']:[];
    }
    function restock(Request $request){
        $productService = new ProductService();
        $response = $productService->restock($request);
        return isset($response['data'])?$response['data']:[];
    }
    function onsale(Request $request){
        $productService = new ProductService();
        $response = $productService->onsale($request);
        return isset($response['data'])?$response['data']:[];
    }

}
