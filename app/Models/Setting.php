<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Setting extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [];
    public static function getSeoSettings(){
        $query = DB::table('settings_seo');
        $query->offset(0);
        $query->limit(1);
        $settings = $query->first();
        if ($settings) {
            return $settings;
        }
        return [];
    }
    public function getOtherSettings(){
        $sql="SELECT * FROM settings_other LIMIT 1";
        $sth = $this->_db->prepare($sql);
        $sth->execute();
        $ret=$sth->fetch(PDO::FETCH_ASSOC);
        return $ret;
    }
    public static function getConfigGeneral(){
        $query = DB::table('settings_general');
        $query->offset(0);
        $query->limit(1);
        $settings = $query->first();
        if ($settings) {
            return $settings;
        }
        return [];
    }

}
