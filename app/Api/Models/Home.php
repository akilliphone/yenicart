<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Home extends Model{
    const firstCategoryId=207;
    protected $table = 'home';
    protected $fillable = [
    ];
    protected $hidden = [

    ];


    public static function home_providers(){
        $idSlider = 67;
        $sizes = [
            'desktop'=>[350,91],
            'mobile'=>[350,91],
        ];
        return self::wecart_slider($idSlider, $sizes);
    }
    public static function product_slider(){
        $idSlider = 62;
        $sizes = [
            'desktop'=>[232,147],
            'mobile'=>[464,294],
        ];
        return self::wecart_slider($idSlider, $sizes);
    }
    public static function three_banner(){
        $idSlider = 65;
        $sizes = [
            'desktop'=>[1140,400],
            'mobile'=>[284,125],
        ];
        return self:: wecart_slider($idSlider, $sizes);
    }
    public static function tall_banner(){
        $idSlider = 63;
        $sizes = [
            'desktop'=>[1140,400],
            'mobile'=>[1140,400],
        ];
        return self:: wecart_slider($idSlider, $sizes);
    }
    public static function main_slider(){
        $idSlider = 61;
        $sizes = [
            'desktop'=>[1100,390],
            'mobile'=>[326,227],
        ];
        return self:: wecart_slider($idSlider, $sizes);
    }
    private static function wecart_slider($idSlider, $sizes){

        $d = $sizes['desktop'];
        $m = $sizes['mobile'];
        $query = DB::table('slider');
        $query->where(['id'=>$idSlider]);
        $slider = $query->first();
        if($slider){
            $items = [];
            $query = DB::table('slider_pics');
            $query->where(['idSlider'=>$idSlider]);
            $rows = $query->get();
            if($rows){
                foreach($rows as $row){
                    $product = [];
                    if((int)$row->title){
                        $product = Product::productDetail((int)$row->title);
                    }
                    $items[]=[
                        "desktopImage" => \Amele::getCdnImageUrl($row->picture, $d[0], $d[1]),
                        "mobileImage" => \Amele::getCdnImageUrl($row->picture, $m[0], $m[1]),
                        "slug" => $row->url,
                        "title" => $row->title,
                        "thumb" => \Amele::getCdnImageUrl($row->smallPicture, 65, 48),
                        "bgColor" => $row->bgColor,
                        "product" => $product,
                        "orderNumber" => $row->orderNumber,
                    ];
                }
            }
            $slider->items = $items;
            return $slider;
        }
        return false;
    }

    public static function mega_menu(){
        $params = [
            'orderby'=> 'orderNumber'
        ];
        $items = Category::getCategories($params);
        $categories = [];
        foreach($items as $categoryKey=>$category){
            if($category->id==self::firstCategoryId){
                $firstCategory = $category;
                unset($categories[$categoryKey]);
            } else {
                $categories[$category->id] = $category;
            }
        }
        $megaMenu = [
            'categories'=>$categories,
            'first_category'=>$firstCategory,
        ];
        return $megaMenu;
    }
}
