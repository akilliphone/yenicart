<div  id="app-header">
    <div class="header-top">
        <div class="container">
            <div class="header-top-info">
                <ul class="left-section">
                    <li><h1><a href="/">Akıllıphone</a></h1></li>
                    <li><a href="{{ route('page', ['pageSlug'=>'iletisim']) }}">İletişim</a></li>
                    <li><a href="{{ route('page', ['pageSlug'=>'hakkimizda']) }}">Hakkımızda</a></li>
                    <li><a href="{{ route('page', ['pageSlug'=>'garanti-iade']) }}">Garanti ve İade Şartları</a></li>
                    <li><a href="{{ route('page', ['pageSlug'=>'dropshipping']) }}">Dropshipping</a></li>
                </ul>
                <ul class=" right-section">
                    <li><a href="callto:+908505200880">0850 520 08 80</a></li>

                </ul>
            </div>
        </div>
    </div>
    <header class="desktop-header" style="background-color: white">
            <div class="container">
                <div class="navbar">
                    <a href="{{ url('/') }}" class="brand-logo">
                        <img width="186" height="52" src="https://www.akilliphone.com/views/kuteshop/assets/images/logo/logo.svg?v=2.7" alt="">
                    </a>
                    <form method="GET" action="{{ route('product.search') }}" class="search-bar" style="position: relative">
                        <input class="search-input" type="search" vaplaceholder="Ürün, kategori veya ürün kodu bilgisi girin" id="searchText" name="text" onkeydown="searchInputKeyPress(event)" value="{{ $text }}" required />
                        <button type="submit" class="search-icon searchText" id="searchTextButton"><img width="49" height="49" src="{{ url('assets/images/search-icon.svg') }}" alt=""></button>
                        <input type="hidden" name="category" value="{{ isset($searchCategory)?$searchCategory:'' }}">
                        <div class="search-results"></div>
                    </form>
                    <div class="right-section">
                        @if(isset(session('userInfo')['favorite']))
                            <a href="#" class="favorites">
                                <img width="28" height="25" src="{{ url('assets/images/favorite.svg') }}" alt="">
                                <span class="counter">{{count($_SESSION['userInfo']['favorite'])}}</span>
                            </a>
                        @endif
                        <a href="{{ route('basket.index') }}" class="shopping-cart mini">
                            <img width="26" height="25" src="{{ url('assets/images/shopping-icon.svg') }}" alt="">
                            <span class="counter">{{ BasketService::getItemCount() }}</span>
                        </a>
                            @if(isset($header['member']) && $header['member'] )
                                <div class="login-btn">
                                    {{ $header['member']->name }} {{ $header['member']->surName }}
                                    <div class="dropdown-box">
                                        <a class="login-link" href="{{ route('profile.orders') }}">Profilim</a>
                                        <a class="login-link confirm" href="{{ route('logout') }}">Çıkış Yap</a>                                    </div>
                                </div>
                            @else
                                <div class="login-btn">
                                    Giriş Yapınız
                                    <div class="dropdown-box">
                                        <a class="login-link" href="{{ route('login') }}">Üye Girişi</a>
                                        <a class="login-link" href="{{ route('bayi.login') }}">Bayi Girişi</a>
                                    </div>

                                </div>

                            @endif
                    </div>
                </div>
            </div>
        </header>
    <header class="mobile-header">
        <div class="container">
            <nav class="navbar">
                <div class="navbar-top">
                    <div class="brand-logo">
                        <a class="navbar-brand">
                            <a href="/"><img src="{{ url('assets/images/logo.svg') }}" alt="Akıllıphone logo"></a>
                        </a>
                    </div>
                </div>
                <div class="navbar-bottom">
                    <form method="GET" action="{{ route('product.search') }}" class="search-bar">
                        <button class="fix-input">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14.207" height="12.46" viewBox="0 0 14.207 12.46">
                                <g id="Group" transform="translate(0.207 -0.27)">
                                    <path id="Line" d="M0,1H12" transform="translate(1.5 5.5)" fill="none" stroke="#788995" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1"/>
                                    <path id="Line-2" data-name="Line" d="M.5,6.5,6.023.977" fill="none" stroke="#788995" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1"/>
                                    <path id="Line-3" data-name="Line" d="M.5-6.5,6.023-.977" transform="translate(0 13)" fill="none" stroke="#788995" stroke-linecap="square" stroke-miterlimit="10" stroke-width="1"/>
                                </g>
                            </svg>
                        </button>
                        <input name="text" class="search-input" type="search" placeholder="Ürün, kategori veya ürün kodu bilgisi girin" id="searchInputMobile" onkeydown="handleKeyPressMobil(event)" value="{{ $text }}" style="border: none; width: 100%" />
                        <input type="hidden" name="category" value="{{ isset($searchCategory)?$searchCategory:'' }}">
                        <button class="search-icon searchText" id="searchTextButtonMobil"><img width="49" height="49" src="{{ url('assets/images/search-icon.svg') }}" alt="" style="margin-top: 7px"></button>
                        <div class="search-results"></div>
                    </form>


                </div>
            </nav>
        </div>
    </header>
    @include('layouts.mega_menu')
</div>
