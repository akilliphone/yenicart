@extends('layouts.default')
@section('head')
    <title>{{ $page['seoTitle'] }} - AkilliPhone</title>
    <link rel="stylesheet" href="{{ url('assets/css/contact-us.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/aboutUs.css?_t=1.01') }}">
    <link rel="stylesheet" href="{{ url('assets/css/dropshipping.css') }}">

@endsection
@section('content')
    <section class="filter-section section-padding product-listing">
        <div id="container" class="container">
            <div class="contact-us-title">
                <h1 class="main-title">{{ $page['seoTitle'] }}</h1>
            </div>
            <div class="row">
                <div class="col-12"></div>
                <div class="col-12">{!! $page['content'] !!} </div>
            </div>
        </div>
    </section>
@endsection
