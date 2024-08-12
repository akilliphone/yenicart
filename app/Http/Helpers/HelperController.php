<?php

namespace App\Http\Helpers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class HelperController extends Controller {
    public static function getDistricts(){
        $districts = DB::table('citystate')->get(['City','State']);
        if(!$districts->isEmpty()){
            return $districts;
        }
        return [];
    }
    public static function getCities(){
        $cities = DB::table('citystate')->groupBy('City')->get('City');
        if(!$cities->isEmpty()){
            return $cities;
        }
        return [];
    }
    public static function getCountries(){
        $countries = DB::table('citystate')->groupBy('Country')->get('Country');
        if(!$countries->isEmpty()){
            return $countries;
        }
        return [];
    }
    public static function formatted_price($value, $currency=null){
        if($currency===null) $currency = '₺';
        if(floatval($value)){
            $value = number_format($value, 2, ',', '.');
        }
        return $value.'₺';
    }
    public static function birAyOncekiTarih($format = 'Y-m-d H:i:s'){
        $bir_ay_once = date($format, strtotime('-1 month'));
        return $bir_ay_once;
    }
    public static function userGet($key){
        $member = request()->session()->get('member');
        if($member){
            $values = $member->getAttributes();
           return isset($values[$key])?$values[$key]:'';
        }
        return null;
    }
    /*public static function getSessionUser(Request $request=null){
        if($request===null){
            $request = request();
        }
        return $request->session()->get('member');
    }*/
    public static function getSessionMemberId(Request $request=null){
        if($request===null){
            $request = request();
        }
        return $request->session()->get('MEMBER_ID');
    }
    public static function getMemberInfo(){
        if(defined('MEMBER_ID')){
            $query = DB::table('member');
            $query->where(['id' => MEMBER_ID]);
            $member = $query->first();
            if ($member) {
                $member->typename = self::getMemberGroupName($member->idMemberGroup);
                $member->password = null;
                return $member;
            }
        }
        return [];
    }
    public static function getMemberAddresses(){
        if(defined('MEMBER_ID')){
            $query = DB::table('member_addresses');
            $query->where(['idMember' => MEMBER_ID]);
            $address = $query->get();
            if($address) {
                return $address;
            }
        }
        return [];
    }
    public static function isLogged(){
        return defined('MEMBER_ID')?MEMBER_ID:false;
    }
    public static function getMemberGroupName($id){
        $results = DB::select("SELECT * FROM `member_groups` WHERE id = :id LIMIT 1", ['id' => $id]);
        if($results){
            return $results[0]->groupName;
        }
        return 'Tanımsız Grup';
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

        if(isset($response['data']['redirect'])){
            $response['redirect'] = $response['data']['redirect'];
        }

        if(!isset($response['message'])){
            $response['message'] = null;
        }
        if(!isset($response['js_function'])){
            $response['js_function'] = null;
        }
        $response['MEMBER_TYPE']=defined('MEMBER_TYPE')?MEMBER_TYPE:0;

        return $response;
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
    public static function getProductStars($raiting){
        $raiting = max(4, $raiting);
        return self::getStars($raiting);
    }
    public static function getStars($raiting){
        $raiting = min(5, (int)$raiting);

        $goldStars = $raiting;
        $emptyStar = 5-$raiting;
        $html = '';
        for($i=0; $i<$goldStars; $i++){
            $html .= '<span><img src="'.url('assets/images/full-star.svg').'" alt="Star"></span>';
        }
        for($i=0; $i<$emptyStar; $i++){
            $html .= '<span><img src="'.url('assets/images/empty-star.svg').'" alt="Star"></span>';
        }
        return $html;
    }
    public static function humanDate($date = NULL, $format = 'd.m.Y') {
        if ($date === NULL) $date = date('Y-m-d');
        return date($format, strtotime($date));
    }
    public static function addPaymentLog($payment_type, $response, $order, $basket, $order_id=0 ){
        try {
            $basket_id = !empty($basket)?$basket->getBasketId():0;
            $response = json_encode($response, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            $order = json_encode($order, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            $basket = json_encode($basket, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            DB::table('payment_logs')->insert([
                'session_id'=> session()->getId(),
                'basket_id'=>$basket_id,
                'order_id'=>$order_id,
                'payment_type'=>$payment_type,
                'response'=>$response,
                'order_data'=>$order,
                'basket'=>$basket
            ]);
        } catch (\Exception $exception){

        }
    }
    public static function addFailedLog($module, $message='', $data=[] ){
        $id = 0;
        if(mb_strlen($message)>1024){
            $message = mb_substr($message,0, 1024);
        }
        try {
            $data = json_encode($data, JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE);
            $id = DB::table('failed_logs')->insertGetId([
                'module'=> $module,
                'message'=>$message,
                'data'=>$data,
            ]);
        } catch (\Exception $exception){

        }
        return $id;
    }
    public static function stars($value){
        $value = intval($value);
        $html = '<div>';
        for ($i=0; $i<$value; $i++){
            $html .= '<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="18px" width="18px" version="1.1" id="Capa_1" viewBox="0 0 47.94 47.94" xml:space="preserve">
<path style="fill:#ED8A19;" d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757  c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042  c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685  c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528  c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956  C22.602,0.567,25.338,0.567,26.285,2.486z"/>
</svg></span> ';
        }
        for ($i=$value; $i<5; $i++){
            $html .= '<span><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" height="18px" width="18px" version="1.1" id="Capa_1" viewBox="0 0 47.94 47.94" xml:space="preserve">
<path style="fill:#d8d8d8;" d="M26.285,2.486l5.407,10.956c0.376,0.762,1.103,1.29,1.944,1.412l12.091,1.757  c2.118,0.308,2.963,2.91,1.431,4.403l-8.749,8.528c-0.608,0.593-0.886,1.448-0.742,2.285l2.065,12.042  c0.362,2.109-1.852,3.717-3.746,2.722l-10.814-5.685c-0.752-0.395-1.651-0.395-2.403,0l-10.814,5.685  c-1.894,0.996-4.108-0.613-3.746-2.722l2.065-12.042c0.144-0.837-0.134-1.692-0.742-2.285l-8.749-8.528  c-1.532-1.494-0.687-4.096,1.431-4.403l12.091-1.757c0.841-0.122,1.568-0.65,1.944-1.412l5.407-10.956  C22.602,0.567,25.338,0.567,26.285,2.486z"/>
</svg></span> ';
        }
        $html .= '</div>';
        return $html;
    }
}
