
<section class="section-8 section-padding">
    <div class="container">


        <div class="section-title section-padding">{{ $title }}<a class="link" href="{{ route('product.search', $oldslug) }}">Tümünü Gör</a></div>
        <div id="{{ $sectionId }}" class="product-asyn-slider owl-carousel {{ $sectionId }} owl-theme">
            <div class="product-item" v-for="item in {{ $sectionId }}.items">
                <a :href="item.url">
                    <div class="product-image">
                        <img class="lazyload" style="height:160px;width: 160px;" :alt="item.productName" :src="item.thumb">
                    </div>
                    <div class="product-info">
                        <div class="product-name">@{{ item.productName }}</div>

                        <div class="product-price">
                            <span>@{{ Help.formatPrice(item.sale_price) }}</span>
                            <template v-if="item.discounted">
                                <span class="discount"> % @{{ item.discountRate }} </span>
                            </template>
                        </div>
                        <template v-if="item.discounted">
                            <div class="product-old-price"> @{{ Help.formatPrice(item.old_price) }}</div>
                        </template>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>
