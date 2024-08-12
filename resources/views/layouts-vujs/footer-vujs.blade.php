<div id="app-footer">
    <footer class="desktop-footer" >
        <div class="container">
            <div class="footer-top">
                <div class="logo">
                    <img src="{{ url('assets/images/logo.svg') }}" alt="Akıllıphone Logo">
                </div>
                <div class="bulletin">
                    <div class="bulletin-left">
                        <div class="text-top">Fırsatları Kaçırmayın</div>
                        <div class="text-bottom">Tüm kampanya ve fırsatlarımız e-posta kutunuza gelsin</div>
                    </div>
                    <div class="bulletin-right">
                        <form action="{{ route('member.add-newsletter') }}" method="POST" class="ajaxForm">
                            <input name="email" required placeholder="E-posta Adresiniz" type="text">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <button type="submit">Kayıt Ol</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer-review">
                <div class="footer-review-left">
                    <a href="https://www.google.com/search?q=ak%C4%B1ll%C4%B1phone#lrd=0x14caa0ac44eb2abf:0xe323fdf29fc0136e,1,,," target="_blank">
                        <img src="{{ url('assets/images/comment.svg') }}" alt="">
                    </a>
                </div>

                <div class="footer-review-right">
                    <div>
                        <div class="category-title">ETBİS</div>
                        <div>Kaydımızı sorgulayabilirsiniz</div>
                    </div>
                    <div>
                        <a href="https://www.eticaret.gov.tr/siteprofil/6055208760302322/wwwakilliphonecom" target="_blank">
                            <img width="91" height="105" src="{{ url('assets/images/qr.jpeg') }}" alt="">
                        </a>
                    </div>
                </div>
            </div>
            <div class="footer-body">
                <div class="col">
                    <div class="footer-category">
                        <div class="category-title">Kurumsal</div>
                        <ul>
                            <li><a href="{{url('/sayfa/i/hakkimizda')}}">Hakkımızda</a></li>
                            {{--                        <li><a href="">Bizden Haberler</a></li>--}}
                            <li><a href="{{url('/sayfa/i/iletisim')}}">İletişim</a></li>
                            {{--                        <li><a href="#">İşlem Rehberi</a></li>--}}
                            {{--                        <li><a href="#">Hesabım</a></li>--}}
                            {{--                        <li><a href="#">Yardım</a></li>--}}
                            {{--                        <li><a href="#">Mobil Uygulamalar</a></li>--}}
                            <li><a href="{{url('/sayfa/i/bilgi-toplumu-hizmetleri')}}">Bilgi Toplumu Hizmetleri</a></li>
                            <li><a href="{{url('/sayfa/i/gizlilik-politikasi')}}">Gizlilik Politikası</a></li>
                            <li><a href="{{url('/sayfa/i/iade-ve-degisim')}}">İade ve Değişim</a></li>
                            <li><a href="{{url('/sayfa/i/islem-rehberi')}}">İşlem Rehberi</a></li>
                            <li><a href="{{url('/sayfa/i/mesafeli-satis-sozlesmesi')}}">Mesafeli Satış Sözleşmesi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="footer-category">
                        <div class="category-title">Kategoriler</div>
                        <ul>
                            <li> <a href="{{url('/reyonlar/ev-yasam-327')}}">Ev Yaşam</a></li>
                            <li> <a href="{{url('/reyonlar/bluetooth-kulaklik-256')}}">Bluetooth Kulaklık</a></li>
                            <li> <a href="{{url('/reyonlar/speaker-hoparlor-ses-bombasi-257')}}">Ses Bombası</a></li>
                            <li> <a href="{{url('/reyonlar/telefon-kiliflari-156')}}">Telefon Kılıfları</a></li>
                            <li> <a href="{{url('/reyonlar/usb-type-c-kablo-255')}}">Type C Kablo</a></li>
                            <li> <a href="{{url('/reyonlar/arac-ici-telefon-tutucu-213')}}">Araç Telefon Tutucu </a></li>
                            <li> <a href="{{url('/reyonlar/tablet-kiliflari-221')}}">Tablet Kılıfı</a></li>
                            <li> <a href="{{url('/reyonlar/kablosuz-sarj-aletleri-270')}}">Kablosuz Şarj Aletleri</a></li>
                            <li> <a href="{{url('/reyonlar/tamir-setleri-192')}}">Telefon Tamir Seti</a></li>
                            <li> <a href="{{url('/reyonlar/oyun-aksesuarlari-321')}}">Oyun Aksesuarları</a></li>
                            <li> <a href="{{url('/reyonlar/kisisel-bakim-337')}}">Kişisel Bakım</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col">
                    <div class="footer-category">
                        <div class="category-title">Markalar</div>
                        <ul>
                            <li v-for="(item, index) in providers.items" :key="index">
                                <a href="{{url('/reyonlar?brand=2217')}}" >@{{ item.providerName }}</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col text-center">
                    <div class="follow-us">
                        <div class="category-title">Bizi Takip Edin!</div>
                        <ul class="links">
                            <li>
                                <a target="_blank" href="https://www.facebook.com/Akilliphonecom">
                                    <img src="{{ url('assets/images/facebook.svg') }}" alt="facebook">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://twitter.com/Akilliphone">
                                    <img src="{{ url('assets/images/twitter.svg') }}" alt="twitter">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.instagram.com/akilliphone/">
                                    <img src="{{ url('assets/images/instagram.svg') }}" alt="instagram">
                                </a>
                            </li>
                            <li>
                                <a target="_blank" href="https://www.youtube.com/channel/UC3M8SQ0DC86E_ugG2XPxDWg">
                                    <img src="{{ url('assets/images/youtube.svg') }}" alt="youtube">
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="mobile-app">
                        <div class="category-title">Mobil Uygulamamız</div>
                        <a href="https://apps.apple.com/tr/app/ak%C4%B1ll%C4%B1phone/id1483837361?l=tr" target="_blank">
                            <img src="{{ url('assets/images/apple.png') }}" alt="">
                        </a>
                        <a href="https://play.google.com/store/apps/details?id=com.akilliphone" target="_blank">
                            <img src="{{ url('assets/images/google.png') }}" alt="">
                        </a>
                        <a href="https://appgallery.huawei.com/#/app/C103658585" target="_blank">
                            <img src="{{ url('assets/images/appgallery.png') }}" alt="">
                        </a>
                    </div>
                    <div class="have-question">
                        <div class="category-title">
                            Aklınıza takılan bir soru mu var?
                        </div>
                        <div class="call-us" >Çözüm Merkezimizi arayın</div>
                        <a href="tel:08505200880">0850 520 0880</a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <div class="left">
                    <img class="lazyload" data-src="assets/images/norton.svg">
                </div>
                <div class="right">
                    <img class="lazyload" src="{{ url('assets/images/isbankasi.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/denizbank.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/ziraat.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/bonus.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/maximum.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/axess.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/yapikredi.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/paraf.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/garanti.svg') }}">
                    <img class="lazyload" src="{{ url('assets/images/akbank.svg') }}">
                </div>
            </div>
            <div class="copyright">
                Akıllıphone &copy; Copyright 1998 - 2023 Her Hakkı Saklıdır
            </div>
        </div>
    </footer>
    <footer class="mobile-footer">
        <div class="container">
            <div class="follow-us">
                <div class="category-title">Bizi Takip Edin!</div>
                <ul class="links">
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/facebook.svg') }}" alt="facebook">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/twitter.svg') }}" alt="twitter">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/google.svg') }}" alt="google">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/pinterest.svg') }}" alt="pinterest">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/instagram.svg') }}" alt="instagram">
                        </a>
                    </li>
                    <li>
                        <a href="#">
                            <img src="{{ url('assets/images/youtube.svg') }}" alt="youtube">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="have-question">
                <div class="category-title">
                    Aklınıza takılan bir soru mu var?
                </div>
                <div class="call-us" >Çözüm Merkezimizi arayın</div>
                <a href="tel:08504609070">0850 520 0880</a>
            </div>
            <div class="footer-links">
                <div class="col-6">
                    <div class="footer-category">
                        <div class="category-title">
                            Kurumsal
                            <img class="arrow-down" src="{{ url('assets/images/right-arrow.svg') }}">
                        </div>
                        <ul>
                            <li><a href="{{url('/sayfa/i/hakkimizda')}}">Hakkımızda</a></li>
                            <li><a href="{{url('/sayfa/i/iletisim')}}">İletişim</a></li>
                            <li><a href="{{url('/sayfa/i/bilgi-toplumu-hizmetleri')}}">Bilgi Toplumu Hizmetleri</a></li>
                            <li><a href="{{url('/sayfa/i/gizlilik-politikasi')}}">Gizlilik Politikası</a></li>
                            <li><a href="{{url('/sayfa/i/iade-ve-degisim')}}">İade ve Değişim</a></li>
                            <li><a href="{{url('/sayfa/i/islem-rehberi')}}">İşlem Rehberi</a></li>
                            <li><a href="{{url('/sayfa/i/mesafeli-satis-sozlesmesi')}}">Mesafeli Satış Sözleşmesi</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-6">
                    <div class="footer-category">
                        <div class="category-title">
                            Kategoriler
                            <img class="arrow-down" src="{{ url('assets/images/right-arrow.svg') }}">
                        </div>
                        <ul>
                            <li> <a href="{{url('/reyonlar/ev-yasam-327?category=78')}}">Ev Yaşam</a></li>
                            <li> <a href="{{url('/reyonlar/bluetooth-kulaklik-256?category=115')}}">Bluetooth Kulaklık</a></li>
                            <li> <a href="{{url('/reyonlar/speaker-hoparlor-ses-bombasi-257?category=119')}}">Ses Bombası</a></li>
                            <li> <a href="{{url('/reyonlar/telefon-kiliflari-156?category=48')}}">Telefon Kılıfları</a></li>
                            <li> <a href="{{url('/reyonlar/usb-type-c-kablo-255?category=102')}}">Type C Kablo</a></li>
                            <li> <a href="{{url('/reyonlar/arac-ici-telefon-tutucu-213?category=3')}}">Araç Telefon Tutucu </a></li>
                            <li> <a href="{{url('/reyonlar/tablet-kiliflari-221?category=44')}}">Tablet Kılıfı</a></li>
                            <li> <a href="{{url('/reyonlar/kablosuz-sarj-aletleri-270?category=106')}}">Kablosuz Şarj Aletleri</a></li>
                            <li> <a href="{{url('/reyonlar/tamir-setleri-192?category=136')}}">Telefon Tamir Seti</a></li>
                            <li> <a href="{{url('/reyonlar/oyun-aksesuarlari-321?category=33')}}">Oyun Aksesuarları</a></li>
                            <li> <a href="{{url('/reyonlar/kisisel-bakim-337?category=75')}}">Kişisel Bakım</a></li>
                        </ul>
                    </div>
                </div>
                {{--            <div class="col-6">--}}
                {{--                <div class="footer-category">--}}
                {{--                    <div class="category-title">--}}
                {{--                        Ödeme--}}
                {{--                        <img class="arrow-down" src="{{ url('assets/images/right-arrow.svg') }}">--}}
                {{--                    </div>--}}
                {{--                    <ul>--}}
                {{--                        <li><a href="#">Ödeme Seçenekleri</a></li>--}}
                {{--                        <li><a href="#">Banka Kampanyaları</a></li>--}}
                {{--                    </ul>--}}
                {{--                </div>--}}
                {{--            </div>--}}
                <div class="col-6">
                    <div class="footer-category">
                        <div class="category-title">
                            Markalar
                            <img class="arrow-down" src="{{ url('assets/images/right-arrow.svg') }}">
                        </div>
                        <ul>
                            <li v-for="(item, index) in providers.items" :key="index"><a href="{{url('/reyonlar?brand=2217')}}" >@{{ item.providerName }}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>    <!-- Bütün scriptler -->
</div>

