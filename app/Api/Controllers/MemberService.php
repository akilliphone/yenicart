<?php

namespace App\Api\Controllers;

use App\Api\Models\Member;
use App\Helpers\MemberTypes;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MemberService extends Controller {
    public function login( Request $request){
        $jsonBody = $request->json()->all();
        $email = isset($jsonBody['email'])?$jsonBody['email']:null;
        $password = isset($jsonBody['password'])?$jsonBody['password']:null;
        $membertype = isset($jsonBody['membertype'])?$jsonBody['membertype']: MemberTypes::UYE;
        return self::asLogin($email, $password, $membertype) ;
    }
    public static function formLogin( Request $request){
        $email = $request->input('email');
        $password = $request->input('password');
        $membertype = $request->input('membertype');
        return self::asLogin($email, $password, $membertype) ;
    }
    public static function asLogin($email, $password, $membertype){

        if($email && $password){
            if($member = Member::where(['email'=>$email, 'password'=>md5($password), 'idMemberGroup'=>$membertype])->first()){
                $jwtToken = '';//$member->createJwtToken();
                return \Amele::successResponse(['jwtToken'=>$jwtToken], 'Başarılı');
            }
        }
        return \Amele::errorResponse([], 'Kullanıcı Bulunamadı. Kullanıcı adınızı ve şifrenizi kontrol ederek tekrar deneyiniz');
    }
    public function addNewsletter(Request $request){
        if($email = $request->input('email')){
            $response = Member::addNewsletter($email);
            if($response['status']){
                return \Amele::successResponse(null, $response['message']);
            } else{
                return \Amele::errorResponse(null, $response['message']);
            }
        } else {
            return \Amele::errorResponse(null, 'Hatalı email adresi. Lütfen kontrol edip tekrar deneyiniz');
        }
    }
}
