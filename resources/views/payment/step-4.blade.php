@extends('layouts.default')
@section('head')
    <title>Ödeme Sayfası - AkıllıPhone</title>
    <link rel="stylesheet" href="{{ url('assets/css/shopping-section3.css') }}">
@endsection
@section('content')
    <div class="container">
        <x-payment.steps :step="4"/>
        <div class="signup-title">
            <h1>Sipariş Özeti</h1>
            Alışverişiniz için teşekkür ederiz. Siparişiniz en kısa sürede hazırlanacak.
        </div>

        <div class="shopping-wrapper">
            <div class="form-wrapper">
                <div class="order-summary">
                    <div class="order-description">
                        Sn. <strong>{{ $order['shippingAddress']['name'] }}</strong>, <strong>{{ $order['createdAt'] }}</strong> tarihinde yapmış olduğunuz
                        <strong>{{ $order['orderTotal'] }} TL</strong> tutarındaki siparişiniz tarafımıza ulaşmıştır. Alışverişinizin özetini içeren bir mesaj ayrıca <strong>loremipsum@dolor.com</strong> adresine gönderilmiştir.
                    </div>
                </div>
                <div class="order-summary">
                    <div class="summary-title"> Sipariş numarası: <span class="order-number">{{ $order['orderNo'] }}</span></div>
                    <div>
                        Sipariş numaranızı kaybetmeyiniz. Kargo takibi ve olası işlemlerinizde bu numara üzerinden işlem yapılacaktır.
                    </div>
                </div>
                <div class="order-summary">
                    <div class="summary-title">Sipariş Özetiniz</div>
                    <div class="info-title">Sipariş numarası: <span class="info-descr">{{ $order['orderNo'] }}</span></div>
                    <div class="info-title">Alıcı: <span class="info-descr">{{ $order['shippingAddress']['name'] }}</span></div>
                    <div class="info-title">Teslimat Adresi: <span class="info-descr">{{ $order['shippingAddress']['addressLine1'] }}<br>{{ $order['shippingAddress']['district'] }}/{{ $order['shippingAddress']['city'] }}</span></div>
                    <div class="info-title">Ödeme Tipi: <span class="info-descr">{{ $order['paymentType']['name'] }}</span></div>
                    <div class="info-title">Telefon: <span class="info-descr">{{ $order['customer']['telefon'] }}</span></div>
                    <div class="info-title">Tarih: <span class="info-descr">{{ $order['createdAt'] }}</span></div>
                </div>

            </div>
            <div class="cart-wrapper">
                <div class="header">
                    <div class="title">Siparişim</div>
                    <span class="item-count">2</span>
                </div>
                <div class="body">
                    <div class="purchased">
                        <img src="assets/images/80x80-1.png" alt="">
                        <div class="info">
                            <div class="name">ALLY Magnetic Air Vent
                                Mıknatıslı Araç TutucuKablo Klipsli-SİYAH</div>
                            <div class="price">999,90<span>&nbsp;TL</span></div>
                        </div>
                    </div>
                    <div class="purchased">
                        <img src="assets/images/80x80-2.png" alt="">
                        <div class="info">
                            <div class="name">Xiaomi Mi Band 5 Metal
                                Kayış Kordon Kopçalı Milano Loop-SİYAH</div>
                            <div class="price">2.499,00<span>&nbsp;TL</span></div>
                        </div>
                    </div>
                </div>
                <div class="total">
                    <div class="info-total">
                        <div class="descr">Ürünler Toplamı (KDV Dahil)</div>
                        <div class="price">169.80<span>&nbsp;TL</span></div>
                    </div>
                    <div class="info-total">
                        <div class="descr">Kargo</div>
                        <div class="price">Ücretsiz</div>
                    </div>
                </div>
            </div>
        </div>
    </div>@endsection
@section('js')
    <script src="../assets/js/profile/order/profile-order.js"></script>
@endsection
