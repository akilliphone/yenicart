<?php
namespace App\Api\Controllers;
use App\Api\Models\Order;
use App\Api\Models\OrderItem;
use App\Helpers\BasketService;
use App\Helpers\CurrencyCodes;
use Illuminate\Support\Facades\DB;

class OrderService{
    public static function newOrder(){
        $order = new Order();
        return $order;
    }
    public static function find($orderId){
        $order = Order::find($orderId);
        return $order;
    }
    public static function currentOrder(){
        $order = new Order();
        $basket = BasketService::getBasket();

        $order->setBasket($basket);
        $order->idMember = $basket->userId;
        $order->cargoAddress = $basket->shippingAddress['addressLine1'];
        $order->cargoCity = $basket->shippingAddress['cityId'];
        $order->cargoAddressTitle = $basket->shippingAddress['name'];
        $order->cargoAddressType = null;
        $order->cargoGsm = $basket->shippingAddress['phone'];
        $order->invoiceSame = null;
        $order->invoiceAddress = $basket->billingAddress['addressLine1'];
        $order->invoiceCity = $basket->billingAddress['cityId'];
        $order->invoiceAddressTitle = $basket->billingAddress['name'];
        $order->invoiceAddressType = null;
        $order->invoiceGsm = $basket->billingAddress['phone'];
        $order->invoiceNote = '';
        $order->paymentTotal = $basket->total;
        $order->cargoTotal = $basket->shippingTotal;
        $order->discountTotal = 0;
        $order->invoiceNumber = '';
        $order->cargoName = $basket->customer['firstName'].' '.$basket->customer['lastName'];
        $order->name = $basket->customer['firstName'];
        $order->surName = $basket->customer['lastName'];
        $order->email = $basket->customer['email'];
        $order->invoiceCompanyName = $basket->billingAddress['company'];
        $order->invoiceTaxOffice = $basket->billingAddress['taxOffice'];
        $order->invoiceTaxNo = $basket->billingAddress['taxNumber'];
        $order->invoiceTcNo = '';
        $order->orderNumber = '';
        $order->orderDate = date('Y-m-d H:i:s');
        $order->orderNote = '';
        $order->memberType = 0;
        $order->instalment_number = 0;
        $order->instalment_total = 0;
        $order->kargo_firma = $basket->billingAddress['taxNumber'];
        $order->from_mobile = 0;
        $order->dropshipping = 0;
        $order->dropshipping_total = 0;
        $order->orderState = 0;
        $order->cargoState = 0;
        $order->invoiceState = 0;
        $order->paymentState = 0;
        $order->paymentType = 0;
        $order->iyzico_token = '';
        //$order->IdentificationNumber = '';
        //$order->cargoPhone = '';
        //$order->invoicePhone = '';
        //$order->paymentRef = '';
        //$order->paymentPrice = '';
        //$order->cargoNumber = '';
        //$order->cargoDate = '';
        //$order->cargoUrl = '';
        //$order->giftPacket = '';
        //$order->giftPrice = '';
        //$order->payuRef = '';
        //$order->payuTrans = '';
        //$order->payuState = '';
        //$order->paidTotal = '';
        //$order->cargoCompanyName = '';
        //$order->cargoTaxOffice = '';
        //$order->cargoTaxNo = '';
        //$order->lastDate = '';
        //$order->phone = '';
        //$order->gsm = '';
        //$order->smsWarning = '';
        //$order->couponCode = '';
        //$order->adminNote = '';
        //$order->posTransaction = '';
        //$order->formValues = '';
        //$order->errorDetail = '';
        //$order->balanceUse = '';
        //$order->adminNote2 = '';
        //$order->adminNote3 = '';
        //$order->adminNote4 = '';
        //$order->adminNote5 = '';
        //$order->where = '';
        //$order->cargoType = '';
        //$order->isDeleted = '';
        //$order->deletedIp = '';
        //$order->sendKargoSms = '';
        //$order->iyzico_token = '';
        //$order->hide_list`
        return $order;
    }
    public static function create_order($order){
        $orderNumber = self::get_new_order_number($order);
        $order->orderNumber = $orderNumber;
        $order->save();
        if($orderId = $order->id){
            if($basket = $order->getBasket()){
                foreach ($basket->basketItems as $item){
                    $orderItem = self::create_order_item($orderId, $item);
                }
            }

        }

        return [
            'orderId' => $order->id,
            'orderNumber' => $order->orderNumber,
            'total' => $order->total,
            'orderStatusId' => $order->orderState,
            'paymentStatusId' => $order->paymentState,
        ];
    }
    static function  create_order_item($orderId, $item){
        $orderItem = new OrderItem();
        $orderItem->idOrder = $orderId;
        $orderItem->idProduct = $item['productId'];
        $orderItem->idColor = $item['colorId'];
        $orderItem->idProductSet = 0;
        $orderItem->amount = $item['quantity'];
        $orderItem->price = $item['price'];
        $orderItem->kampanya_price = 0;
        $orderItem->idCurrency = CurrencyCodes::TL;
        $orderItem->isDeleted = 0;
        $orderItem->deleteFor = '';
        $orderItem->isChanged = 0;
        $orderItem->isReturn = 0;

        $orderItem->returnWhy = '';
        $orderItem->returnMessage = '';
        $orderItem->returnType = 0;
        $orderItem->returnCargo = '';
        $orderItem->returnCargoTrack = '';
        $orderItem->returnIBAN = '';
        $orderItem->where = -1;
        $orderItem->siparisTarihi = date('Y-m-d H:i:s');
        $orderItem->pazaryeri = $item['marketplaceId'];
        $orderItem->siparisno = $item['marketplaceOrderCode'];
        $orderItem->kargokodu = $item['shippingTrackingNumber'];
        $orderItem->taxRate = 0;

        $orderItem->save();
        return $orderItem;

    }
    public static function get_new_order_number($order){
        return DB::table('orderNumberCreator')->insertGetId(
                [
                    'createdate'=>date('Y-m-d H:i:s'),
                    'ip'=>'',
                    'platform'=>'desktop'
                ]
            );

    }
    public static function create_order_history($orderHistory){

    }
}
