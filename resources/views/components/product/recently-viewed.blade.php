<section class="recently-viewed section-padding">
    <div class="container">
        <div class="section-title section-padding">
            Son İnceledikleriniz
        </div>
        <div class="product-slider owl-carousel owl-theme">
            @if(\BasketService::getLastVieweds())
                @foreach(\BasketService::getLastVieweds() as $item)
                    <x-product.item :product="$item" />
                @endforeach
            @endif
        </div>
    </div>
</section>
