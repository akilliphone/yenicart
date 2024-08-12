<style>
    .product-dropshipping{
        display: flex;
        width: 100%;
    }
    .product-dropshipping table td{
        padding: 5px;
        font-size: 12px;
    }
    .product-dropshipping .form-control{
        border: 1px solid #cdcdcd;
        padding: 5px 10px;
    }
    .product-delete {
        position: absolute;
        margin-left: -10px;
        margin-top: -10px;
        width: 20px;
        height: 20px;
        border: 1px solid #cdcdcd;
        line-height: 16px;
        border-radius: 50%;
        background-color: #f03737;
        cursor: pointer;
    }
</style>
<div class="cart-wrapper">
    <div class="details-wrapper">
        <h1 class="basket_title">Sepetim</h1>
        <div class="shopping-cart">
            <div class="column-labels">
                <label class="product-details"></label>
                <label class="product-image"></label>
                <label class="product-details"></label>
                <label class="product-quantity">ADET</label>
                <label class="product-line-price text-start ps-3">FİYAT</label>
            </div>

            @if($basket->basketItems)
                @foreach($basket->basketItems as $item)
                    <div class="product">
                        <div class="product-image">
                            <div class="product-delete" data-itemcode="{{ $item['itemCode'] }}"><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="1 0 24 24"><path fill="#fff" d="M6 19c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7H6v12zM19 4h-3.5l-1-1h-5l-1 1H5v2h14V4z"></path></svg></div>
                            <img src="{{ $item['featuredImage'] }}">
                        </div>
                        <div class="product-details">
                            <div class="product-title"><a href="{{ $item['url'] }}">{{ $item['productName'] }}<br>{{ $item['name'] }}</a>
                                <span>{{ $item['code'] }}</span>
                                <span>
<svg xmlns="http://www.w3.org/2000/svg" width="13.414" height="13.414" viewBox="0 0 13.414 13.414">
<path id="Path_1639" data-name="Path 1639" d="M988.767,636.211a6.707,6.707,0,1,0,6.707,6.707A6.717,6.717,0,0,0,988.767,636.211Zm0,1.341a5.356,5.356,0,0,1,5.366,5.346v.02a5.356,5.356,0,0,1-5.346,5.366h-.02a5.356,5.356,0,0,1-5.366-5.346v-.02a5.356,5.356,0,0,1,5.346-5.366Zm0,1.118a.67.67,0,0,0-.67.671v3.577a.671.671,0,0,0,.335.58l2.71,1.565a.67.67,0,0,0,.671-1.16l-2.375-1.37v-3.191a.67.67,0,0,0-.67-.67Z" transform="translate(-982.06 -636.211)" fill="#0c9aff"></path>
</svg> {{ \BasketService::getShippingDayAlert() }}
</span>
                            </div>
                            @if( isset($showDropshipping) && $showDropshipping /*&& userHasDropshipping()*/)
                                <hr>
                                <p style="font-size: 10px; color: darkred">Dropshipping Yapacaksanız Aşağıdaki bilgileri Doldurunuz</p>
                                <div id="product-dropshipping" class="product-dropshipping">
                                    <table>
                                        <tr><td>Pazaryeri</td>
                                            <td>
                                                <select class="form-control" name="basketitem[{{ $item['code'] }}][marketplaceId]">
                                                    <option value=""> --- </option>
                                                    <option value="1"@if($item['marketplaceId']=='1') {{ 'selected' }} @endif>N11</option>
                                                    <option value="2" @if($item['marketplaceId']=='2') {{ 'selected' }} @endif>Trendyol</option>
                                                    <option value="3" @if($item['marketplaceId']=='3') {{ 'selected' }} @endif>Hepsi Burada</option>
                                                    <option value="4" @if($item['marketplaceId']=='4') {{ 'selected' }} @endif>Amazon.com.tr</option>
                                                    <option value="5" @if($item['marketplaceId']=='5') {{ 'selected' }} @endif>Çiçeksepeti</option>
                                                    <option value="6" @if($item['marketplaceId']=='6') {{ 'selected' }} @endif>E-PTT AVM</option>
                                                </select>
                                            </td>
                                        </tr>
                                        <tr><td>Sipariş No</td><td><input type="text" class="form-control" name="basketitem[{{ $item['code'] }}][marketplaceOrderCode]" value="{{ $item['marketplaceOrderCode'] }}"></td></tr>
                                        <tr><td>Kargo Kodu</td><td><input type="text" class="form-control" name="basketitem[{{ $item['code'] }}][shippingTrackingNumber]" value="{{ $item['shippingTrackingNumber'] }}"></td></tr>
                                    </table>
                                </div>
                            @endif
                        </div>
                        <div class="product-quantity">
                            <button type="button" class="value-button decrease" data-decrease="">-</button>
                            <input class="decrease-increase item-{{ $item['itemCode'] }}" name="basketitem[{{ $item['itemCode'] }}][quantity]" data-value data-product_id="{{ $item['productId'] }}" data-color_id="{{ $item['colorId'] }}" type="text" value="{{ $item['quantity'] }}">
                            <button type="button" class="value-button increase" data-increase="">+</button>
                        </div>
                        <div class="product-line-price">
                            <span class="product-current-price">{{ $item['formatted_total'] }}</span>
                            @if($item['alert'])
                            <span class="basket-message {{ $item['alert']['class'] }}">{{ $item['alert']['message'] }}</span>
                            @endif
                        </div>
                    </div>
                @endforeach
            @else
                Sepetiniz Boş
            @endif
        </div>
        <div class="return-shopping">
            <a href="{{ route('home') }}" class="return-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="5.001" height="8.774" viewBox="0 0 5.001 8.774">
                    <g id="flaticon1568189262-svg" transform="translate(102.14 8.773) rotate(180)">
                        <path id="Path_1398" data-name="Path 1398" d="M101.96,4.821,98.187,8.593a.614.614,0,0,1-.869-.869l3.338-3.338L97.319,1.049A.614.614,0,0,1,98.187.18l3.773,3.772a.614.614,0,0,1,0,.869Z" transform="translate(0 0)" fill="#7b7b7b"></path>
                    </g>
                </svg>
                Alışverişe Devam Et
            </a>
        </div>
    </div>
    @include('basket.totals')
</div>
<script>

</script>

