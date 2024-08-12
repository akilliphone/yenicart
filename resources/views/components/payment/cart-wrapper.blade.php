<div class="cart-wrapper">
    <div class="header">
        <div class="title">Sepetim</div>
        <span class="item-count">{{ $basket->basketItemCount }}</span>
    </div>
    <!--<div class="body">
                @foreach($basket->basketItems as $item)

        <div class="purchased">
            <img src="{{ $item['featuredImage'] }}" alt="">
                    <div class="info">
                        <div class="name">{{ $item['productName'] }}<br>{{ $item['name'] }}</div>
                        <div class="price">{{ $item['total'] }}<span>&nbsp;TL</span></div>
                    </div>
                </div>
                @endforeach
    </div>-->
    <div class="total">
        @if($basket->basketSubtotals)
            @foreach($basket->basketSubtotals as $basketSubtotal)
                @if($basketSubtotal)
                    <div class="info-total">
                        <div class="descr">{{ $basketSubtotal['title'] }}</div>
                        <div class="price">{{ $basketSubtotal['total'] }}<span>&nbsp;TL</span></div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
    <div class="basket-messages">
        @if($basket->shippingBrand && isset($basket->shippingBrands[$basket->shippingBrand]))
            <div class="basket-message info">{{ $basket->shippingBrands[$basket->shippingBrand]['title'] }} İle Gönderilecek</div>
        @endif
        @foreach($basket->alerts as $alert)
            <div class="basket-message {{ $alert['class'] }}">{{ $alert['message'] }}</div>
        @endforeach
    </div>
    <div class="total-footer">
        <div class="info-total">
            <div class="descr">Toplam</div>
            <div class="price">{{ $basket->total }}<span>&nbsp;TL</span></div>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}" />
        <button class="payment-next" type="submit">{{ $buttonText }}</button>
    </div>
</div>
