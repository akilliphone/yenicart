<?php
namespace App\Helpers;
use App\Http\Helpers\HelperController;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Api\Models\Product;
use App\Api\Helpers\Amele;

class BasketService{
    protected $sessionId;
    public $basketId;
    public $userId;
    public $shippingAddress;
    public $billingAddress;
    public $orderType;
    public $basketItems=[];
    public $basketProductCount;
    public $basketItemCount;
    public $customer;
    public $basketSubtotals;
    public $shippingTotal;
    public $total;
    public $alerts=[];
    public $flashes=[];
    protected $created_dt;
    public $mini;
    public $table;
    public $freeShippingLimit;
    public $shippingBrand;
    public $shippingBrands;
    public $lastVieweds = [];
    const lastShippingHour=17;
    function __construct() {
        $this->basketId = time();
        $this->basketSubtotals = [
            'products'=>[],
            'shipping'=>[]
        ];
        $this->created_dt = date('Y-m-d H:i:s');
        $this->freeShippingLimit = 300;
        $this->shippingBrands = [
            'aras'=>[
                'code'=>'aras',
                'title'=>'Aras Kargo',
                'icon'=> url('assets/images/aras.svg'),
                'price'=>60,
                'checked'=>'checked',
            ]
        ];
    }
    static function getFreeShippingLimit(){
        $basket = self::getBasket();
        return $basket->freeShippingLimit;
    }
    static function clear(){
        $basket = new  BasketService();
        session()->put('basket', $basket);
    }

