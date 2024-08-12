@extends('layouts.default')
@section('body_class') search loading @endsection
@section('head')
    <title>Akilliphone - Online Store</title>
    <link rel="stylesheet" href="{{ url('assets/css/product-filter.css') }}?_v={{ env('ASSETS_VER') }}">
    <style>
        .product-item.instok-false{
            opacity: 0.20!important;
        }
        .title .search-text{
            color: #1a9afc;
        }
        .product-item .product-info .product-price{
            display: block;
        }
        .product-listing .product-price span{
            font-size: 18px;
        }
        .product-listing .discount {
            /* float: right; */
            /* top: 0px; */
            position: absolute;
            right: 5px;
            /* top: 5px; */
        }
        #scroll-loader{
            height: 30px;
            text-align: center;
            width: 100%;
        }
        .product-color {
            width: 12px;
            height: 12px;
            position: absolute;
            top: 6px;
            right: 6px;
            border: 1px solid #cdcdcd;
            opacity: 0.80;
            border-radius: 50%;
        }
        .category-filter.selected{
            color: #1a9afc!important;
        }
    </style>
@endsection

@section('content')
    <section class="filter-section section-padding product-listing">
        <div class="container" id="container" >
            @if($selectedCategory)
                <h3 class="title" >"{{ $selectedCategory->categoryName }}" İçinde <span class="search-text">{{ $text }}</span> Aranıyor</h3>
            @else
                <h3 class="title" >"Tüm Kategoriler" İçinde <span class="search-text">{{ $text }}</span> Aranıyor</h3>
            @endif
            <input type="hidden" name="text" value="{{ $text }}" class="text forfilter">
            <input type="hidden" name="custom" value="{{ $custom }}" class="custom forfilter">
            <div class="breadcrumb">
                <nav>
                    <ul>
                        <li><a href="/"><img src="{{ url('assets/images/home-icon.svg') }}"></a></li>
                        <li><a href="{{ url('reyonlar') }}">Tüm Ürünler</a></li>
                        <li  v-for="(item, index) in bread_cramps" :key="index" v-html="item"></li>

                    </ul>
                </nav>
            </div>
            <div id="search-content" class="row">
                <aside id="sidenav" class="left">
                    <span id="close"><svg width="20" height="20" viewBox="0 0 512 512"><path fill="currentColor" d="M256 48C141.31 48 48 141.31 48 256s93.31 208 208 208s208-93.31 208-208S370.69 48 256 48Zm86.63 272L320 342.63l-64-64l-64 64L169.37 320l64-64l-64-64L192 169.37l64 64l64-64L342.63 192l-64 64Z"/></svg></span>

                    @if($selectedCategory)
                        <input type="checkbox" class="forfilter category" value="{{ $selectedCategory->filter }}" checked style="display: none">
                    @else
                        <input type="checkbox" class="forfilter category" value="0" checked style="display: none">
                    @endif
                    @if(($selectedCategory && $selectedCategory->children) || empty($idCategory))
                        <div class="filtermenu-box">
                            <div class="title">Kategoriler</div>
                            <div class="content">
                                <a class="category-filter" data-keep="category" :data-filter="item.filter" :href="item.url" v-for="(item, index) in category.children" :key="index" >@{{ item.categoryName }}</a>
                            </div>
                        </div>
                    @endif
                    <div class="filtermenu-box">
                        <div class="title">Markalar</div>
                        <div class="content">
                            <input class="search" type="text" placeholder="Marka Ara"  id="aramaKutusu" onkeyup="aramaYap()">
                            <div class="brand-box">

                                <ul id="markalar">
                                    <li v-for="(item, index) in providers" :key="index">
                                        <label :for="'provider-'+item.id">
                                            <input data-keep="provider" type="checkbox" class="option-input forfilter provider" :id="'provider-'+item.id" :value="item.id" >
                                            @{{item.providerName}}
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="filtermenu-box">
                        <div class="title">fiyat aralığı</div>
                        <div class="content">
                            <div class="price-search">
                                <div class="search-inputs">
                                    <input data-keep="all" id="priceMin" type="text" placeholder="En Az">
                                    <span>-</span>
                                    <input data-keep="all" id="priceMax" type="text"  placeholder="En Çok">
                                </div>
                                <button class="price-search-btn" type="button" style="cursor: pointer">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 49 49"><g transform="translate(-1176 -58)"><rect width="49" height="49" rx="24.5" transform="translate(1176 58)" fill="#1a9afc"/><path d="M23.96.806a6.006,6.006,0,0,0-2.2,8.2,6,6,0,0,0,7.189,2.664l2.7,4.679,1.926-1.112-2.7-4.679A6.007,6.007,0,0,0,32.165,3a6,6,0,0,0-8.2-2.2Zm6.278,3.31a3.783,3.783,0,0,1-3.27,5.673A3.8,3.8,0,0,1,23.689,7.9a3.783,3.783,0,0,1,3.27-5.673A3.8,3.8,0,0,1,30.238,4.116Z" transform="translate(1173.233 74.323)" fill="#fff"/></g></svg>
                                </button>
                            </div>

                        </div>

                        <label for="price-0" class="prices">
                            <input type="radio" class="option-input forfilter price" id="price-0" data-min="0" data-max="50"  name="price" value="0-50" data-keep="all">
                            0 - 50 TL
                        </label>
                        <label for="price-50" class="prices">
                            <input type="radio" class="option-input forfilter price" id="price-50" data-min="50" data-max="100"  name="price" value="25-100" data-keep="all">
                            50 - 100 TL
                        </label>
                        <label for="price-100" class="prices">
                            <input type="radio" class="option-input forfilter price" id="price-100" data-min="100" data-max="1000"  name="price" value="100-1000" data-keep="all">
                            100 - 1.000 TL
                        </label>
                        <label for="price-1000" class="prices">
                            <input type="radio" class="option-input forfilter price" id="price-1000" data-min="1000" data-max="10000"  name="price" value="1000-10000" data-keep="all">
                            1.000 - 10.000 TL
                        </label>
                    </div>
                    <div class="filtermenu-box">
                        <div class="title">Renkler</div>
                        <div class="content">
                            <div class="color-box">
                                <ul id="colors">
                                    <li v-for="(item, index) in colors" :key="index">
                                        <label :for="'color-'+item.key" :class="'colors  color-'+item.key">
                                            <input data-keep="color" type="checkbox" class="option-input forfilter color" :id="'color-'+item.key"  :value="item.value" :style="'background-color:' + (item.description?item.description:item.style)">
                                            @{{ item.name }}
                                        </label>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </aside>
                <div class="right">
                    <div class="filter-buttons">
                        <div id="listbox" class="list">
                            <svg width="20" height="20" viewBox="0 0 32 32"><path fill="currentColor" d="m16 28l-7-7l1.41-1.41L16 25.17l5.59-5.58L23 21l-7 7zm0-24l7 7l-1.41 1.41L16 6.83l-5.59 5.58L9 11l7-7z"/></svg>
                            Sırala
                        </div>
                        <div id="burgermenu" class="side-btn">
                            <svg width="20" height="20" viewBox="0 0 24 24"><path fill="currentColor" d="M11 20q-.425 0-.712-.288Q10 19.425 10 19v-6L4.2 5.6q-.375-.5-.112-1.05Q4.35 4 5 4h14q.65 0 .913.55q.262.55-.113 1.05L14 13v6q0 .425-.287.712Q13.425 20 13 20Z"/></svg>
                            Filtrele
                        </div>
                    </div>

                    <div id="tab-btns" class="tab-section">
                        <div class="tab block">
                            <label class="tabSpec">
                                <input name="orderby" type="radio" class="option-input forfilter orderBy" value="saleCount" data-dir="desc">
                                Çok satanlar
                            </label>
                            <label class="tabSpec active">
                                <input name="orderby" type="radio" class="option-input forfilter orderBy" value="idProduct" data-dir="desc" checked>
                                En yeniler
                            </label>
                            <label class="tabSpec">
                                <input name="orderby" type="radio" class="option-input forfilter orderBy" value="salePrice" data-dir="asc">
                                En düşük fiyat
                            </label>
                            <label class="tabSpec">
                                <input name="orderby" type="radio" class="option-input forfilter orderBy" value="salePrice" data-dir="desc">
                                En yüksek fiyat
                            </label>
                        </div>
                        <div class="tab-right">
                            <input id="productNameAsc" name="orderby" type="radio" class="option-input forfilter orderBy" value="productName" data-dir="asc" style="display: none">
                            <input id="productNameDesc" name="orderby" type="radio" class="option-input forfilter orderBy" value="productName" data-dir="desc" style="display: none">
                            <input id="visitCount" name="orderby" type="radio" class="option-input forfilter orderBy" value="visitCount" data-dir="desc" style="display: none">
                            <select name="more"  id="siralama"  class="option-input forfilter orderBy">
                                <option value="" disabled selected>Diğer</option>
                                <option value="productNameAsc" >Ada Göre Sıralama (A-Z) </option>
                                <option value="productNameDesc" > Ada Göre Sıralama (Z-A)</option>
                                <option value="visitCount" >Çok Değerlendirilenler</option>
                            </select>
                            <!-- <div class="view-buttons">
                              <button class="list-btn"><img src="assets/images/list.svg" alt=""></button>
                              <button class="grid-btn"><img src="assets/images/grid.svg" alt=""></button>
                            </div> -->
                        </div>
                    </div>
                    <div class="tab-content">
                        <div class="tabDetails" style="display:block;" >
                            <div class="product-items jscroll" id="jscroll">
                                <div class="product-wrapper ">
                                    <template v-for="item in items" >
                                        <div :class="'product-item instok-' + (item.varyantAmount>0 ) ">
                                            <a :href="item.url+'.'+item.idColor" target="_blank">
                                                <div class="product-image">
                                                    <img class="lazyload" width="160" height="160" :src="item.thumb" alt="Ürün Resmi">
                                                </div>
                                                <div class="product-info">
                                                    <div class="product-name">
                                                        <span v-text="item.productName"></span>
                                                    </div>
                                                    <div class="product-price">
                                                            <span v-text="item.formatted_sale_price"></span>
                                                            <template v-if="item.discounted">
                                                                <span class="discount" v-text="'% ' + item.discountRate"></span>
                                                            </template>
                                                    </div>
                                                    <template v-if="item.discounted">
                                                        <div class="product-old-price" v-text="item.formatted_old_price"></div>
                                                    </template>

                                                    {{--                                                    <div class="product-price" v-text="item.formatted_sale_price"></div>--}}
{{--                                                    <template v-if="item.discounted">--}}
{{--                                                        <div class="product-old-price" v-text="item.formatted_old_price"></div>--}}
{{--                                                    </template>--}}
                                                </div>
                                                <div class="product-color" :style="'background-color:' + item.color.style" :title="item.color.name"></div>
                                            </a>
                                        </div>
                                    </template>

                                </div>
                                {{--                                <div class="next jscroll-next-parent" style="display: none;"><a id="jscroll-next" class="jscroll-next" href="https://api.duzzona.site/products">Sonraki</a></div>--}}
                                <div id="list-result"></div>
                                <div id="scroll-loader"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="scroll-to-top" onclick="scrollToTop()">&#8593;</div>
    </section>
