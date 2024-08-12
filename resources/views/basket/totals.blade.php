<div class="totals">
    <div class="totals-header">
        <span>Sipariş Özeti</span>
        <span>{{ $basket->basketItemCount }} ürün</span>
    </div>
    <div class="totals-item totals-item-total">
        <label>Ödenecek Tutar</label>
        <div class="totals-value">{{ $basket->formatted_total }}</div>
    </div>
    @if( isset($showDropshipping) && $showDropshipping /*&& userHasDropshipping()*/)
        <button type="submit" href="{{ route('payment.index') }}" class="checkout">Alışverişi Tamamla
            <svg xmlns="http://www.w3.org/2000/svg" width="6.242" height="10.95" viewBox="0 0 6.242 10.95">
                <g id="flaticon1568189262-svg" transform="translate(-97.139 0)">
                    <path id="Path_1398" data-name="Path 1398" d="M103.156,6.017l-4.708,4.708a.767.767,0,0,1-1.084-1.084l4.166-4.166L97.363,1.309A.767.767,0,0,1,98.448.224l4.708,4.708a.767.767,0,0,1,0,1.084Z" fill="#fff"></path>
                </g>
            </svg>
        </button>
    @else
        <a type="submit" href="{{ route('payment.index') }}" class="checkout">Alışverişi Tamamla
            <svg xmlns="http://www.w3.org/2000/svg" width="6.242" height="10.95" viewBox="0 0 6.242 10.95">
                <g id="flaticon1568189262-svg" transform="translate(-97.139 0)">
                    <path id="Path_1398" data-name="Path 1398" d="M103.156,6.017l-4.708,4.708a.767.767,0,0,1-1.084-1.084l4.166-4.166L97.363,1.309A.767.767,0,0,1,98.448.224l4.708,4.708a.767.767,0,0,1,0,1.084Z" fill="#fff"></path>
                </g>
            </svg>
        </a>
    @endif
    @if($basket->basketSubtotals)
        @foreach($basket->basketSubtotals as $basketSubtotal)
            @if($basketSubtotal)
                <div class="totals-item">
                    <label>{{ $basketSubtotal['title'] }}</label>
                    <div class="totals-value" id="cart-subtotal">{{ $basketSubtotal['total'] }}&nbsp;</div>
                </div>
            @endif
        @endforeach
    @endif
    {{--                <div class="coupon-section">--}}
    {{--                    <div class="title">Çek / Promosyon Kodu Kullan</div>--}}
    {{--                    <div class="coupon">--}}
    {{--                        <input type="text" placeholder="Kodu Girin.">--}}
    {{--                        <button class="submit-coupon">--}}
    {{--                            <svg xmlns="http://www.w3.org/2000/svg" width="6.242" height="10.95" viewBox="0 0 6.242 10.95">--}}
    {{--                                <g id="flaticon1568189262-svg" transform="translate(-97.139 0)">--}}
    {{--                                    <path id="Path_1398" data-name="Path 1398" d="M103.156,6.017l-4.708,4.708a.767.767,0,0,1-1.084-1.084l4.166-4.166L97.363,1.309A.767.767,0,0,1,98.448.224l4.708,4.708a.767.767,0,0,1,0,1.084Z" fill="#fff"></path>--}}
    {{--                                </g>--}}
    {{--                            </svg>--}}
    {{--                        </button>--}}
    {{--                    </div>--}}
    {{--                </div>--}}
    <div class="basket-messages">
        @foreach($basket->alerts as $alert)
            <div class="basket-message {{ $alert['class'] }}">{{ $alert['message'] }}</div>
        @endforeach
    </div>
</div>
