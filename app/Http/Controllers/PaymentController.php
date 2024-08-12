<?php

namespace App\Http\Controllers;

use App\Api\Controllers\OrderService;
use App\Helpers\MailService;
use App\Helpers\PaymentService;
use App\Models\CommonLogs;
use App\Models\Member;
use BasketService;
use Illuminate\Http\Request;

class PaymentController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request){
        return $this->step($request, "2");
    }
    public function iyzicoCallback(Request $request){
        $data = $request->all();
        $token =$request->input('token');
        $payment = PaymentService::checkIyzicoPayment($token);
        $basket =  BasketService::calculateBasket(BasketService::getBasket());
        $order = OrderService::currentOrder();
        \Help::addPaymentLog('iyzico', ['callback'=>$data, 'check'=>$payment], $order, $basket );

        if($payment->getPaymentStatus()=='FAILURE'){
            $request->session()->flash('flash-error', [$payment->getErrorMessage(),'']);
            return redirect(route('payment.step.get', '3'));
        }elseif($payment->getPaymentStatus()=='SUCCESS'){
           $result = $this->complateOrderWithPaymentTypeId(3, $token, 11);
           if(is_a($result, 'Illuminate\Http\RedirectResponse')){
               return $result;
           }
        }elseif($payment->getPaymentStatus()=='INIT_BANK_TRANSFER'){
           $result = $this->complateOrderWithPaymentTypeId(5, $token);
           if(is_a($result, 'Illuminate\Http\RedirectResponse')){
               return $result;
           }
        }
        $request->session()->flash('flash-error', ['Bilinmeyen Hata','']);
        return redirect(route('payment.step.get', '3'));
    }
    public function validateSuccess(Request $request){
        $data = $request->all();
        $basket =  BasketService::calculateBasket(BasketService::getBasket());
        $order = OrderService::currentOrder();
        \Help::addPaymentLog('creditcard', $data, $order, $basket );

        $error = null;
        if($data){
            $hash = PaymentService::finansBankHash($data);
            if(isset($data['Hash']) ){
                 if($hash == $data['Hash']){
                     if($data['3DStatus']==1 ){
                         if($basket){
                             //$order = OrderService::currentOrder();
                             //$order->marketplaceId = 4; //akilliphone
                             //$order->paymentTypeId = 3; // havale
                             //$order->orderStatusId = 26; // Sipariş ödeme bekliyor
                             //$order->paymentStatusId = 3; // Ödeme durumu Bekliyor
                             $order->orderState = '1';
                             $order->cargoState = '';
                             $order->invoiceState = '';
                             $order->paymentState = '1';
                             $order->paymentType = '2'; // Havale

                             if( round($data['PurchAmount']) >= round($basket->total) ){
                                 $order->orderStatusId = 28; // onaylandı
                                 $order->paymentStatusId = 11; // Ödendi
                             } else {
                                 $error = 'sipariş ile ödeme tutarı uyumsuz';
                             }
                             $response = OrderService::create_order($order);
                             if($response  && $response['orderId']){
                                 $log = [
                                     'title'=>'Fianansbank Tutar. #'.$response['orderId'],
                                     'data' => json_encode(
                                         [
                                             'kontrol'=>round($data['PurchAmount'])." >= ".round($basket->total),
                                             'data'=>$data,
                                             'basket'=>$basket,
                                         ], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE
                                     )
                                 ];
                                 CommonLogs::insert($log);

                                 BasketService::clear();
                                 if($error) $request->session()->flash('flash-error',['Hata Oluştu:', $error]);
                                 return redirect()->route('thankyou', ['orderId'=> $response['orderId'], 'orderNo'=>$response['orderNumber'] ]);
                             } else{
                                 $error = 'sipariş alındı fakat işlenirken bir hata oluştu. Bu kodu kullanarak yarım isteyiniz. Kodunuz: '.$data['Tds2dsTransId'];
                             }
                         } else {
                             $error = 'Basket bilgisi kaybolmuş';
                         }
                     } else {
                         $error = '3d doğrulama başarısız';
                     }
                 } else {
                     $error = 'doğrulanamayan işlem';
                 }
            } else{
                $error = 'geçersiz işlem';
            }
        } else {
            $error = 'hatalı işlem';
        }
        $request->session()->flash('flash-error',['Hata Oluştu:', $error]);
        return redirect(route('payment.step.get', '3'));
    }
    public function validateFail(Request $request){
        $data = $request->all();
        $order = OrderService::currentOrder();

        $basket =  BasketService::calculateBasket(BasketService::getBasket());
        $validate = PaymentService::finansBankValidate($data, $basket);
        \Help::addPaymentLog('creditcard', $data, $order, $basket );

        if($validate['errors']){
            $request->session()->flash('flash-error', $validate['errors']);
        }
        //dd(session('flash-error'));
        return redirect(route('payment.step.get', '3'));
    }
    function checkStep(Request $request, String $step="1"){
        return $this->step($request, $step );
    }
    public function step(Request $request, String $step="1", $validate=[]){
        $data['basket']   =  BasketService::calculateBasket(BasketService::getBasket());

        $data['validate']   =  $validate;
        $basket   =  BasketService::calculateBasket(BasketService::getBasket());
        if(empty($basket->customer)) BasketService::setCustomer([]);
        if(empty($basket->shippingAddress)) BasketService::setShipingAddres([]);
        if(empty($basket->billingAddress)) BasketService::setBillingAddres([], 'bireysel');

        $data['countries'] = ['TR'=>'Türkiye'];
        $data['cities'] = \Help::getCities();
        $data['districts'] = \Help::getDistricts();
        $data['userInfo']   =   \Help::getMemberInfo();
        //dd(json_encode($data['basket']));
        if(empty($data['basket']->basketItemCount)){
            $step="1";
        }
        if($step =='1'){
            return $this->step_1($request, $data);
        } elseif($step =='2'){
            return $this->step_2($request, $data);
        } elseif($step =='3'){
            return $this->step_3($request, $data);
        } elseif($step =='4'){
            return $this->step_4($request, $data);
        } elseif($step =='5'){
            return $this->step_5($request, $data);
        }


        return view('payment.step-1', $data);
    }
    private function step_1(Request $request, $data){
        return view('payment.step-1', $data);
    }
    private function step_2(Request $request, $data){

        BasketService::setCustomer([]);
        $data['basket']   =  BasketService::calculateBasket(BasketService::getBasket());
        return view('payment.step-2', $data);
    }
    private function step_3(Request $request, $data){
        if ($request->isMethod('post')) {
            $customer = $request->input('customer', []);
            $shippingAddress = $request->input('shippingAddress', []);
            if($shippingAddress && empty($shippingAddress['firstName'])){
                $shippingAddress['firstName'] = $customer['firstName'];
                $shippingAddress['lastName'] = $customer['lastName'];
                $shippingAddress['phone'] = $customer['phone'];
            }
            if($request->input('use_payment_adress', false)){
                $billingAddress = $request->input('billingAddress', []);
            } else{
                $billingAddress = $shippingAddress;
            }
            if($billing = $request->input('billing', [])){
                $billingAddress['company'] = $billing['company'];
                $billingAddress['taxOffice'] = $billing['taxOffice'];
                $billingAddress['taxNumber'] = $billing['taxNumber'];
            } else{
                $billingAddress = $shippingAddress;
            }


            $invoiceType = $request->input('invoiceType', 'bireysel');

            BasketService::setShipping($request->input('shippingBrand', false));
            BasketService::setCustomer($customer);
            BasketService::setShipingAddres($shippingAddress);
            BasketService::setBillingAddres($billingAddress, $invoiceType);
        }
        $data['basket']   =  BasketService::calculateBasket(BasketService::getBasket());
        $iyzicoResponse = PaymentService::iyzicoPayment($data['basket']);

        if($paymentPageUrl = $iyzicoResponse->getPaymentPageUrl()){
            $data['iyzico_url'] = $paymentPageUrl;
        } else{
            $data['iyzico_url'] = '';
        }
        $data['iyzico_form'] = '';
        if($checkoutFormContent = $iyzicoResponse->getPaymentPageUrl()){
            $data['iyzico_link'] = $checkoutFormContent;
        } else{
            $data['iyzico_link'] = '';
        }
        $data['cc'] = [
            'name'=>'',
            'cardnumber'=>'',
            'expirationdate'=>'',
            'securitycode'=>'',
        ];
        return view('payment.step-3', $data);
    }
    private function step_4(Request $request, $data){
        $data['status']=0;
        $result = false;
        if($paymetType = $request->input('paymentType', false)){
            if(BasketService::getItemCount()){
                $basket = BasketService::calculateBasket(BasketService::getBasket());
                if($paymetType=='banktransfer'){
                    $order = OrderService::currentOrder();
                    \Help::addPaymentLog('banktransfer', [], $order, $basket );

                    $response = $this->complateOrderWithPaymentTypeId(5);
                    if($response){
                        return redirect()->route('thankyou', ['orderId'=> $response['orderId'], 'orderNumber'=>$response['orderNumber'] ]);
                    }


                } elseif($paymetType=='finansbank'){
                    //$order->paymentTypeId = 3; // kredikartı
                    $cc = $request->input('cc', []);
                    PaymentService::finansBankStart($basket, $cc);
                    $result = false;
                } else {
                    //paymentType geçersiz
                }
            } else{
                //sepet boş
            }
        } else{
            //payment type yok
        }
        return view('payment.step-4', $data);
    }
    private function complateOrderWithPaymentTypeId($paymentTypeId, $orderToken='', $paymentStatusId=false){
        $basket = BasketService::calculateBasket(BasketService::getBasket());
        $order = OrderService::currentOrder();
        $order->orderState = '1';
        $order->cargoState = '';
        $order->invoiceState = '';
        $order->paymentState = '1';
        $order->paymentType = '2'; // Havale

        //$order->marketplaceId='4'; //akilliphone
        //$order->marketplaceOrderCode= $orderToken; //iyzico ödeme tokenı
        //$order->paymentTypeId = $paymentTypeId; // 4-havale
        if($paymentStatusId){
            $order->paymentState = $paymentStatusId; // 11 ödendi
        }
        $response = OrderService::create_order($order);

        if($response &&  $response['orderId']){
            $order = OrderService::currentOrder();
            \Help::addPaymentLog('complate', $response, $order, $basket,  $response['orderId']);

            BasketService::clear();
            $orderHistory = [
                "orderId"=> $response['orderId'],
                "orderStatusId"=> $response['orderStatusId'],
                "paymentStatusId"=> $response['paymentStatusId'],
                "description"=> "Sipariş Websitesinden Oluşturuldu. Order Token: ".$orderToken,
                "notify"=> true,
                "notifyResult"=> ""
            ];
            OrderService::create_order_history($orderHistory);
            return $response;
        } else {
            \Help::addPaymentLog('error', [], $order, $basket );
            //siapariş oluşturulamadı
        }
        return false;

    }
    public function thankYou(Request $request, $orderId, $orderNumber){

        $data['error'] = 'Sipariş Bulanamadı';
        $data['order'] = Member::orderDetail(member_logged(), $orderId);
        if($data['order']){
            if($data['order']->orderNumber==$orderNumber){
                if(!$data['order']){
                    $payment = PaymentService::checkIyzicoPayment($data['order']['marketplaceOrderCode']);
                    $data['extra'] = json_decode($payment->getRawResult(), 1);
                } else {
                    $data['extra'] = [];
                }
                MailService::newOrder($data);
                $data['error'] = false;
            }
        } else {
            $data['order'] = [];
        }
        return view('payment.thankyou', $data);

    }
}