    static function getBasketId(){
        $basket = self::getBasket();
        return $basket->basketId;
    }
    static function addProduct($idProduct, $idColor, $quantity, $fixQuantity=false, $dropshipping=[]){
        $product = Product::productDetail($idProduct, $idColor);
        $variant = isset($product->variants)?current($product->variants):[];
        $quantity = (int)$quantity;
        $optionId = 0;
        $optionQuantity = 0;
        $basket = self::getBasket();
        $basket->flashes = [];
        $itemCode = $variant->idProduct.'-'.$variant->idColor;
        if(!$fixQuantity){
            if(isset($basket->basketItems[$itemCode])){
                $quantity += $basket->basketItems[$itemCode]['quantity'] ;
            }
        }
        $optionQuantity = $variant->amount;

        if($quantity===0){
            unset($basket->basketItems[$itemCode]);
            $basket->flashes[] = 'Ürün sepetten silindi';
        }elseif(empty($quantity)){
            $basket->flashes[] = 'Ürün adedi enaz 1 olmalıdır';
        } elseif($quantity>10){
            $basket->flashes[] = 'İzin verilen sipariş adetini aştınız ';
        } elseif($optionQuantity<$quantity){
            $basket->flashes[] = 'İstenen adette ürün sağlanamamıyor ';
        } else {
            if(isset($basket->basketItems[$itemCode])){
                $basket->basketItems[$itemCode]['quantity'] = $quantity;
                $basket->basketItems[$itemCode]['total'] =  $product['sale_price'] * $basket->basketItems[$itemCode]['quantity'];
            } else {
                $basketItem = [
                    'itemCode' => $itemCode,
                    'productId' => $variant->idProduct,
                    'colorId' => $variant->idColor,
                    'optionId' => $optionId,
                    'code' => $variant->barcode,
                    'url' => $product['url'],
                    'featuredImage' => $product['thumb'],
                    'name' => $variant->barcode,
                    'price' => $product['sale_price'],
                    'quantity' => $quantity,
                    'total' => $product['sale_price'] * $quantity,
                    'formatted_total' =>  Amele::formatted_price($product['sale_price'] ),
                    'discount'=>0,
                    'productName' => $product['productName'],
                    'productCode' => $product['productCode'],
                    "marketplaceId" => 0,
                    "marketplaceOrderCode" => "",
                    "shippingTrackingNumber" => "",
                    'itemType' => 'product',
                    'alert' => [],
                ];
                $basket->basketItems[$itemCode] = $basketItem;
            }
            if($dropshipping){
                $basket->basketItems[$itemCode]['marketplaceId'] = isset($dropshipping['marketplaceId'])?$dropshipping['marketplaceId']:0;
                $basket->basketItems[$itemCode]['marketplaceOrderCode'] = isset($dropshipping['marketplaceOrderCode'])?$dropshipping['marketplaceOrderCode']:0;
                $basket->basketItems[$itemCode]['shippingTrackingNumber'] = isset($dropshipping['shippingTrackingNumber'])?$dropshipping['shippingTrackingNumber']:0;
            }
        }
        self::setBasket($basket);
    }
    static function removeProduct($itemCode){
        $basket = self::getBasket();
        unset($basket->basketItems[$itemCode]);
        self::setBasket($basket);
    }
    static function setShipping($brand){
        $basket = self::getBasket();
        //$basket->shippingBrand = "";
        if(isset($basket->shippingBrands[$brand] )){
            $basket->shippingBrand =  $brand;
            $basket->basketSubtotals['shipping'] = [
                'code'=>'shipping',
                'title'=>$basket->shippingBrands[$brand]['title'],
                'total'=>$basket->shippingBrands[$brand]['price'],
                'formatted_total'=>Amele::formatted_price($basket->shippingBrands[$brand]['price']),
            ];
            $basket->shippingBrands[$brand]['checked'] = 'checked';

        }
        if(empty($basket->shippingBrand)){
            $basket->shippingBrand =  'aras';
            $basket->basketSubtotals['shipping'] = [
                'code'=>'shipping',
                'title'=>$basket->shippingBrands[$brand]['title'],
                'total'=>$basket->shippingBrands[$brand]['price'],
                'formatted_total'=>Amele::formatted_price($basket->shippingBrands[$brand]['price']),
            ];
            $basket->shippingBrands[$brand]['checked'] = 'checked';
        }
        if(isset($basket->basketSubtotals['shipping'])){
            $basket->shippingTotal = $basket->basketSubtotals['shipping']['total'];
        } else{
            $basket->shippingTotal = 0;
        }
        self::setBasket($basket);
    }
    /*static function setDefaultShipping(&$basket){
        if($basket && empty($basket->shippingBrand)){
            $brand = 'aras';
            $basket->shippingBrand =  $brand;
            $basket->basketSubtotals['shipping'] = [
                'code'=>'shipping',
                'title'=>$basket->shippingBrands[$brand]['title'],
                'total'=>$basket->shippingBrands[$brand]['price'],
            ];
            $basket->shippingBrands[$brand]['checked'] = 'checked';
            self::setBasket($basket);
        }
    }*/
    static function getBasket(){
        $basket = session()->get('basket');

        //self::setDefaultShipping($basket);
        if(empty($basket)){
            $basket = new  BasketService();
            session()->put('basket', $basket);
        }
        if(empty($basket->shippingBrand)){
            $basket->shippingBrand =  'aras';
            $basket->basketSubtotals['shipping'] = [
                'code'=>'shipping',
                'title'=>$basket->shippingBrands['aras']['title'],
                'total'=>$basket->shippingBrands['aras']['price'],
            ];
            $basket->shippingBrands['aras']['checked'] = 'checked';
            //print_r([$basket->shippingBrand, $basket->basketSubtotals,]);
            //$basket = self::setBasket($basket);
            //dd($basket);

        }
        $basket = self::setBasket($basket);
        return $basket;
    }
    static function setBasket($basket){
        if(empty($basket)){
            $basket = new BasketService();
        }
        $basket = self::calculateBasket($basket);
        session()->put('basket', $basket);
        return $basket;
    }
    static function calculateBasket($basket){
        $sub_total = 0;
        $item_count = 0;


        if($basket->basketItems){
            foreach($basket->basketItems as $basketItem){
                $sub_total += $basketItem['total'];
                $item_count += $basketItem['quantity'];
            }
            $basket->basketSubtotals['products'] = [
                'code'=>'products',
                'title'=>'Ürünler Toplamı (KDV Dahil)',
                'total'=> $sub_total,
                'formatted_total'=> Amele::formatted_price($sub_total),
            ];
        } else{
            $basket->basketSubtotals['products'] = [
                'code'=>'products',
                'title'=>'Ürünler Toplamı (KDV Dahil)',
                'total'=> 0,
                'formatted_total'=> ''
            ];
            unset($basket->basketSubtotals['shipping']);
            $basket->shippingBrand = null;
        }

        if( $sub_total<$basket->freeShippingLimit ){
            $basket->alerts['freeShippingLimit'] = [
                'class'=>'text-danger',
                'message'=>'Bedava Kargo İçin siparişinizi '.$basket->freeShippingLimit.' TL ye Tamamlayınız',
            ];
        } else {
            $basket->alerts['freeShippingLimit']  = [
                'class'=>'text-success',
                'message'=>'Kargo Bedava',
            ];
            unset($basket->basketSubtotals['shipping']);
            $basket->shippingBrand = null;
        }
        $total = 0;
        if($basket->basketSubtotals){
            foreach($basket->basketSubtotals  as $basketSubtotal){
                if(isset($basketSubtotal['total'])){
                    $total += $basketSubtotal['total'];
                }
            }
        }
        foreach($basket->basketItems as $itekkey=>$basketItem){
            if($sub_total>=$basket->freeShippingLimit){
                $basketItem['alert'] = [
                    'class'=>'text-success',
                    'message'=>'Kargo Bedava',
                ];
            } else{
                $basketItem['alert'] = [];
            }
            $basket->basketItems[$itekkey] = $basketItem;
        }
        $basket->total = $total;
        $basket->formatted_total = Amele::formatted_price($total);
        $basket->basketItemCount = $item_count;
        $basket->productItemCount = count($basket->basketItems);
        //dd($basket);
        $basket->mini = '<img width="26" height="25" src="'.url('assets/images/shopping-icon.svg').'" alt="">
<span class="counter">'.$basket->basketItemCount.'</span>';
        $basket->table = view('basket.table', ['basket'=>$basket, 'showDropshipping'=>request()->input('showDropshipping') ])->render();
        $basket->totals = view('basket.totals', ['basket'=>$basket ])->render();
        return $basket;
    }

