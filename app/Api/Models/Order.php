<?php

namespace App\Api\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model{
    protected $table = 'orders';
    protected $fillable = [];

    protected $hidden = [];

    protected $basket;
    protected $customer;

    public function setBasket($basket){
        $this->basket = $basket;
    }
    public function setCustomer($customer){
        $this->customer = $customer;
    }
    public function getBasket(){
        return $this->basket;
    }
}
