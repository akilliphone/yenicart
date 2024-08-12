@extends('layouts.payment')
@section('head')
    <title>Sepetim - AkıllıPhone</title>
    <link rel="stylesheet" href="{{ url('assets/css/basket/shopping-section.css') }}">
    <style>
        .decrease-increase{
            text-align: center;
            border: none;
            margin: 0px;
            width: 40px;
            height: 100%;
            background: #F9F9F9;
        }
        .basket-messages {
            font-size: 12px;
            clear: both;
            width: 100%;
            margin-bottom: 15px;
            padding-right: 22px;
        }
        .basket-message {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #313131;
        }
        .basket-message.text-danger {
            font-size:8px;
            text-align: -webkit-right;
            color: #e91e63;
        }
        .basket-message.text-success {
            font-size: 10px;
            text-align: end;
            color: #32a200;
        }
    </style>
@endsection
@section('content')
    <section class="shopping_section" style="padding-top: 20px">
        <div class="container" id="basket-table">
            <x-payment.steps :step="1"/>
            <form method="post" action="{{ route('payment.step.post', 2) }}">
                @if($basket->basketItemCount)
                    <div class="for-you-special"></div>
                    <div id="basket-table">
                        {!! $basket->getBasketTable(true) !!}
                    </div>
                @else
                    Alışveriş sepetiniz boş! <a href="{{ route('home') }}">Alışverişe Devam Et</a>
                @endif
                @csrf
            </form>
        </div>
    </section>
@endsection


