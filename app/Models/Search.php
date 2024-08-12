<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;

class Search extends Authenticatable
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
    public static function fixPropductFilter($filters){
        $filters['id'] = isset($filters['id'])?$filters['id']:false;
        $filters['text'] = isset($filters['text'])?$filters['text']:'';
        $filters['category'] = isset($filters['category'])?$filters['category']:'';
        $filters['provider'] = isset($filters['provider'])?$filters['provider']:'';
        $filters['color'] = isset($filters['color'])?$filters['color']:'';
        $filters['pricelow'] = isset($filters['pricelow'])?$filters['pricelow']:'';
        $filters['pricehigh'] = isset($filters['pricehigh'])?$filters['pricehigh']:'';
        $filters['variyantasproduct'] = isset($filters['variyantasproduct'])?$filters['variyantasproduct']:0;
        $filters['offset'] = isset($filters['offset'])?$filters['offset']:0;
        $filters['limit'] = isset($filters['limit'])?$filters['limit']:24;
        $filters['orderby'] = isset($filters['orderby'])?$filters['orderby']:false;
        $filters['dir'] = isset($filters['dir'])?$filters['dir']:false;
        $filters['custom'] = isset($filters['custom'])?$filters['custom']:false;
        return $filters;
    }


}
