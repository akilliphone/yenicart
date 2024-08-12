<!DOCTYPE html>
<html lang="tr" xmlns="http://www.w3.org/1999/xhtml" class="" style="--vh: 4.78px;">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="content-language" content="TR"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="format-detection" content="telephone=no">
    <meta name="keywords" content="{{ $seoSettings->mainPageKeywords }}" />
    <meta name="description" content="{{ $seoSettings->mainPageDescription }}" />
    <meta name='Petal-Search-site-verification' content='a0d641677f'/>
{{--    <link id="favicon" rel="shortcut icon" type="image/png" href="/views/kuteshop/img/favicon.png?v=9">--}}
    @if(isset($ogs))
        @foreach($ogs as $og)
            <meta property="{{ $og['property'] }}" content="{{ $og['content'] }}" />
        @endforeach
    @endif

    <meta name="google-site-verification" content="kkuNT7EkMxMyeUdqWbC_fL8A6iiBx66oBs4S-IQWM2A" />
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}?_v={{ env('ASSETS_VER') }}">
    <link rel="stylesheet" href="{{ url('assets/css/header.css') }}?_v={{ env('ASSETS_VER') }}">
    <link rel="stylesheet" href="{{ url('assets/css/footer.css') }}?_v={{ env('ASSETS_VER') }}">
    <link rel="stylesheet" href="{{ url('assets/css/main.css') }}?_v={{ env('ASSETS_VER') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css?_v={{ env('ASSETS_VER') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
{{--    <script src="{{ url('assets/js/webService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>--}}
{{--    <script src="{{ url('assets/js/basketService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>--}}
{{--    <script src="{{ url('assets/js/contact-us.js') }}?_v={{ env('ASSETS_VER') }}"></script>--}}
    <script src="{{ url('assets/js/owl.carousel.min.js') }}?_v={{ env('ASSETS_VER') }}"></script>
    <script src="{{ url('assets/js/owl.carousel.thumb.js') }}?_v={{ env('ASSETS_VER') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?_v={{ env('ASSETS_VER') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-N8XV95D');
    </script>
    <!-- End Google Tag Manager -->
    <style>
        .ajaxForm button.disabled{
            background-color: #9c9c9c!important;
        }
        .ajaxForm button.disabled:before{
            content:"... ";
        }
        .scroll-to-top {
            position: fixed;
            bottom: 35px;
            right: 20px;
            width: 40px;
            height: 40px;
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 40px;
            font-size: 20px;
            cursor: pointer;
            display: none; /* initially hide the button */
        }

        .scroll-to-top:hover {
            background-color:#0056b3;
        }
        .swal2-popup.swal2-toast .swal2-title {
            font-size: 12px!important;
        }
        .ajax-search strong {
            color: #0a6aa1;
        }
        .ajax-search li img {
            float: left;
            margin: 0px 10px 10px 0px;
        }
        .ajax-search li a{
            font-weight: bold;
        }
        .ajax-search li:hover a{
            color: #d20c0c!important;
        }
        .searchText {
            background-color: transparent;
            border: 0px;
        }
        .input-icon{
            cursor: pointer;
        }
        body.loading{
            visibility: hidden;
        }
    </style>
    @yield('head', '')

</head>
<body class="@yield('body_class')">

@include('layouts.header')
<div id="app-content">
    @yield('content', '')
    <div class="scroll-to-top" onclick="scrollToTop()">&#8593;</div>

</div>
@include('layouts.footer')
@include('layouts.js')
@yield('js', '')
</body>
</html>
