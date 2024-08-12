<section class="banner-area section-padding" id="banner-area" v-for="(item, index) in tall_banner.items" :key="index">
    <div class="container" v-if="item.orderNumber=={{ $orderNumber }}">
        <a :href="item.slug">
            <img class="lazyload fluid-img" :src="item.desktopImage"
                 width="1110" height="120" alt="Banner Image">
        </a>
    </div>
</section>

