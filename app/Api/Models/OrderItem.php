<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model{
    protected $table = 'orders_detail';
    protected $fillable = ['idOrder', 'idProduct', 'idColor', 'idProductSet', 'amount', 'price', 'kampanya_price', 'idCurrency', 'isDeleted', 'deleteFor', 'isChanged', 'isReturn', 'returnWhy', 'returnMessage', 'returnType', 'returnCargo', 'returnCargoTrack', 'returnIBAN', 'where', 'siparisTarihi', 'pazaryeri', 'siparisno', 'kargokodu', 'taxRate'];

    protected $hidden = [];

}
