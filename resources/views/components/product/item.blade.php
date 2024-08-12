@if(isset($product) && $product)
    <div class="product-item">
        <a href="{{$product->url}}">
            <div class="product-image">
                <img class="lazyload" style="height:160px;width: 160px;" alt="{{$product->productName}}" src="{{$product->thumb}}">
            </div>
            <div class="product-info">
                <div class="product-name">{{$product->productName}}</div>
                <div class="product-price">
                    <span>{{$product->formatted_sale_price}}</span>
                    @if($product->discounted)
                        <span class="discount"> % {{$product->discountRate}} </span>
                    @endif
                </div>
                @if($product->discounted)
                    <div class="product-old-price">{{$product->formatted_old_price}}</div>
                @endif
            </div>
        </a>
    </div>

@endif
