<?php
namespace App\Helpers;
use Illuminate\Support\Facades\Http;
use GuzzleHttp\Client;
use App\Models;
class PaymentService{

    static function finansAccount(){
        return [
            'MerchantPass' 		=> '46915477',
            'MerchantID'		=> '107800000008693',
            'UserCode'		    => 'akilliphone_api',
            'UserPass' 		    => 'x5jdi'
        ];
    }
    static function finansBankStart($basket, $cc){

        $finansBankCartData = self::finansBankCartData($basket, $cc);
        $url = 'https://vpos.qnbfinansbank.com/Gateway/Default.aspx';
        self::finansBankPostData($url, $finansBankCartData, []);

    }
    static function finansBankHash($data){
        $finansAccount = self::finansAccount();
        $hashstr = $data['MbrId']  . $data['OrderId']  . $data['PurchAmount']  . $data['OkUrl'] . $data['FailUrl'] . $data['TxnType'] . $data['InstallmentCount']  . $data['Rnd']  . $finansAccount['MerchantPass'];
        $log = [
            'title'=>'Fianansbank Hash',
            'data' => json_encode(
                [
                    'hashstr'=>$hashstr,
                    'hash'=>base64_encode(pack('H*',sha1($hashstr))),
                    'data'=>$data,
                ], JSON_PRETTY_PRINT|JSON_UNESCAPED_UNICODE
            )
        ];
        Models\CommonLogs::insert($log);
        return base64_encode(pack('H*',sha1($hashstr)));
    }
    static function finansBankValidate($request, $basket){
        $validate['status'] = false;
        $validate['errors'] = [];
        if(isset($request['ErrMsg'])){
            $validate['errors'] = [$request['ErrMsg'], ''];
        }
        /*if(isset($request['status']) && $request['status']==false){
            $validate['errors'] = array_merge($validate['errors'],  $request['errors']);
        }*/
        $validate['paymentStatus'] = isset($request['ProcReturnCode']) ? $request['ProcReturnCode'] :'-1';
        return $validate;
    }
    static function finansBankCartData($basket, $cc){

        $finansAccount = self::finansAccount();
        $CardHolderName = isset($cc['name'])?$cc['name']:'';
        $Pan = isset($cc['cardnumber'])?$cc['cardnumber']:'';
        $Expires = isset($cc['expirationdate'])?$cc['expirationdate']:'';
        $Cvv2 = isset($cc['securitycode'])?$cc['securitycode']:'';
        //$basket->total = 0.50;
        $data['MbrId'] 		        = 5;
        $data['MerchantID'] 		= $finansAccount['MerchantID'];
        $data['UserCode'] 		    = $finansAccount['UserCode'];
        $data['UserPass'] 		    = $finansAccount['UserPass'];
        $data['SecureType'] 		= '3DPay';
        $data['TxnType'] 		    = 'Auth';
        $data['InstallmentCount']   = '1';
        $data['Currency'] 		    = '949';
        $data['OkUrl'] 		        =  route('payment.success');
        $data['FailUrl'] 		    = route('payment.fail');
        $data['OrderId'] 		    = time();
        $data['OrgOrderId'] 		= '';
        $data['PurchAmount'] 		= ''.round($basket->total, 2).'';
        $data['Lang'] 		        = 'TR';
        $data['CardHolderName']     = $CardHolderName;
        $data['Rnd'] 		        = microtime();
        $data['Hash'] 		    = self::finansBankHash($data);
        //
        $data['Pan'] 		=preg_replace("/[^0-9.]/", "", $Pan);
        $data['Cvv2'] 		=$Cvv2;
        $data['Expiry'] 	= str_replace('/','', $Expires);
        return $data;
    }
    static function finansBankPostData($url, array $data, array $headers = []){

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_NOBODY, true); // remove body
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 60);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        //print_r($data);
        /*if( '' != request()->ip() ){
            echo "url: $url<br>";
            echo "data: <textarea>".print_r($data, 1)."</textarea><br>";
            echo "httpCode: $httpCode<br>";
            echo "result: <textarea>$response</textarea><br>";
            echo "Curl info: ";
            print_r(curl_getinfo($ch));
        }*/
        echo $response;
        die();
    }
    static function iyzicoOptions(){

        $options = new \Iyzipay\Options();

        $options->setApiKey('V62v1fnWq0F8IXmqkImIRjwIgCVuqAuf');
        $options->setSecretKey('xdHG8rRlSL28mmckdamzeLDh9FZPgRau');
        $options->setBaseUrl('https://api.iyzipay.com');

        /*$options->setApiKey('sandbox-afXhZPW0MQlE4dCUUlHcEopnMBgXnAZI');
        $options->setSecretKey('sandbox-wbwpzKIiplZxI3hh5ALI4FJyAcZKL6kq');
        $options->setBaseUrl('https://sandbox-api.iyzipay.com');*/
        return $options;
    }
    static function iyzicoPayment($basket){
        $request = new \Iyzipay\Request\CreateCheckoutFormInitializeRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        $request->setBasketId("B".$basket->getBasketId());
        $request->setConversationId($basket->getBasketId());
        //$basket->total = 0.5;
        $request->setPrice($basket->total);
        $request->setPaidPrice($basket->total);
        $request->setCurrency(\Iyzipay\Model\Currency::TL);

        $request->setPaymentGroup(\Iyzipay\Model\PaymentGroup::PRODUCT);
        $request->setCallbackUrl(route('payment.iyzico-callback'));
        //$request->setEnabledInstallments(array(2, 3, 6, 9));

        $buyer = new \Iyzipay\Model\Buyer();
        $buyer->setId("BY789");
        $buyer->setName($basket->customer['firstName']);
        $buyer->setSurname($basket->customer['lastName']);
        $buyer->setGsmNumber($basket->customer['phone']);
        $buyer->setEmail($basket->customer['email']);
        $buyer->setIdentityNumber($basket->customer['tcKimlik']?$basket->customer['tcKimlik']:'1111111111');
        $buyer->setLastLoginDate(date('Y-m-d H:i:s'));
        $buyer->setRegistrationDate(date('Y-m-d H:i:s'));
        $buyer->setRegistrationAddress($basket->shippingAddress['addressLine1']);
        $buyer->setIp("85.34.78.112");
        $buyer->setCity($basket->shippingAddress['addressLine1'].' '.$basket->shippingAddress['district'].'/'.$basket->shippingAddress['city']);
        $buyer->setCountry("Turkey");
        $buyer->setZipCode("00000");
        $request->setBuyer($buyer);

        $shippingAddress = new \Iyzipay\Model\Address();
        $shippingAddress->setContactName($basket->shippingAddress['firstName'].' '.$basket->shippingAddress['lastName']);
        $shippingAddress->setCity($basket->shippingAddress['city']);
        $shippingAddress->setCountry("Turkey");
        $shippingAddress->setAddress($basket->shippingAddress['addressLine1']);
        $shippingAddress->setZipCode("000000");
        $request->setShippingAddress($shippingAddress);
        if(1==1){
            $billingAddress = $shippingAddress;
        } else{
            $billingAddress = new \Iyzipay\Model\Address();
            $billingAddress->setContactName($basket->billingAddress['firstName'].' '.$basket->billingAddress['lastName']);
            $billingAddress->setCity($basket->billingAddress['city']);
            $billingAddress->setCountry("Turkey");
            $billingAddress->setAddress($basket->billingAddress['addressLine1']);
            $billingAddress->setZipCode("000000");
        }
        $request->setBillingAddress($billingAddress);

        $basketItems = array();
        $firstBasketItem = new \Iyzipay\Model\BasketItem();
        $firstBasketItem->setId("URUN01");
        $firstBasketItem->setName("Ürün");
        $firstBasketItem->setCategory1("Mağaza Ürünleri");
        $firstBasketItem->setCategory2("");
        $firstBasketItem->setItemType(\Iyzipay\Model\BasketItemType::PHYSICAL);
        $firstBasketItem->setPrice($basket->total);
        $basketItems[0] = $firstBasketItem;
        $request->setBasketItems($basketItems);

        $response = \Iyzipay\Model\CheckoutFormInitialize::create($request, self::iyzicoOptions());
        //return(['request'=>$request->getJsonObject(), 'response'=>$response->getRawResult()] );
        return $response;
    }

    static function checkIyzicoPayment($token):\Iyzipay\Model\CheckoutForm{
        $request = new \Iyzipay\Request\RetrieveCheckoutFormRequest();
        $request->setLocale(\Iyzipay\Model\Locale::TR);
        //$request->setConversationId("123456789");
        $request->setToken($token);
        return \Iyzipay\Model\CheckoutForm::retrieve($request, self::iyzicoOptions());
    }
}

