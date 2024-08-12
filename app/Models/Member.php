<?php

namespace App\Models;

use App\Api\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Member extends Model{
    protected $table = 'member';
    protected $fillable = [ 'name', 'surName', 'email', 'password', 'tckimlik', 'gsm', 'idMemberGroup', 'taxOffice', 'taxNumber', 'companyName' ];
    protected $hidden = [];
    public static function orders($memberId, $page=1){
        $orders = [];
        $limit = 100;
        $offset = ($page-1)* $limit;
        $rows =  DB::table('orders')
            ->where(['idMember'=>$memberId ])
            ->orderByDesc('id')
            ->offset($offset)
            ->limit($limit)
            ->get();
        if(!$rows->isEmpty()){
            foreach($rows as $row){
                $row->productCount =  DB::table('orders_detail')
                    ->where(['idOrder'=>$row->id ])
                    ->count();

                $orders[] = $row;
            }
        }

        return $orders;
    }
    public static function orderDetail($memberId, $orderID){
        $order = [];
        $row =  DB::table('orders')
            ->where(['idMember'=>$memberId , 'id'=>$orderID])
            ->first();
        if($row){
            $row->productCount =  DB::table('orders_detail')
                ->where(['idOrder'=>$row->id ])
                ->count();
            $rows =  DB::table('orders_detail')
                ->where(['idOrder'=>$row->id ])
                ->orderByDesc('id')
                ->get();
            if(!$rows->isEmpty()){
                $items = [];
                foreach($rows as $detail){
                    $item['detail'] = $detail;
                    $product = Product::productDetail($detail->idProduct, $detail->idColor);
                    if($product){

                        $item['product'] = $product;
                    } else {
                        $item['product'] = [];
                    }
                    $items[] = $item;
                }
                $row->items = $items;
            } else {
                $row->items = [];
            }
            $order = $row;
        }
        return $order;
    }
    public static function addresses($memberId){
        $query = MemberAddress::where(['idMember'=>$memberId])->get();
        if(!$query->isEmpty()){
            return $query->all();
        }
        return [];
    }
    public static function address($addressId, $memberId){
       $row = MemberAddress::where(['id'=>$addressId, 'idMember'=>$memberId])->first();
       return $row?$row:new MemberAddress();
    }
    public static function wishList($memberId, $page=0){
        $wishList = [];
        $limit = 100;
        $offset = ($page-1)* $limit;
        $rows =  DB::table('wish_list')
            ->where(['member_id'=>$memberId ])
            ->orderByDesc('id')
            ->offset($offset)
            ->limit($limit)
            ->get();
        if(!$rows->isEmpty()){
            foreach($rows as $row){
                $product =  Product::productDetail($row->product_id);
                if($product){
                    $wishList[] = $product;
                }
            }
        }
        return $wishList;
    }
    public static function comments($memberId, $page=0){
        $comments = [];
        $limit = 100;
        $offset = ($page-1)* $limit;
        $rows =  DB::table('product_reviews')
            ->where(['idMember'=>$memberId, 'isQuestion'=>0 ])
            ->orderByDesc('id')
            ->offset($offset)
            ->limit($limit)
            ->get();
        if(!$rows->isEmpty()){
            foreach($rows as $row){
                $row->product  =  Product::productDetail($row->idProduct);
                $comments[] = $row;
            }
        }
        return $comments;
    }
    public static function refund($memberId, $orderID, $orderDetailId, $refund){
        $orderUpdate = DB::table('order')->where(['idMember'=>$memberId , 'id'=>$orderID])->update(['orderState'=>17]);
        $sql="UPDATE orders_detail set returnIBAN=?,isReturn=1, returnWhy=?, returnMessage=?, returnType=?,returnCargo=?,returnCargoTrack=? where id=?";
        DB::table('order_detail')->where(['id'=>$orderDetailId, 'idOrder'=>$orderID])->update($refund);
        $ticket["idOrderDetail"]=$orderDetailId;
        $ticket["idMember"]=$memberId;
        $ticket["nameSurname"]= member_get('name').' '.member_get('surName');
        $ticket["ticketType"]=6;
        $ticket["email"]=member_get('email');
        $ticket["message"]= $refund['returnMessage']."<br>Kargo :".$refund['returnCargo'].",".$refund['returnCargoTrack']."<br>IBAN:".$refund['returnIBAN'];
        $ticket["picture"]  ="";
        return DB::table('ticket')->insertGetId($ticket);

    }

    public function fullName(){
        return $this->name.' '.$this->surName;
    }

}
