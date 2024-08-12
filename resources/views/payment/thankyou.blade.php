@extends('layouts.default')
@section('head')
    <title>Ödeme Sayfası - AkıllıPhone</title>
    <link rel="stylesheet" href="{{ url('assets/css/shopping-section4.css') }}">
    <style>
        .pay3d-errors{
            color: #e91e63;
            border: 1px solid;
            padding: 10px;
            margin-bottom: 30px;
            border-radius: 5px;
        }
    </style>
@endsection
@section('content')
    <section class="shopping_section" >
        <div class="container">
            <x-payment.steps :step="4"/>
                @if($error)
                    <div class="pay3d-errors">
                        {{ $error }}
                    </div>

                @else
                    <div class="signup-title">
                        <h1>Sipariş Özeti</h1>
                        Alışverişiniz için teşekkür ederiz. Siparişiniz en kısa sürede hazırlanacak.
                    </div>
                    <div class="shopping-wrapper">
                    <div class="form-wrapper">
                        <div class="order-summary">
                            <div class="order-description">
                                {!! \BasketService::getOrderDescription($order) !!}
                            </div>
                        </div>
                        <div class="order-summary">
                            <div class="summary-title"> Sipariş numarası: <span class="order-number">{{ $order->orderNumber }}</span></div>
                            <div>
                                Sipariş numaranızı kaybetmeyiniz. Kargo takibi ve olası işlemlerinizde bu numara üzerinden işlem yapılacaktır.
                            </div>
                        </div>
                        <div class="order-summary">
                            {!! \BasketService::getOrderSummary($order) !!}
                            <hr class="summary-title">
                            @if(isset($extra) && $extra)
                                {!! \BasketService::getPaymentExtraDescription($extra) !!}
                            @else
                                {!! \BasketService::getPaymentDescription($order->paymentType) !!}
                            @endif
                        </div>
                    </div>
                    <div class="cart-wrapper">
                        <div class="header">
                            <div class="title">Siparişim</div>
                            <span class="item-count">{{count($order->items)}}</span>
                        </div>
                        <div class="body">

                            @foreach($order->items as $orderItem)
                                <div class="purchased">
                                    <img src="{{ $orderItem['product']->thumb }}" alt="">
                                    <div class="info">
                                        <div class="name">{{ $orderItem['product']->productName }} Barkodu: {{ $orderItem['product']->productCode }}-{{ $orderItem['detail']->idColor }} ({{ $orderItem['detail']->amount }} Adet)</div>
                                        <div class="price">{{ \App\Http\Helpers\HelperController::formatted_price($orderItem['detail']->price)  }}<span></span></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="total">
                            <div class="info-total">
                                <div class="descr">Kargo</div>
                                @if($order->cargoTotal)
                                    <div class="price">{{ \App\Http\Helpers\HelperController::formatted_price($order->cargoTotal) }}</div>
                                @else
                                <div class="price">Bedava</div>
                                @endif
                            </div>
                            <div class="info-total">
                                <div class="descr">Toplam</div>
                                <div class="price">{{ \App\Http\Helpers\HelperController::formatted_price($order->paymentTotal) }}</div>

                            </div>
                        </div>
                    </div>
                    </div>
        </div>
                @endif
    </section>
@endsection
@section('js')

@endsection
