@if(isset($content['main_slider']) && $content['main_slider'])
    <div id="main_slider" class="section-padding-main">
        <section class="section-padding mx-24" style="overflow:hidden">
            <div class="home-slider owl-carousel owl-theme owl-loaded">
                <div class="owl-stage-outer">
                    <div class="owl-stage">

                                        @foreach($content['main_slider']->items as $item )
                                            <div class="owl-item slider-wrapper "   style="backgroundColor: {{ $item['bgColor'] }}" >
                                                <div class="container">
                                                    <div class="content">
                                                        <div class="product-name">{{ $item['title'] }}</div>
                                                        <a class="product-link" href="{{ $item['slug'] }}">Acele et kaçırma</a>
                                                    </div>
                                                    <div class="product-img">
                                                        <img class="fluid-img" width="1110" height="390" rc="{{ $item['desktopImage'] }}"
                                                             srcset="{{ $item['desktopImage'] }} 800w, {{ $item['mobileImage'] }} 320w"
                                                             sizes="(min-width: 768px) 400px,160px"  alt="Slider Image">
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                </div>
                            </div>
                        </div>

            {{--            <div class="home-slider owl-carousel owl-theme">--}}
{{--                @foreach($content['main_slider']->items as $item )--}}
{{--                    <div class="slider-wrapper "   style="backgroundColor: {{ $item['bgColor'] }}" >--}}
{{--                        <div class="container">--}}
{{--                            <div class="content">--}}
{{--                                <div class="product-name">{{ $item['title'] }}</div>--}}
{{--                                <a class="product-link" href="{{ $item['slug'] }}">Acele et kaçırma</a>--}}
{{--                            </div>--}}
{{--                            <div class="product-img">--}}
{{--                                <img class="fluid-img" width="1110" height="390" rc="{{ $item['desktopImage'] }}"--}}
{{--                                     srcset="{{ $item['desktopImage'] }} 800w, {{ $item['mobileImage'] }} 320w"--}}
{{--                                     sizes="(min-width: 768px) 400px,160px"  alt="Slider Image">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                @endforeach--}}
{{--                    <div class="owl-nav">--}}
{{--                        <div class="owl-prev">prev</div>--}}
{{--                        <div class="owl-next">next</div>--}}
{{--                    </div>--}}
{{--            </div>--}}
        </section>
    </div>
@endif