    static function getBasketTable($showDropshipping=false){
        $data['basket'] = self::getBasket();
        $data['showDropshipping'] = $showDropshipping;
        return view('basket.table', $data)->render();
    }
    static function toArray(){
        return json_decode( json_encode(self::getBasket(), JSON_UNESCAPED_UNICODE|JSON_PRETTY_PRINT),1);
    }
    static function getItemCount(){
        //return 3;
        $basket = self::getBasket();
        return $basket->basketItemCount;
    }
    static function getProductCount(){
        $basket = self::getBasket();
        return $basket->basketItemCount;
    }
    static function getShippingDayAlert(){
        if(date('w')==0){
            return "Pazartesi Günü Kargoda";
        } elseif(date('w')==7){
            if(date('H')< self::lastShippingHour){
                return "Bugün Kargoda";
            } else {
                return "Pazartesi Günü Kargoda";
            }
        } else{
            if(date('H')<self::lastShippingHour){
                return "Bugün Kargoda";
            } else {
                return "Yarın Kargoda";
            }
        }
    }
    static function setCustomer($customer){
        $customer = is_array($customer)?$customer:[];
        $basket = self::getBasket();
        $basket->customer = [
            'customerId' => isset($customer['customerId'])?$customer['customerId']:null,
            'code' => isset($customer['code'])?$customer['code']:null,
            'firstName' => isset($customer['firstName'])?$customer['firstName']:null,
            'lastName' => isset($customer['lastName'])?$customer['lastName']:null,
            'tcKimlik' => isset($customer['tcKimlik'])?$customer['tcKimlik']:null,
            'phone' => isset($customer['phone'])?$customer['phone']:null,
            'email' => isset($customer['email'])?$customer['email']:null,
        ];

        if($customer = \Help::getMemberInfo()){
            $basket->userId = $customer->id;
            $basket->customer['customerId'] = $customer->id;
            if(empty($basket->customer['firstName'])) $basket->customer['firstName'] = $customer->name;
            if(empty($basket->customer['lastName'])) $basket->customer['lastName'] = $customer->surName;
            if(empty($basket->customer['tcKimlik'])) $basket->customer['tcKimlik'] = $customer->tckimlik;
            if(empty($basket->customer['phone'])) $basket->customer['phone'] = $customer->gsm;
            if(empty($basket->customer['email'])) $basket->customer['email'] = $customer->email;
        }
        self::setBasket($basket);
    }
    static function setShipingAddres($addresss){
        $addresss = is_array($addresss)?$addresss:[];
        $basket = self::getBasket();
        $basket->shippingAddress = [
            'customerId' => $basket->customer['customerId'],
            'countryId' => isset($addresss['countryId'])?$addresss['countryId']:null,
            'cityId' => isset($addresss['cityId'])?$addresss['cityId']:null,
            'districtId' => isset($addresss['districtId'])?$addresss['districtId']:null,
            'firstName' => isset($addresss['firstName'])?$addresss['firstName']:null,
            'lastName' => isset($addresss['lastName'])?$addresss['lastName']:null,
            'name' => isset($addresss['name'])?$addresss['name']:null,
            'description' => isset($addresss['description'])?$addresss['description']:null,
            'addressLine1' => isset($addresss['addressLine1'])?$addresss['addressLine1']:"",
            'addressLine2' => isset($addresss['addressLine2'])?$addresss['addressLine2']:"",
            'country' => isset($addresss['country'])?$addresss['country']:"",
            'city' => isset($addresss['city'])?$addresss['city']:"",
            'district' => isset($addresss['district'])?$addresss['district']:"",
            'zipCode' => isset($addresss['zipCode'])?$addresss['zipCode']:null,
            'latitude' => isset($addresss['latitude'])?$addresss['latitude']:null,
            'longitude' => isset($addresss['longitude'])?$addresss['longitude']:null,
            'placeId' => isset($addresss['placeId'])?$addresss['placeId']:null,
            'phone' => $basket->customer['phone'],
        ];
        self::setBasket($basket);
    }
    static function setBillingAddres($addresss, $invoiceType='bireysel'){
        $addresss = is_array($addresss)?$addresss:[];
        $basket = self::getBasket();
        $basket->billingAddress = [
            'customerId' => $basket->customer['customerId'],
            'countryId' => isset($addresss['countryId'])?$addresss['countryId']:null,
            'cityId' => isset($addresss['cityId'])?$addresss['cityId']:null,
            'districtId' => isset($addresss['districtId'])?$addresss['districtId']:null,
            'firstName' => isset($addresss['firstName'])?$addresss['firstName']:null,
            'lastName' => isset($addresss['lastName'])?$addresss['lastName']:null,
            'name' => isset($addresss['name'])?$addresss['name']:null,
            'description' => isset($addresss['description'])?$addresss['description']:null,
            'addressLine1' => isset($addresss['addressLine1'])?$addresss['addressLine1']:"",
            'addressLine2' => isset($addresss['addressLine2'])?$addresss['addressLine2']:"",
            'country' => isset($addresss['country'])?$addresss['country']:"",
            'city' => isset($addresss['city'])?$addresss['city']:"",
            'district' => isset($addresss['district'])?$addresss['district']:"",
            'zipCode' => isset($addresss['zipCode'])?$addresss['zipCode']:null,
            'latitude' => isset($addresss['latitude'])?$addresss['latitude']:null,
            'longitude' => isset($addresss['longitude'])?$addresss['longitude']:null,
            'placeId' => isset($addresss['placeId'])?$addresss['placeId']:null,
            'phone' => isset($addresss['phone'])?$addresss['phone']:$basket->customer['phone'],
            'company' => isset($addresss['company'])?$addresss['company']:null,
            'taxOffice' => isset($addresss['taxOffice'])?$addresss['taxOffice']:null,
            'taxNumber' => isset($addresss['taxNumber'])?$addresss['taxNumber']:null,
            'invoiceType' => $invoiceType,
        ];

        self::setBasket($basket);
    }

