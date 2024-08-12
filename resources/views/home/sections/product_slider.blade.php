@if(isset($content['product_slider']) && $content['product_slider'])
    <section class="four-product-slider section-padding mx-24">
        <div class="container">
            <div id="product_slider" class="four-slider owl-carousel owl-theme">
                @foreach($content['product_slider']->items as $item)
                    <a href="{{ $item['product']->url }}" class="big-product-card" >
                        <div class="card-category">
                            <img width="232" height="147" src="{{ $item['desktopImage'] }}" alt="{{ $item['product']->productName }}">
                        </div>
                        <div class="card-details">
                            <div class="product-image">
                                <img width="82" height="82" src="{{$item['product']->thumb}}" alt="Ürün Resmi">
                            </div>
                            <div class="product-info">
                                <div class="product-name">{{$item['product']->productName}}</div>
                                <div class="product-prices">
                                    <div class="current">
                                        <span class="price">{{$item['product']->formatted_sale_price}}</span>
                                        @if($item['product']->discounted)
                                            <span class="discount"> % {{$item['product']->discountRate}}</span>
                                        @endif
                                    </div>
                                    @if($item['product']->discounted)
                                        <div class="product-old-price">{{$item['product']->formatted_old_price}}</div>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

@endif
