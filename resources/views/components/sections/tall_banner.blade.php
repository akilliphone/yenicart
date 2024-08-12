@if(isset($content['tall_banner']) && $content['tall_banner'])
    <section class="banner-area section-padding" id="banner-area">
        @foreach($content['tall_banner']->items as $item)
            @if($item['orderNumber']==$orderNumber)
                <div class="container">
                    <a href="{{$item['slug']}}">
                        <img class="lazyload fluid-img" data-src="{{ $item['desktopImage'] }}"
                             data-srcset="{{ $item['desktopImage'] }} 800w, {{ $item['mobileImage'] }} 320w"
                             sizes="(min-width: 768px) 400px,160px" width="1110" height="120" alt="Slider Resmi">
                    </a>
                </div>
            @endif
        @endforeach
    </section>
@endif
