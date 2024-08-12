<?php

namespace App\Api\Helpers;

use App\Http\Controllers\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Http\Request;

class Amele extends Controller
{
    public static function formatted_price($value, $currency=null){
        if($currency===null) $currency = '₺';
        if(floatval($value)){
            $value = number_format($value, 2, ',', '.');
        }
        return $value.$currency;
    }
    public static function birAyOncekiTarih($format = 'Y-m-d H:i:s'){
        $bir_ay_once = date($format, strtotime('-1 month'));
        return $bir_ay_once;
    }
    public static function successResponse($data, $message, $duration=0){
        return self::response(['status'=>1, 'data'=>$data, 'message'=>$message, 'duration'=>$duration]);
    }
    public static function errorResponse($data, $message, $duration=0){
        return self::response(['status'=>0, 'data'=>$data, 'message'=>$message, 'duration'=>$duration]);
    }
    private static function response($response){
        if(!isset($response['duration'])){
            $response['duration'] = 0;
        }
        if(!isset($response['status'])){
            $response['status'] = 1;
        }
        if(!isset($response['date'])){
            $response['date'] = date('Y-m-d H:i:s');
        }
        if(!isset($response['data'])){
            $response['data'] = [];
        }
        if(!isset($response['message'])){
            $response['message'] = null;
        }
        if(!isset($response['js_function'])){
            $response['js_function'] = null;
        }
        $response['MEMBER_TYPE']=defined('MEMBER_TYPE')?MEMBER_TYPE:0;
        //ksort($response);
        return $response;
    }
    public static function getRequestToken(Request $request){
        $authorizationHeader = $request->header('Authorization');
        if ($authorizationHeader && preg_match('/^Bearer\s+(.*?)$/', $authorizationHeader, $matches)) {
            $jwtToken = $matches[1];
            try {
                $JWT_SECRET = env('JWT_SECRET', 'empty');
                $decodedToken = JWT::decode($jwtToken, new Key($JWT_SECRET, 'HS256'));
                return $decodedToken;
            } catch (\Exception $e) {
                return false;
            }
        } else {
            return null;
        }
    }
    public static function getCdnImageUrl($url, $w=false, $h=false, $cdnx=false){

        $url = trim($url,'/');
        $parts = explode('/',$url);
        $port = isset($parts[0])?$parts[0]:'8004';
        $ports['up']='8000';
        $ports['up2']='8001';
        $ports['up3']='8002';
        $ports['upwater']='8003';
        $ports['img']='8004';
        unset($parts[0]);
        foreach($parts as $key=>$part){
            $parts[$key] = html_entity_decode($part, ENT_QUOTES, "UTF-8");
        }
        if($cdnx){
            $sub = 'https://cdn-x.akilliphone.com/';
        } else{
            $sub = env('CDN_URL');
        }
        if(empty($w)) $w=160;
        if(empty($h)) $h=160;
        if($w && $h && isset($ports[$port]))
        {
            $result = $sub.$ports[$port].'/'.$w.'x'.$h.'/'.(implode('/',$parts));
        } else {
            $result = $sub.urlencode($url);
        }
        return $result;

    }
    public static function getProductUrl($product){
        $slug = self::getPermalink($product->productName);
        return url('incele/'.$slug.'-'.$product->id);
    }
    public static function getCategoryUrl($category){
        $slug = self::getPermalink($category->categoryName);
        return url('reyonlar/'.$slug.'-'.$category->id);
    }
    public static function getProviderUrl($provider){
        $slug = self::getPermalink($provider->providerName);
        return url('reyonlar/?provider='.$provider->id);
    }
    public static function getPermalink($text, $options = array(), $lowercase=true) {

        $text = preg_replace('~[^\p{L}\p{N}]+~u', '-', $text);
        $transliteration = array(
            'ı' => 'i', 'İ' => 'I', 'ş' => 's', 'Ş' => 'S', 'ğ' => 'g', 'Ğ' => 'G',
            'ü' => 'u', 'Ü' => 'U', 'ö' => 'o', 'Ö' => 'O', 'ç' => 'c', 'Ç' => 'C',
            'ä' => 'a', 'Ä' => 'A', 'ë' => 'e', 'Ë' => 'E', 'ï' => 'i', 'Ï' => 'I',
            'ö' => 'o', 'Ö' => 'O', 'ü' => 'u', 'Ü' => 'U', 'ÿ' => 'y', 'Ÿ' => 'Y',
            'ß' => 'ss', 'á' => 'a', 'é' => 'e', 'í' => 'i', 'ó' => 'o', 'ú' => 'u',
            'Á' => 'A', 'É' => 'E', 'Í' => 'I', 'Ó' => 'O', 'Ú' => 'U',
        );
        $text = strtr($text, $transliteration);
        $text = preg_replace('~-+~', '-', $text);
        $text = trim($text, '-');

        return $lowercase ? mb_strtolower($text, 'UTF-8') : $text;
    }

}
