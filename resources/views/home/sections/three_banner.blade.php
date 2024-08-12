@if(isset($content['three_banner']) && $content['three_banner'])
    <div class="three-category-block">
        @foreach($content['three_banner']->items as $item)
            <div class="three-category-block-item">
                <a href="{{ $item['slug'] }}">
                    <img class="lazyload fluid-img" src="{{ $item['desktopImage'] }}" alt="Banner Image">
                </a>
            </div>
        @endforeach
    </div>
@endif


