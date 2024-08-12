<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;


class Provider extends Model{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'provider';
    protected $fillable = [
    ];

    protected $hidden = [
    ];
    public static function getProvider($idProvider){
        $result = [];
        $query = DB::table('provider');

        $query->where(['id'=>$idProvider]);
        $row = $query->first();
        if($row){
            $row->url = \Amele::getProviderUrl($row);
            $row->logo = \Amele::getCdnImageUrl($row->logo, 100,100);
            $result = $row;
        }
        return $result;
    }


}
