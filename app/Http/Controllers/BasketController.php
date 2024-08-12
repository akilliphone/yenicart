<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

class BasketController extends Controller {
    public function index(Request $request){
        $data['basket'] = \BasketService::getBasket();
        return view('basket.index',$data);
    }
    public function bayi(Request $request){
        $data = [
            'title'=>'Bayi Girişi',
            'ask'=>'Bayi Değil misiniz?',
            'button'=>'Hemen Bayi Ol',
        ];
        return view('login.index',$data);
    }
    public function addProduct(Request $request,  $idProduct, $idColor, $count ){
        //\BasketService::clear();
        \BasketService::addProduct($idProduct, $idColor, $count);
        return(\BasketService::toArray());
    }
    public function setProduct(Request $request,  $idProduct, $idColor, $count ){
        \BasketService::addProduct($idProduct, $idColor, $count, true);
        return(\BasketService::toArray());
    }
    public function remove(Request $request,  $itemCode ){
        \BasketService::removeProduct($itemCode);
        return(\BasketService::toArray());
    }
}
