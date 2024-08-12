<?php

namespace App\Models;

use App\Api\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MemberAddress extends Model{
    protected $table = 'member_addresses';
    protected $fillable = [
        'idMember',
        'addressType',
        'addressDescription',
        'address',
        'country',
        'city',
        'state',
        'phone',
        'gsm',
        'companyName',
        'taxOffice',
        'taxNo',
    ];
    protected $hidden = [];

}