@endsection
@section('js')

    <script>
        const vueSearch = new Vue({
            el: '#app-content',
            data: {
                items: [],
                category: [{children:[]}],
                providers: [],
                colors: [],
                bread_cramps: '',
                siteurl: '{{ route('product.search') }}',
                apiurl: '{{ route('product.list') }}',
                lasturl: '',
                offset:0,
                limit:25,
                onload:false,
            },
            mounted() {
                const params = 'category={{ $selectedFilter }}&provider={{ $provider }}&text={{$text}}&orderby={{$selectedOrderby}}&dir={{$selectedDir}}&custom={{$custom}}';
                this.loadSearchItems(params, false, true, true, true);
            },
            methods: {
                loadSearchItems(params, replacehistory, reprovider, recolor, recategory) {
                    if(this.onload==true){
                        return ;
                    }
                    $('#scroll-loader').html('Yeni sayfa yükleniyor Lütfen Bekleyiniz...');
                    params += '&variyantasproduct=1&offset=' + this.offset + '&p=' + ((this.offset/this.limit)+1);
                    this.onload = true;
                    const url = this.apiurl + '?'+params;
                    this.lasturl = this.siteurl + '?'+params ;
                    if(this.offset==0)  this.items = [];
                    fetch(url, { headers:Help.getHeaders()})
                        .then(response => response.json())
                        .then(response => {
                            try {
                                $('#scroll-loader').html('Seçiminize Uygun olan Tüm Ürünler Listelendi');
                                this.onload = false;
                                if(response.data){
                                    if(response.data.count){
                                        this.offset = this.offset + this.limit;
                                        this.items = this.items.concat(response.data.items) ;
                                    }
                                    if(response.data.category){
                                        if(recategory){
                                            this.category = response.data.category;
                                        }
                                        this.bread_cramps = response.data.category.bread_cramps;
                                    }
                                    if(response.data.filter){
                                        if(reprovider){
                                            if(response.data.filter.providers){
                                                this.providers = response.data.filter.providers;
                                            }
                                        }
                                        if(recolor){
                                            if(response.data.filter.colors){
                                                this.colors = response.data.filter.colors;
                                            }
                                        }
                                    }
                                }
                                if(replacehistory){
                                    window.history.pushState(null, 'Title',  this.lasturl);
                                }
                            } catch(error) {
                                console.error('Hata oluştu:', error); // Hatanın ne olduğunu konsola yazdır
                            }
                            document.body.classList.remove('loading');
                        })
                        .catch(error => {
                            document.body.classList.remove('loading');
                            console.error('API Hatası:', error);
                        });
                }
            }
        });
        function reLoadSearchItems(host){
            let filter = Help.createFilter();
            let reprovider=true;
            let recolor = true;
            //let recategory = false;
            if(host.data('keep')=='provider') reprovider = false;
            if(host.data('keep')=='color') recolor = false;
            //if(host.data('keep')=='category') recategory = false;
            if(host.data('keep')=='all'){
                reprovider = false;
                recolor = false;
            }
            vueSearch.loadSearchItems(filter, true, false, false, false)
        }
        $('body').on('click', '.forfilter.price', function () {
            $('#priceMin').val($(this).data('min'));
            $('#priceMax').val($(this).data('max'));
        });
        $('body').on('click', '.category-filter', function (e) {
            e.preventDefault();
            $('.category-filter').removeClass('selected')
            $(this).addClass('selected')
            $('.category.forfilter').val($(this).data('filter'));
            vueSearch.offset=0;
            reLoadSearchItems($(this));
            return false;
        });
        $('body').on('change', '.forfilter' , function () {
            vueSearch.offset=0;
            reLoadSearchItems($(this));
        })
        $('.price-search-btn').on('click', function () {
            vueSearch.offset=0;
            reLoadSearchItems($(this));
            $('input[name=price]').prop('checked', false);
        })
        $('#tab-btns .tabSpec').on('click', function () {
            $('#siralama').val('');
            $('#tab-btns .tabSpec').removeClass('active');
            $(this).addClass('active');
        })
        $('#siralama').on('change', function () {
            if( $('#'+$(this).val()).length ){
                $('#'+$(this).val()).prop('checked', true);
                $('#tab-btns .tabSpec').removeClass('active');
            }
        });
    </script>
    <script>
        const listbox = document.getElementById("listbox");
        const tab = document.getElementById("tab-btns")
        listbox.addEventListener("click", function () {
            tab.classList.toggle("block");
        });
    </script>
    <script>
        const sideNav = document.getElementById("sidenav");
        const filterMenu = document.getElementById("burgermenu");
        const close = document.getElementById("close");
        filterMenu.addEventListener("click", function () {
            sideNav.classList.toggle("opened");
        });
        close.addEventListener("click", function () {
            sideNav.classList.toggle("opened");
        });
    </script>
    <script>
        function requireScrollLoading() {

            var windowTop = $(window).scrollTop();
            var windowBottom = windowTop + $(window).height();
            var divTop = $('#scroll-loader').offset().top;
            var divBottom = divTop + $('#scroll-loader').height();

            return ((divBottom <= windowBottom) && (divTop >= windowTop));

        }
        $(window).scroll(function() {
            if (requireScrollLoading()) {
                reLoadSearchItems($(this));
            } else {
                console.log('The div is not visible on the screen.');
            }
        });

    </script>
    <script>
        function aramaYap() {
            var aranan = document.getElementById("aramaKutusu").value.toLowerCase();
            var liste = document.getElementById("markalar");
            var elemanlar = liste.getElementsByTagName("li");

            for (var i = 0; i < elemanlar.length; i++) {
                var eleman = elemanlar[i];
                var elemanMetni = eleman.innerText.toLowerCase();

                if (elemanMetni.indexOf(aranan) > -1) {
                    eleman.style.display = "";
                } else {
                    eleman.style.display = "none";
                }
            }
        }
    </script>
@endsection
