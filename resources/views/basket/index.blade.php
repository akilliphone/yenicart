@extends('layouts.default')
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
    <section class="shopping_section">
        <div class="container" id="basket-table">
            @include('basket.table')
        </div>
    </section>
@endsection

