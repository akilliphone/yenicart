<?php

namespace App\Http\Controllers;

use App\Api\Controllers\MemberService;
use App\Api\Models\Order;
use App\Helpers\MailService;
use App\Helpers\MemberTypes;
use App\Models\Member;
use App\Models\MemberAddress;
use App\Models\Page;
use App\Models\User;
use Firebase\JWT\Key;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\DB;
use Psy\Util\Str;


class MemberController extends Controller {
    public function index(Request $request){
        return $this->informations($request);
    }
    public function informations(Request $request){
        $data = [
            'page'=>'informations',
            'pageTitle'=>'Hesabım'
        ];
        return $this->page($request, $data);

    }
    public function orders(Request $request){
        $data = [
            'page'=>'orders',
            'pageTitle'=>'Siparişlerim',
            'orders'=> Member::orders(member_logged())
        ];
        return $this->page($request, $data);
    }
    public function orderDetail(Request $request, $orderId){
        $data = [
            'page'=>'orderDetail',
            'pageTitle'=>'Siparişlerim',
            'order'=> Member::orderDetail(member_logged(), $orderId)
        ];
        return $this->page($request, $data);
    }
    public function favorites(Request $request){
        $data = [
            'page'=>'favorites',
            'pageTitle'=>'Favorilerim',
            'favorites'=> Member::wishList(member_logged()),
        ];
        return $this->page($request, $data);
    }
    public function favoriteRemove (Request $request, $productId){
        \DB::table('wish_list')
            ->where(['product_id'=>$productId, 'member_id'=>member_logged() ])
            ->delete();
        $request->session()->flash('flash-success', ['Üzgünüz', 'Ürün favorilerinizden silindi']);
        return redirect(route('profile.favorites'));

    }
    public function refundAdd(Request $request, $orderId){

        $orderItemId = $request->input('orderItemId');
        if($orderId && $orderItemId){
            $orderItem = \DB::table('orders_detail')
                ->where(['id'=>$orderItemId, 'idOrder'=>$orderId ])
                ->first();
            if($orderItem){

                $refundexists = DB::table('orders_detail')->where(['id'=>$orderItemId, 'returnType'=>$request->input('refund.returnType')])->exists();
                if($refundexists){
                    $result['message'] = 'Bu sipariş için daha önce talep oluşturulmuş.';
                    return  $result;
                }

                $order = Order::find($orderId);
                $order->orderState = 17;
                $order->save();
                // 		$sql="UPDATE orders_detail set returnIBAN=?,isReturn=1, returnWhy=?, returnMessage=?, returnType=?,returnCargo=?,returnCargoTrack=? where id=?";

                $detail['returnMessage'] = $request->input('refund.returnMessage');
                $detail['returnCargoTrack'] = $request->input('refund.returnCargoTrack');
                $detail['returnIBAN'] = $request->input('refund.returnIBAN');
                $detail['returnType'] = $request->input('refund.returnType');

                DB::table('orders_detail')->where(['id'=>$orderItemId])->update($detail);

                $ticket["idOrderDetail"]=$orderItemId;
                $ticket["idMember"]=member_logged();
                $ticket["nameSurname"]=member_get('name').' '.member_get('surName');
                $ticket["ticketType"]=6;
                $ticket["ticketDate"]=date('Y-m-d H:i:s');
                $ticket["email"]=member_get('email');
                $ticket["message"]=$request->input('refund.returnWhy')."<br>Kargo :Aras KArgo,".$request->input('refund.returnCargoTrack')."<br>IBAN:".$request->input('refund.returnIBAN');
                $ticket["picture"]  ="";
                $id = DB::table('ticket')->insertGetId($ticket);
                $result = [
                    'status'=>1,
                    'message'=>'Iade/Değişim talebiniz alındı'
                ];

            }
            $result['message'] = 'Sipariş detayı bulunamadı';
        } else {
            $result['message'] = 'Gerekli bilgiler alınamadı';
        }
        return $result;
    }
    public function comments(Request $request){
        $data = [
            'page'=>'comments',
            'pageTitle'=>'Yorumlarım',
            'comments'=> Member::comments(member_logged()),
        ];
        return $this->page($request, $data);
    }
    public function address(Request $request){
        $data = [
            'page'=>'address',
            'pageTitle'=>'Adreslerim',
            'addresses'=> Member::addresses(member_logged()),
        ];
        return $this->page($request, $data);
    }
    public function addressSave(Request $request, $addressId){
        $addressData = $request->input('address');
        if(empty($addressData)){
            $request->session()->flash('flash-error', ['Üzgünüz', 'Adres bilgileriniz alınırken hata oluştu']);
            return redirect(route('profile.address.update', $addressId));
        }
        $address = Member::address($addressId, member_logged());
        $addressData['idMember'] = member_logged();
        $address->fill($addressData);

        $address->save();
        $request->session()->flash('flash-success', ['Tebrikler.', 'Adresiniz Güncellendi']);
        return redirect(route('profile.address'));
    }
    public function addressUpdate(Request $request, $addressId=null){
        $data = [
            'page'=>'address-update',
            'pageTitle'=>'Adres Düzenle',
            'address'=> Member::address($addressId, member_logged()),
            'countries'=> ['TR'=>'Türkiye'],
            'cities'=> \Help::getCities(),
            'districts'=> \Help::getDistricts(),
        ];
        $data['addressId'] = $addressId;

        return $this->page($request, $data);
    }
    public function addressDelete (Request $request, $addressId=null){
        if(member_logged()){
            MemberAddress::where(['id'=>$addressId, 'idMember'=>member_logged()])->delete();
            $request->session()->flash('flash-success', ['Tebrikler.', 'Adresiniz Silindi']);
            return redirect(route('profile.address'));
        }
        $request->session()->flash('flash-error', ['Üzgünüz.', 'Adresiniz Silinemedi']);
        return redirect(route('profile.address'));

    }
    public function page(Request $request, $data){
        return view('profile.index', $data);
    }
    public function forgot(Request $request){
        if($MEMBER_ID = \Help::getSessionMemberId($request)){
            return \Help::errorResponse([], 'Oturum Zaten Açık');
        }
        $email = $request->input('email');
        $membertype = $request->input('membertype', MemberTypes::UYE);
        if( $email ){
            if($member = Member::where(['email'=>$email])->first()){
                $password = \Illuminate\Support\Str::password(8, true, true, false, false);
                $member->password = md5($password);
                $member->save();
                MailService::resetPassword($email, $password);
                return \Help::successResponse(['member'=>$member], 'email adresinize yeni bir şifre gönderildi');
            }
        }
        return \Help::errorResponse([], 'Kullanıcı Bulunamadı. Kullanıcı adınızı veya emailinizi kontrol ederek tekrar deneyiniz');

        return view('login.index',$data);
    }
    public function login(Request $request){

        if(member_logged()){
            return redirect(route('profile.index'));
        }
        $data = [
            'title'=>'Üye Girişi',
            'ask'=>'Üye Değil misiniz?',
            'button'=>'Hemen Üye Ol',
            'register_route'=> route('register.uye'),
            'membertype'=>MemberTypes::UYE
        ];
        return view('login.index', $data);
    }
    public function bayi(Request $request){
        $data = [
            'title'=>'Bayi Girişi',
            'ask'=>'Bayi Değil misiniz?',
            'button'=>'Hemen Bayi Ol',
            'register_route'=> route('register.bayi'),
            'membertype'=>MemberTypes::BAYI
        ];
        return view('login.index',$data);
    }
    public function registerUye(Request $request){
        $data = [
            'title'=>'E-Posta ile Üye Ol',
            'button'=>'Hemen Uye Ol',
            'membertype'=>MemberTypes::UYE
        ];
        return $this->register($request, $data);
    }
    public function registerBayi(Request $request){
        $data = [
            'title'=>'E-Posta ile Bayi Ol',
            'button'=>'Hemen Bayi Ol',
            'membertype'=>MemberTypes::BAYI
        ];
        return $this->register($request, $data);
    }
    private function register(Request $request, $data){

        return view('login.register',$data);
    }
    public function create(Request $request){
        $response = [
            'status'=>0,
            'message'=>'',
        ];
        $memberData = $request->input('member', []);
        if($memberData){

            if($request->input('password', '1')!=$request->input('password2', '2')){
                $response['message'] = 'Şifreler aynı değil. Lütfen kantrol ederek tekrar deneyiniz.';

            } else{
                if(Member::where(['email'=>$memberData['email']])->exists()){
                    $response['message'] = 'Email kulanımda. Lütfen farklı bir emaille tekrar deneyiniz.';
                } else {
                    $member = new Member();
                    $member->fill($memberData);
                    $member->password = md5($request->input('password'));
                    $member->save();
                    MailService::newMember($member);
                    $this->setSessionMember($request, $member);
                    $response['status'] = 1;
                    $response['redirect'] = route('profile.index');
                    $response['message'] = 'Kullanıcı Kaydınız Tamamlandı.';
                }
            }

        } else {
            $response['message'] = 'Form bilgileri alınamadı. Lütfen daha sonra tekrar deneyiniz.';
        }

        return $response;
    }
    public function check(Request $request){
        if($MEMBER_ID = \Help::getSessionMemberId($request)){
            return \Help::errorResponse([], 'Oturum Zaten Açık');
        }
        $email = $request->input('email');
        $password = $request->input('password');
        $membertype = $request->input('membertype', MemberTypes::UYE);

        if($email && $password){
            if($member = Member::where(['email'=>$email, 'password'=>md5($password), 'idMemberGroup'=>$membertype])->first()){
                /*$request->session()->put('MEMBER_ID', $member->id);
                $request->session()->put('MEMBER_TYPE', $member->idMemberGroup);
                $request->session()->put('member', $member);
                $token = MemberService::formLogin($request);
                if($token && isset($token['data']) && isset($token['data']['jwtToken'])){
                    $request->session()->put('JWT_TOKEN', $token['data']['jwtToken']);
                }*/
                $this->setSessionMember($request, $member);
                return \Help::successResponse(['member'=>$member, 'redirect'=>route('home')], $member->name.' '.$member->surName.' olarak Giriş Yaptınız');
            }
        }
        return \Help::errorResponse([], 'Kullanıcı Bulunamadı. Kullanıcı adınızı ve şifrenizi kontrol ederek tekrar deneyiniz');

        return view('login.index',$data);
    }
    public function out(Request $request){
        $request->session()->flush();
        return \Help::successResponse([], 'Çıkış Gerçekleşti');
    }
    private function setSessionMember(Request $request, $member){
        $request->session()->put('MEMBER_ID', $member->id);
        $request->session()->put('MEMBER_TYPE', $member->idMemberGroup);
        $request->session()->put('member', $member);
        $token = MemberService::formLogin($request);
        if($token && isset($token['data']) && isset($token['data']['jwtToken'])){
            $request->session()->put('JWT_TOKEN', $token['data']['jwtToken']);
        }

    }
}
