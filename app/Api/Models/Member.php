<?php

namespace App\Api\Models;


use Firebase\JWT\JWT;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model{
    protected $table = 'member';
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /*public function createJwtToken(){
        $key = env('JWT_SECRET', 'empty');
        $credentials = [
            'id'=>$this->id,
            'firstname'=>$this->name,
            'lastname'=>$this->surNname,
            'email'=>$this->email,
            'membergroup'=>$this->idMemberGroup,
            'typename'=>self::getMemberGroupName($this->idMemberGroup),
        ];
        return JWT::encode($credentials, $key, 'HS256');
    }*/
    public static function getMemberGroupName($id){
        $results = DB::select("SELECT * FROM `member_groups` WHERE id = :id LIMIT 1", ['id' => $id]);
        if($results){
            return $results[0]->groupName;
        }
        return 'Tanımsız Grup';
    }
    public static function getLoggedMemberId(){
        return defined('MEMBER_ID')?MEMBER_ID:false;
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
    public static function addNewsletter($email){
        $result = [
            'status'=>0,
            'message'=>''
        ];
        $query = DB::table('news_letter');
        $query->where(['email' => $email]);
        if ($member = $query->first()) {
            $result['message'] = $email.' emaili daha önce sisteme kaydedilmiş.';
        } else {
            $data = [
                'member_id' => MEMBER_ID,
                'email' => $email,
                'status' => 1,
                'aciklama' => 1,
                'reklam' => 1,
                'duyuru' => 1,
                'bulten' => 1,
                'satis' => 1,
                'from_mobile' => 0,
            ];
            $id = DB::table('news_letter')->insert($data);
            if($id){
                $result['status'] = 1;
                $result['message'] = $email.' emailiniz  sisteme kaydedildi.';
            } else{
                $result['message'] = $email.' emailinizi sisteme kaydedemedik. Lütfen daha sonra tekrar deneyiniz.';
            }
        }
        return $result;
    }
}
