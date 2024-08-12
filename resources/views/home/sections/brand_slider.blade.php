@if(isset($content['home_providers']) && $content['home_providers'])
    <section class="section-9 section-padding mx-24">
        <div class="container">
            <div class="section-title section-padding px-24">
                Favori Markaların
                <a class="link" href="#">Tümünü Gör</a>
            </div>


            <div class="favorite-brands">
                <div class="section-title section-padding">
                    Favori Markaların
                    <a class="link" href="/reyonlar">Tüm Markalar</a>
                </div>
                <div class="brand-slider swiper">
                    <div class="swiper-wrapper">
                        @foreach ($content['home_providers']->items as $item)
                            <div class="swiper-slide">
                                <a href="{{ $item['slug'] }}" class="brand-logo">
                                    <img class="lazyload fluid-img" data-src="{{ $item['desktopImage'] }}" alt="{{ $item['title'] }}">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif
