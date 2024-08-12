@extends('layouts.default')

@section('head')
    <title>{{$product['metaTitle']}}</title>
    <link rel="stylesheet" href="{{ url('assets/css/product-details.css') }}?_v={{ env('ASSETS_VER') }}">
    <style>
        .variants-sliders{
            display: none!important;
        }
        .variants-sliders.show{
            display: flex!important;
        }
        .product-color-btns .color-btn button {
            border-radius: 5px;
        }
        .product-color-btns .color-btn.active button {
            background-color:#9ea7ad;
        }
        .product-details .row .right .product-details-area .product-price-area .product-color-btns{
            display: contents;
        }
        .color-btn.instock-0{

        }
        .details-btn{
            cursor: pointer;
        }
    </style>
@endsection
@section('content')

    <?php
    $currentURL = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $favoriteControl=false;

    ?>
    <div id="app-basic">
        <section class="product-details">
            <div class="container">
                <div class="breadcrumb">
                    <nav>
                        <ul>
                            <li><a href="/"><img src="https://ex.tulparstudyo.com/assets/images/home-icon.svg"></a></li>
                            {!! $product->bread_cramps !!}
                            <li><a href="#">{{$product->productName}}</a></li>
                        </ul>
                    </nav>
                </div>
                <div class="mobile-product-header">
                    <div class="mobile-product-header-inner">
                        @if($product->provider)
                        <div class="brand">{{$product->provider->providerName}}</div>
                        @endif
                        <h1 class="product-title">{{$product->productName}}</h1>
                        <div class="rating-area">
                            {!! \Help::getProductStars($product->reviewsAverage) !!}
                            <a href="">Yorum Yap</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                        @foreach ($product->variants as $variant)
                            <div class="left variants-sliders variants-slider-{{ $variant->idColor }} @if($variant->idColor== $selectedVariant->idColor) show @endif ">
                                <div thumbsSlider="" class="swiper product-detail-thumb">
                                    <div class="swiper-wrapper">
                                        @if( $variant->images)
                                            @foreach($variant->images as $image)
                                                <div class="swiper-slide"><img width="80" height="80" src="{{ $image['thumb'] }}" alt=""></div>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                                <div class="swiper product-detail-slider">
                                    <div class="swiper-wrapper">
                                        @if($variant->images)
                                            @foreach($variant->images as $image)
                                                <div class="swiper-slide">
                                                    <div class="swiper-slide">
                                                        <div>
                                                            <img src="{{ $image['url'] }}" alt="" />
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    <div class="swiper-button-next"></div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-pagination d-none"></div>
                                </div>
                            </div>
                        @endforeach

                    <div class="right">
                        <div class="product-details-area">
                            <div class="details-top">
                                <ul class="details-top-left">
                                    <li class="comment"><a href="#">Yorum Yap</a></li>
                                </ul>
                                <ul class="details-top-right">
                                    <li>Barkod:<br>
                                        <div v-text="barcode.barcode">{{ $selectedVariant->barcode }}</div>
                                    </li>
                                    <li>
                                        Ürün Kodu:<br>
                                        <div v-text="product.code">{{ $product->productCode }}</div>
                                    </li>
                                </ul>
                            </div>
                            <div class="detail-title-area">
                                @if($product->provider)
                                <h1 class="product-title">  <a href="{{$product->provider->url}}"> <span>{{$product->provider->providerName}}</span></a> {{$product->productName}}</h1>
                                @endif
                                    <div>
                                    <a href="">  <img src="{{"https://cdn.akilliphone.com/" }}" alt=""></a>
                                </div>
                            </div>
                            <div class="rating-area">
                                {!! \Help::getProductStars($product->reviewsAverage) !!}
                            </div>
                            <div class="product-price-area align-items-baseline">
                                <div class="product-price-area-top ">
                                    <div class="product-price ">{{ $product->formatted_sale_price}}</div>
                                    @if($product->discounted)
                                        <div class="product-oldprice" >{{ $product->formatted_old_price }}</div>
                                        <div class="discount" >% {{ $product->discountRate }}</div>
                                    @endif
                                </div>
                                <div class="product-color-btns">
                                    <span class="title">Renk:</span>
                                    @foreach ($product->variants as $variant)
                                        <div class="color-btn instock-{{ (int)($variant->amount > 0) }} @if($variant->idColor== $selectedVariant->idColor) active @endif " data-idcolor="{{ $variant->idColor }}">
                                            @if($variant->images)
                                                <button style="height: 100%;width: 100%" @if($variant->amount <= 0) disabled @endif ><img src="{{ $variant->images[0]['thumb'] }}" alt=""></button>
                                            @endif
                                            @if($variant->idColor)
                                                <div class="tooltip">
                                                    {{$variant->color->name}}
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>

                                <div class="product-price-area-bottom">
                                    <div class="qty-input">
                                        <button class="qty-count qty-count--minus" data-action="minus" type="button">-</button>
                                        <input id="product-qty" class="product-qty" type="number" name="product-qty" min="1" max="10" value="1" data-product_id="{{ $idProduct }}" data-color_id="{{ $selectedIdColor }}">
                                        <button class="qty-count qty-count--add" data-action="add" type="button">+</button>
                                    </div>
                                    <div class="addtocart" ><button style="cursor:pointer;">Sepete Ekle</button></div>


                                    <div class="iconcart">
                                        @if($favoriteControl==true)
                                            <a class="favorite-btn" id="favorite-btn" style="cursor:pointer;background-color: red"><svg xmlns="http://www.w3.org/2000/svg" width="16.5" height="16.5"
                                                                                                                                        viewBox="0 0 16.5 16.5">
                                                    <path id="noun_Heart_2102871_1_" data-name="noun_Heart_2102871 (1)"
                                                          d="M17.679,6A4.631,4.631,0,0,0,14.25,7.554,4.631,4.631,0,0,0,10.821,6,5.045,5.045,0,0,0,6,11.233c0,4.212,7.478,10.817,7.8,11.1a.688.688,0,0,0,.9.008c.319-.27,7.805-6.664,7.805-11.1A5.045,5.045,0,0,0,17.679,6ZM14.257,20.9c-2.271-2.079-6.882-6.877-6.882-9.663a3.673,3.673,0,0,1,3.446-3.858,3.361,3.361,0,0,1,2.843,1.679.687.687,0,0,0,1.172,0,3.362,3.362,0,0,1,2.843-1.679,3.673,3.673,0,0,1,3.446,3.858C21.125,14.179,16.527,18.876,14.257,20.9Z"
                                                          transform="translate(-6 -6)" fill="#d8d8d8" />
                                                </svg>
                                            </a>
                                        @else
                                            <a class="favorite-btn" id="favorite-btn" style="cursor:pointer;background-color: white"><svg xmlns="http://www.w3.org/2000/svg" width="16.5" height="16.5"
                                                                                                                                          viewBox="0 0 16.5 16.5">
                                                    <path id="noun_Heart_2102871_1_" data-name="noun_Heart_2102871 (1)"
                                                          d="M17.679,6A4.631,4.631,0,0,0,14.25,7.554,4.631,4.631,0,0,0,10.821,6,5.045,5.045,0,0,0,6,11.233c0,4.212,7.478,10.817,7.8,11.1a.688.688,0,0,0,.9.008c.319-.27,7.805-6.664,7.805-11.1A5.045,5.045,0,0,0,17.679,6ZM14.257,20.9c-2.271-2.079-6.882-6.877-6.882-9.663a3.673,3.673,0,0,1,3.446-3.858,3.361,3.361,0,0,1,2.843,1.679.687.687,0,0,0,1.172,0,3.362,3.362,0,0,1,2.843-1.679,3.673,3.673,0,0,1,3.446,3.858C21.125,14.179,16.527,18.876,14.257,20.9Z"
                                                          transform="translate(-6 -6)" fill="#d8d8d8" />
                                                </svg>
                                            </a>
                                        @endif


                                        <div class="share-btn">
                    <span>
                      <svg xmlns="http://www.w3.org/2000/svg" width="17.982" height="17.962"
                           viewBox="0 0 17.982 17.962">
                        <path id="share"
                              d="M14.462,10.976a3.487,3.487,0,0,0-2.873,1.515l-4.871-2.2a3.423,3.423,0,0,0,0-2.61L11.586,5.47a3.487,3.487,0,1,0-.619-1.978,3.467,3.467,0,0,0,.06.588L5.855,6.431a3.493,3.493,0,1,0-.011,5.109l5.185,2.341a3.544,3.544,0,0,0-.059.587,3.493,3.493,0,1,0,3.492-3.492Zm0-9.48a2,2,0,1,1-2,2,2,2,0,0,1,2-2ZM3.486,10.976a2,2,0,1,1,2-2,2,2,0,0,1-2,2Zm10.976,5.488a2,2,0,1,1,2-2,2,2,0,0,1-2,2Z"
                              transform="translate(0.026 0.001)" fill="#d8d8d8" />
                      </svg>
                    </span>
                                            <ul class="share-links">
                                                <li>
                                                    <a href="https://wa.me/?text=Ürünü İncele {{$currentURL}}" class="share-link">
                                                        <div class="icon"></div>
                                                        <div class="name">Whatsapp'dan paylaş</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.facebook.com/sharer.php?u={{$currentURL}}" class="share-link">
                                                        <div class="icon"></div>
                                                        <div class="name">Facebook'ta paylaş</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://twitter.com/share?url={{$currentURL}}" class="share-link">
                                                        <div class="icon"></div>
                                                        <div class="name">Twitter'da paylaş</div>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="https://www.instagram.com/share?url={{$currentURL}}" class="share-link">
                                                        <div class="icon"></div>
                                                        <div class="name">Instagram'da paylaş</div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="shipping-tabs">
                                    <div class="tab">
                                        <button class="tablinks active" onclick="openCity(event, 'shipping')">Aynı Gün<br>Kargo <img
                                                src="{{ url('assets/images/ayni-gun.svg') }}" alt=""></button>
                                        <button class="tablinks" onclick="openCity(event, 'freeShipping')">Kargo<br>Bedava <img
                                                src="{{ url('assets/images/ucretsiz-kargo.svg') }}"  alt=""></button>
                                        <button class="tablinks" onclick="openCity(event, 'rebate')">Kolay<br>İade <img
                                                src="{{ url('assets/images/kolay-iade.svg') }}"  alt=""></button>
                                    </div>
                                    <div id="shipping" class="tabcontent" style="display:block;">
                                        Saat 17:00’a kadar verdiğiniz siparişleri aynı gün kargoya teslim ediyoruz.

                                    </div>
                                    <div id="freeShipping" class="tabcontent">
                                         \BasketService::getFreeShippingLimit() ₺ ve üzeri alışverişlerde KARGO BEDAVA
                                    </div>
                                    <div id="rebate" class="tabcontent">
                                        Ürünü satın aldığınız tarihten itibaren 14 gün içinde nedenini belirterek iade hakkınız bulunmaktadır. İade etmek istediğiniz ürünün, kullanılmamış, hasarsız ve orijinal ambalajında olması gerekmektedir.
                                    </div>
                                    <div id="hirePurch" class="tabcontent">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section>
            <div class="container">
                <div class="product-spec-tabs">
                    <div class="tab">
                        <button class="tabSpec active" onclick="openSpecTab(event, 'Description')">Açıklama</button>
                        <button class="tabSpec" onclick="openSpecTab(event, 'Yorum')">Yorumlar ({{ $product->reviews['count'] }})</button>
                        <button class="tabSpec" onclick="openSpecTab(event, 'Soru')">Soru & Cevap ({{ $product->questions['count'] }})</button>
                    </div>

                    <div id="Description" class="tabDetails" style="display:block;text-align: -webkit-center">

                        <?php
                        echo $product->productDescription?>

                    </div>
                    <div class="showMore">
                            <button class="showMoreBtn" id="showMoreDetail">Daha Fazla</button>
                    </div>
                    <div id="Yorum" class="tabDetails">
                        @if($product->reviews['count'])
                            @foreach($product->reviews['items']  as $review)

                                <div class="comment-list">
                                    <div class="comment-item">
                                        <div class="left">
                                            <div class="buyer">
                                            </div>
                                        </div>
                                        <div class="right">
                                            <div class="top">
                                                <div class="rating-area">
                                                    {!! \Help::getStars($review->reviewPoint) !!}
                                                </div>
                                                <div class="date">
                                                    {{ \Help::humanDate($review->date)}}
                                                </div>
                                                <strong style="font-weight: bold">
                                                    @if($review->reviewName)
                                                        {{  html_entity_decode($review->reviewName)  }} {{  html_entity_decode($review->reviewSurname) }}
                                                    @else
                                                        Gizli Üye
                                                    @endif
                                                </strong>

                                            </div>
                                            <div class="comment" style="background-color:white;font-weight: bold">
                                                {{$review->reviewCaption}}
                                            </div>
                                            <div class="comment">
                                                {{$review->reviewText}}
                                            </div>
                                        </div>
                                    </div>
                                </div>


                            @endforeach
                        @else
                            <p style="text-align: center;">Henüz yapılmış bir yorum bulunamadı</p>
                        @endif
                        @if($product->commentAble)
                            <button class="btn" id="btn-comment">Yorum Yap</button>
                        @endif

                        <div class="review-menu" id="review-menu">
                            <form id="formReview" method="post" class="review-menu-details">
                                <div class="details-title">Ürünü Değerlendir</div>
                                <svg id="close-review-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6L8.4 17Zm3.6 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Z" />
                                </svg>
                                <div class="review-wrapper">
                                    <fieldset class="rating" name="rating" id="rating">
                                        <input type="radio" id="star5" name="reviewPoint" value="5" /><label class="full" for="star5"
                                                                                                        title="Awesome - 5 stars"></label>
                                        <input type="radio" id="star4" name="reviewPoint" value="4" /><label class="full" for="star4"
                                                                                                        title="Pretty good - 4 stars"></label>
                                        <input type="radio" id="star3" name="reviewPoint" value="3" /><label class="full" for="star3"
                                                                                                        title="Meh - 3 stars"></label>
                                        <input type="radio" id="star2" name="reviewPoint" value="2" /><label class="full" for="star2"
                                                                                                        title="Kinda bad - 2 stars"></label>
                                        <input type="radio" id="star1" name="reviewPoint" value="1" /><label class="full" for="star1"
                                                                                                        title="Sucks big time - 1 star"></label>
                                    </fieldset>
                                    <input required type="text" name="reviewCaption" placeholder="Başlık" id="reviewCaption" value="" class="review-text" style="height: 50px !important;">
                                    <textarea required id="review" placeholder="Değerlendirmenizle ilgili detayları burada belirtebilirsiniz." class="review-text" maxlength="2000" name="reviewText" style="margin-top: 15px"></textarea>

                                </div>
                                 @csrf
                                <input name="idProduct" value="{{ $product->id }}">
                                <button type="submit" id="submitReview">Değerlendir</button>
                            </form>
                        </div>
                        <div id="close-review-canvas" class="close-review-canvas"></div>
                    </div>
                    <div id="Soru" class="tabDetails">
                        <div class="question-list">
                                @if($product->questions['count'])
                                    @foreach($product->questions['items']  as $question)
                                        <div class="question-item">
                                            <div class="question">
                                                <div class="title" >Soru</div>
                                                <div class="text" >
                                                    {{ $question->reviewText }}
                                                    <div class="answer">
                                                        <div class="title">Cevap</div>
                                                        <div class="text">{{ $question->reviewAnswer }}</div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    @endforeach
                                @endif

                        </div>
                        @if(Help::isLogged())
                            <button id="open-details" class="details-btn">Soru Sor</button>
                        @else
                            <button class="details-btn">Soru Sormak İçin Giriş Yapmalısınız </button>
                        @endif


                        <div class="site-menu" id="site-menu">
                            <div class="site-menu-details">
                                <div class="details-title">Soru Sor</div>
                                <svg id="close-menu" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                          d="m8.4 17l3.6-3.6l3.6 3.6l1.4-1.4l-3.6-3.6L17 8.4L15.6 7L12 10.6L8.4 7L7 8.4l3.6 3.6L7 15.6L8.4 17Zm3.6 5q-2.075 0-3.9-.788t-3.175-2.137q-1.35-1.35-2.137-3.175T2 12q0-2.075.788-3.9t2.137-3.175q1.35-1.35 3.175-2.137T12 2q2.075 0 3.9.788t3.175 2.137q1.35 1.35 2.138 3.175T22 12q0 2.075-.788 3.9t-2.137 3.175q-1.35 1.35-3.175 2.138T12 22Z" />
                                </svg>
                                <div class="question-form">
                                    <div class="question-wrapper">
                  <textarea placeholder="Sorunuzla ilgili detayları burada belirtebilirsiniz." id="question"
                            maxlength="2000" oninput="checkLength()"></textarea>
                                        <span id="remainingCharacter">
                    2000
                  </span>
                                    </div>
                                    <button id="submitQuestion" disabled>Gönder</button>
                                </div>

                            </div>
                        </div>
                        <div id="close-canvas" class="close-canvas"></div>
                    </div>
                </div>
            </div>
        </section>

        <x-product.recently-viewed />
    </div>