    static function setLastViewed($product){
        $basket = self::getBasket();
        if($product){
            if(count($basket->lastVieweds)>8){
                array_shift($basket->lastVieweds);
            }
            $basket->lastVieweds[$product->id] = $product;
        }
        self::setBasket($basket);
    }
    static function getLastVieweds(){
        $basket = self::getBasket();
        return $basket->lastVieweds;
    }
    static function getCountryName($countryId){
        if($countryId==2){
            return 'Türkiye';
        } elseif($countryId==4){
            return 'Kuzey Kıbrıs';
        }
        return 'Belirtilmemiş';
    }
    static function getCityName($cityId){
        if($cityId==2){
            return 'Türkiye';
        } elseif($cityId==4){
            return 'Kuzey Kıbrıs';
        }
        return 'Belirtilmemiş';
    }
    static function getDistrictName($districtId){
        if($districtId==2){
            return 'Türkiye';
        } elseif($districtId==4){
            return 'Kuzey Kıbrıs';
        }
        return 'Belirtilmemiş';
    }
    static function getPaymentDescription($paymentTypeId){
        if($paymentTypeId==5){
            return '<p>Havale/EFT için aşağıdaki hesap bilgilerini kullanınız</p>
                                <table class="table_bankdetails">
                                    <tbody>
                                    <tr>
                                        <td colspan="3"><img src="https://www.qnbfinansbank.com/_assets/img/logo.png" style="height:50px;border:0 !important">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Hesap Adı</td>
                                        <td>:</td>
                                        <td id="branchCode">BERKANT ELEKTRONIK BILG.ITH.IHR.SAN.VE DIS TIC.LTD</td>
                                    </tr>
                                    <tr>
                                        <td>Şube No</td>
                                        <td>:</td>
                                        <td id="branchCode">Esenyurt (1078)</td>
                                    </tr>
                                    <tr>
                                        <td>Hesap no</td>
                                        <td>:</td>
                                        <td id="accountNumber">33 1815 00</td>
                                    </tr>
                                    <tr>
                                        <td>IBAN</td>
                                        <td>:</td>
                                        <td id="iban">TR75 0011 1000 0000 0033 1815 00</td>
                                    </tr>
                                    <tr>
                                        <td>HIZLI ADRES</td>
                                        <td>:</td>
                                        <td id="vkno">VK No: 1650282967</td>
                                    </tr>
                                    </tbody>
                                </table>';
        }
    }
    static function getPaymentExtraDescription($extra){

        if(isset($extra['bankName'])){
            return '<div class="summary-title"><strong>Ödeme Bilgileri</strong></div>
        <div class="info-title">Banka: <span class="info-descr">'.$extra['bankName'].'</span></div>
        <div class="info-title">Hesap Adı: <span class="info-descr">'.$extra['legalCompanyTitle'].'</span></div>
        <div class="info-title">Iban: <span class="info-descr">'.$extra['iban'].'</span></div>
        <div class="info-title">Referans Kodu: <span class="info-descr">'.$extra['referenceCode'].'</span></div>
        <p>
            Ödeme yaparken açıklama kısmına sadece <strong>Referans kodunuz</strong> olan <strong>'.$extra['referenceCode'].'</strong> yazınız
        </p>';
        }
    }
    static function getOrderSummary($order){
        return '<div class="summary-title"><strong>Sipariş Özetiniz</strong></div>
        <div class="info-title">Sipariş numarası: <span class="info-descr">'.$order->orderNumber .'</span></div>
        <div class="info-title">Alıcı: <span class="info-descr">'.$order->name .' '.$order->surName .'</span></div>
        <div class="info-title">Teslimat Adresi: <span class="info-descr">'.$order->cargoAddress .' '.$order->cargoCity .'/'.$order->cargoCity.'</span></div>
        <div class="info-title">Ödeme Tipi: <span class="info-descr">'.$order->paymentType .'</span></div>
        <div class="info-title">Telefon: <span class="info-descr">'.$order->cargoGsm .'</span></div>
        <div class="info-title">Tarih: <span class="info-descr">'. \Help::HumanDate($order->created_at) .'</span></div>';
    }
    static function getOrderDescription($order){

        return 'Sn. <strong>'. $order->name .' '. $order->surName .'</strong>, <strong>'. \Help::HumanDate($order->created_at) .'</strong> tarihinde yapmış olduğunuz
        <strong>'. HelperController::formatted_price($order->paymentTotal)  .' TL</strong> tutarındaki siparişiniz tarafımıza ulaşmıştır. Alışverişinizin özetini içeren bir mesaj ayrıca <strong>'.$order->email.'</strong> adresine gönderilmiştir.';
    }

}
