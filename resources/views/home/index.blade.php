@extends('layouts.default')
@section('body_class') home loading-php @endsection
@section('head')
    <title>{{ $seoSettings->mainPageTitle }} | AkilliPhone.com</title>
    <style>
        .three-category-block{
            display: flex;
            flex-wrap: wrap;
            background-color: #cdcdcd;
            padding: 40px 10px 0px 10px;
        }
        .three-category-block-item{
            flex: 1 0 20%;
        }
        .login-btn{
            min-width: 182px;
            text-align: center;
        }
        .desktop-header .navbar .right-section .login-btn .dropdown-box{
            top: auto;
        }
        #main_slider{
            min-height:  670px;
        }
        @media (max-width: 850px){
            #main_slider{
                min-height:  400px;
            }
        }
    </style>
@endsection
@section('content')
    @include('home.sections.main_slider')
    <x-sections.tall_banner :content="$content" :orderNumber="'2'" :title="'Tall Banner 1'" />
    @include('home.sections.product_slider')
    <x-sections.carousel :content="$content" :sectionId="'newly'" :title="'Yeni Ürünler'" :slug="'/reyonlar?offset=12&page=1&section=new_arrivals'" :oldslug="'yeniurunler?orderby=idProduct&dir=desc'"/>
{{--    @include('home.sections.three_banner')  --}}
    <x-sections.tall_banner :content="$content" :orderNumber="'2'" :title="'Tall Banner 2'" />
    <x-sections.carousel :content="$content" :sectionId="'bestseller'" :title="'Çok Satan Ürünler'" :oldslug="'coksatanlar?orderby=saleCount&dir=desc'" />
    <x-sections.carousel :content="$content" :sectionId="'restock'" :title="'Yeniden Stokta'" :oldslug="'stokgelenler?orderby=newStockDate&dir=desc'" />
    <x-sections.carousel :content="$content" :sectionId="'onsale'" :title="'İndirime Girenler'" :oldslug="'indirimliler?orderby=oldPriceDate&dir=desc&custom=onsale'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_accessory'" :title="'Aksesuarlar'" :oldslug="'aksesuarlar-207'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_car'" :title="'Araç Aksesuarları'" :oldslug="'arac-aksesuarlari-280'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_home'" :title="'Ev Yaşam'" :oldslug="'ev-yasam-327'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_powerbank'" :title="'Şarj Aletleri'" :oldslug="'sarj-aletleri-203'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_converters'" :title="'Dönüştürücüler'" :oldslug="'kablolar-ve-donusturuculer-209'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_sound'" :title="'Ses Sistemleri'" :oldslug="'ses-sistemleri-157'"/>
    <x-sections.carousel :content="$content" :sectionId="'cat_personel'" :title="'Kişisel Ürünler'" :oldslug="'kisisel-bakim-337'"/>
    @include('home.sections.brand_slider')
@endsection

@section('js')
    <script>
        function create_main_slider(){
            $(document).ready(function () {
                let owl = $(".home-slider").owlCarousel({
                    stageOuterClass: 'home-slider-inner',
                    stagePadding: 0,
                    smartSpeed: 450,
                    fluidSpeed:1000,
                    navSpeed:1000,
                    dotsSpeed:1000,
                    dotsClass: 'container owl-dots',
                    responsiveClass: true,
                    loop:true,
                    autoplay:true,
                    navContainerClass: 'container owl-nav',
                    nav: true,
                    responsive: {
                        0: {
                            items: 2,
                            autoWidth: true,
                            margin: 10,
                            center: true,
                        },
                        768: {
                            items: 1,
                            nav: false,
                            autoWidth: false,
                            center: false,
                            dots: false
                        },
                        1200: {
                            items: 1,
                            dots: true
                        },
                    }
                });
                $('.owl-dot').click(function () {
                    owl.trigger('to.owl.carousel', [$(this).index(), 0]);
                })
                owl.trigger('refresh.owl.carousel');
            })
        }
        create_main_slider();
        function create_product_slider(){
            $(document).ready(function () {
                $(".four-slider").owlCarousel({
                    dots: false,
                    responsiveClass: true,
                    responsive: {
                        0: {
                            items: 2,
                            autoWidth: true,
                            center: true,
                            loop: false,
                            margin: 17,
                            loop: true
                        },
                        1200: {
                            items: 4,
                            autoWidth: true,
                            margin: 30,
                            drag: false,
                            mouseDrag: false,
                        }
                    }
                });
            });
        }
        create_product_slider();
        function create_home_brand_slider() {
            $(document).ready(function () {
                if($('.brand-slider').length){
                    const swiper = new Swiper('.brand-slider', {
                        slidesPerView: 3,
                        spaceBetween: 30,
                        autoplay: {
                            delay: 2500,
                            disableOnInteraction: false,
                        },
                        breakpoints: {
                            300: {
                                slidesPerView: 1,
                                grid: {
                                    rows: 2,
                                },
                            },
                            576: {
                                slidesPerView: 2,
                                grid: {
                                    rows: 2,
                                },
                            },
                            768: {
                                slidesPerView: 3,
                                grid: {
                                    rows: 3,
                                },
                            },
                        },
                    });
                }
            });
        }
        create_home_brand_slider();


    </script>
@endsection