@endsection
@section('js')
    <script>
        console.log("{{ $product->formula }}");
    </script>
<script>
    /** variyant images begin */
    @foreach ($product->variants as $variant)
    var productThumb{{ $variant->idColor }} = new Swiper(".variants-slider-{{ $variant->idColor }} .product-detail-thumb", {
        slidesPerView: 3,
        direction: "vertical",
        watchSlidesProgress: true,
    });
    var swiper{{ $variant->idColor }} = new Swiper(".variants-slider-{{ $variant->idColor }} .product-detail-slider", {
        slidesPerView: 1,
        centeredSlides: true,
        spaceBetween: 38,
        navigation: true,
        thumbs: {
            swiper: productThumb{{ $variant->idColor }},
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        pagination: {
            el: ".swiper-pagination",
        },
        breakpoints: {
            992: {
                pagination: false,
            },
        },

    });
    @endforeach
    /** variyant images end */
    $('.product-color-btns .color-btn').on('click', function(){
        $('.variants-sliders').removeClass('show');
        $('.product-color-btns .color-btn').removeClass('active');
        $('.variants-sliders.variants-slider-' + $(this).data('idcolor')).addClass('show');
        $(this).addClass('active');
        $('#product-qty').data('product_id', '{{ $product->id }}');
        $('#product-qty').data('color_id', $(this).data('idcolor'));
        //console.log('{{ $product->id }}', $(this).data('idcolor'));
    });
    var QtyInput = (function () {
        var $qtyInputs = $(".qty-input");
        if (!$qtyInputs.length) {
            return;
        }
        var $inputs = $qtyInputs.find(".product-qty");
        var $countBtn = $qtyInputs.find(".qty-count");
        var qtyMin = parseInt($inputs.attr("min"));
        var qtyMax = parseInt($inputs.attr("max"));

        $inputs.change(function () {
            var $this = $(this);
            var $minusBtn = $this.siblings(".qty-count--minus");
            var $addBtn = $this.siblings(".qty-count--add");
            var qty = parseInt($this.val());

            if (isNaN(qty) || qty <= qtyMin) {
                $this.val(qtyMin);
                $minusBtn.attr("disabled", true);
            } else {
                $minusBtn.attr("disabled", false);

                if (qty >= qtyMax) {
                    $this.val(qtyMax);
                    $addBtn.attr('disabled', true);
                } else {
                    $this.val(qty);
                    $addBtn.attr('disabled', false);
                }
            }
        });

        $countBtn.click(function () {
            var operator = this.dataset.action;
            var $this = $(this);
            var $input = $this.siblings(".product-qty");
            var qty = parseInt($input.val());

            if (operator == "add") {
                qty += 1;
                if (qty >= qtyMin + 1) {
                    $this.siblings(".qty-count--minus").attr("disabled", false);
                }

                if (qty >= qtyMax) {
                    $this.attr("disabled", true);
                }
            } else {
                qty = qty <= qtyMin ? qtyMin : (qty -= 1);

                if (qty == qtyMin) {
                    $this.attr("disabled", true);
                }

                if (qty < qtyMax) {
                    $this.siblings(".qty-count--add").attr("disabled", false);
                }
            }
            $input.val(qty);
        });
    })();
    function openSpecTab(evt, tabName) {
        var i, tabDetails, tabSpec;
        tabDetails = document.getElementsByClassName("tabDetails");
        for (i = 0; i < tabDetails.length; i++) {
            tabDetails[i].style.display = "none";
        }
        tabSpec = document.getElementsByClassName("tabSpec");
        for (i = 0; i < tabSpec.length; i++) {
            tabSpec[i].className = tabSpec[i].className.replace(" active", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " active";
        if (tabName == "Description") {
            document.getElementById("showMoreDetail").style.display = "block";
            document.getElementById("showMoreDetail").className = "showMoreBtn";
        } else {
            document.getElementById("showMoreDetail").style.display = "none";
            document.getElementById("showMoreDetail").className = "";
        }
    }
    const showMoreButton = document.querySelector('.showMoreBtn');
    if(showMoreButton){
        showMoreButton.addEventListener('click', function () {
            const tabDetailsDiv = document.querySelector('.tabDetails');
            if (tabDetailsDiv.classList.contains('showAll')) {
                tabDetailsDiv.classList.remove('showAll');
                showMoreButton.innerHTML = 'Daha Fazla';
            } else {
                tabDetailsDiv.classList.add('showAll');
                showMoreButton.innerHTML = 'Daha Az';
            }
        });
    }
    $('#btn-comment').on('click', function () {
        $('#review-menu').toggleClass('review-menu--active');
    });
    $('#close-review-menu').on('click', function () {
        $('#review-menu').toggleClass('review-menu--active');
    });
    $('#formReview').on('submit', function (e) {
        e.preventDefault();

        $.ajax( {
            url:'{{ route('product.review.add') }}',
            method:'POST',
            data: $(this).serialize()
        } ).done(function(review) {

                Swal.fire({
                    title: review.message,
                    toast: true,
                    position: 'top-start',
                    timer: 3000,
                    icon: review.status ? 'success':'error',
                    showConfirmButton: false,
                });
                if(review.status){
                    $('#review-menu').toggleClass('review-menu--active');
                    window.location.reload();
                }

        }).fail(function() {
                Swal.fire({
                    title: 'Yorum Tapılamadı. Lütfen daha sonra tekrar deneyiniz.',
                    toast: true,
                    position: 'top-start',
                    timer: 3000,
                    icon: 'error',
                    showConfirmButton: false,
                });

            });

    })
    /*

        let siteMenu = document.getElementById('site-menu');
        let openBtn = document.getElementById('open-details');
        let closeCanvas = document.getElementById('close-canvas');
        let closeMenu = document.getElementById('close-menu');
        if(closeMenu){
            closeMenu.addEventListener("click", function () {
                if (siteMenu.classList.contains('site-menu--active')) {
                    siteMenu.classList.remove('site-menu--active')
                    closeCanvas.style.display = "none"
                    document.body.style.overflow = 'auto'
                }
            })
        }

        openBtn.addEventListener("click", function(){
            if (siteMenu.classList.contains('site-menu')) {
                siteMenu.classList.add('site-menu--active')
                closeCanvas.style.display = "block"
                document.body.style.overflow = 'hidden'
            }
        })
        closeCanvas.addEventListener("click", function(){
            if (siteMenu.classList.contains('site-menu--active')) {
                siteMenu.classList.remove('site-menu--active')
                closeCanvas.style.display = "none"
                document.body.style.overflow = 'auto'
            }
        })
        function checkLength() {
            const maxLength = 2000;
            const question = document.getElementById("question").value;
            const remainingChars = maxLength - question.length;
            const remainingCharacter = document.getElementById("remainingCharacter");
            remainingCharacter.innerText = `${remainingChars}`;
            const submitButton = document.getElementById("submitQuestion");

            if (question.length >= 3) {
                submitButton.disabled = false;
                submitButton.classList.add("active");
            } else {
                submitButton.disabled = true;
                submitButton.classList.remove("active");
            }
            console.log(question.length)
        }
     */
</script>

@endsection

