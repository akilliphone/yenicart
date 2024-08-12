@extends('layouts.default')

@section('head')
    <title>Ürün Bulunamadı</title>
    <link rel="stylesheet" href="{{ url('assets/css/product-details.css') }}?_v={{ env('ASSETS_VER') }}">
@endsection
@section('content')

    <?php
    $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $favoriteControl=false;

    ?>
    <div id="app-basic">
        <section class="product-details" style="padding-top:176px">
            <div class="container">
                <div class="breadcrumb">
                    <nav>
                        <ul>
                            <li><a href="/"><img src="https://ex.tulparstudyo.com/assets/images/home-icon.svg"></a></li>
                            <li><a href="#">Ürün Bulunamadı</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-product-header">
                    <div class="mobile-product-header-inner">
                        <h1 class="product-title">Ürün Bulunmamdı</h1>
                    </div>
                </div>
                <div class="row">
                    <p>
                        Aradığınız Ürün Bulunamadı
                    </p>
                </div>
            </div>
        </section>
    </div>

@endsection
@section('js')



@endsection

