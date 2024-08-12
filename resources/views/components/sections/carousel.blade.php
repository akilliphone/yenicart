@if(isset($content[$sectionId]) && $content[$sectionId])
    <section class="section-8 section-padding">
        <div class="container">
            <div class="section-title section-padding">{{ $title }}<a class="link" href="{{ route('product.search', $oldslug) }}">Tümünü Gör</a></div>
            <div id="{{ $sectionId }}" class="product-asyn-slider owl-carousel {{ $sectionId }} owl-theme">
                @foreach($content[$sectionId]['items'] as $item)
                    <x-product.item :product="$item" />
                @endforeach
            </div>
        </div>
    </section>
@endif
