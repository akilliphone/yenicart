@extends('layouts.default')
@section('head')
    <title>{{ $pageTitle }} AkıllıPhone</title>
    <link rel="stylesheet" href='{{ url("assets/css/profile/".$page."/main.css") }}'>
    <link rel="stylesheet" href="{{ url('assets/css/profile/informations/main.css') }}">
@endsection
@section('content')
    <section class="profile section-padding mx-24" style="margin-top: 150px">
        <div class="container">
            <div class="section-title">{{ $pageTitle }}</div>
            <div class="profile-layout">
                @include('profile.left-sidebar')
                <div class="right">
                    @include('profile.pages.'.$page)
                </div>
            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="../assets/js/profile/order/profile-order.js"></script>
@endsection
