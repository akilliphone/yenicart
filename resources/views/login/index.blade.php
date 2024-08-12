@extends('layouts.default')
@section('head')
    <link rel="stylesheet" href="{{ url('assets/css/login/signup.css') }}">
    <title>Giriş Yap - Akıllıphone</title>

@endsection
@section('content')

    <section class="sign-in section-padding">
        <div class="container">
            <div class="left">
                <div class="phone">
                    <img src="{{ url('assets/images/login/phone.svg') }}" alt="phone">
                </div>
                <div class="left-inner">

                    <form id="form-login" method="POST">
                        <h2>{{ $title }}</h2><hr>
                        @csrf
                        <div class="signup-input">
                            <input type="text" id="email"name="email" required>
                            <label for="">E-Posta Adresi</label>
                            <span class="input-icon">
                                <img src="{{ url('assets/images/login/mail.svg') }}" alt="mail">
                            </span>
                        </div>
                        <div class="signup-input">
                            <input id="password" type="password" name="password" oninput="removeSpaces()" required >
                            <label for="">Şifre</label>
                            <span class="input-icon hidePass" data-target="#password" required>
                                Göster
                                <img src="{{ url('assets/images/login/lock.svg') }}" alt="lock">
                            </span>
                        </div>

                        <div class="login-btns">
                            <input type="hidden" id="membertype" name="membertype" value="{{ $membertype }}">
                            <button class="login-btn" type="submit">Giriş Yap</button>
                            <a class="signup-btn" href="register" style="color: white;
    margin-top: 15px !important;display: none">{{ $button }}</a>
                            <a href="" class="without-login">Üye Olmadan Devam Et</a>
                            <a class="forgot-password" href="">Şifremi Unuttum</a>
                        </div>
                    </form>
                    <form id="form-forgot" method="POST" style="display:none">
                        <h2>Şifremi Unuttum</h2><hr>
                        @csrf
                        <div class="signup-input">
                            <input type="text" id="forgotemail"name="email" required>
                            <label for="">E-Posta Adresi</label>
                            <span class="input-icon">
                                <img src="{{ url('assets/images/login/mail.svg') }}" alt="mail">
                            </span>
                        </div>
                        <div class="login-btns">
                            <button class="login-btn" type="submit">Şifre Yenile</button>
                            <a href="" class="without-login">Üye Olmadan Devam Et</a>
                            <a class="login-user" href="">Kullanıcı Girişi</a>
                        </div>

                    </form>
                </div>
            </div>

            <div id="popup" style="display: none;">
                <form id="popupForm">
                    <input type="text" id="textBox">
                    <button type="button" id="submitButton">Gönder</button>
                </form>
            </div>



            <div class="right">
                <div class="signin-title">
                    <h1>{{ $ask }}</h1>
                    <span class="descr">Hemen üye olun, indirimli alışverişin keyfini çıkarın!</span>
                </div>
                <div class="shopping-info">
                    <div class="info-box">
                        <div class="title">Hızlı Teslimat</div>
                        <img src="{{ url('assets/images/login/teslimat.svg') }}" alt="Hızlı Teslimat">
                        <div class="text">Saat 14:00’e kadar verdiğiniz siparişler aynı gün kapınızda.</div>
                    </div>
                    <div class="info-box">
                        <div class="title">Tek Tıkla Güvenli Alışveriş</div>
                        <img src="{{ url('assets/images/login/tektik.svg') }}" alt="Tek Tıkla Güvenli Alışveriş">
                        <div class="text">Ödeme ve adres bilgilerinizi kaydedin, güvenli alışveriş yapın.</div>
                    </div>
                    <div class="info-box">
                        <div class="title">Heryerden Erişin</div>
                        <img src="{{ url('assets/images/login/erisim.svg') }}" alt="Heryerden Erişin">
                        <div class="text">Dilediğiniz her yerden güvenli alışverişin keyfini çıkarın.</div>
                    </div>
                    <div class="info-box">
                        <div class="title">Kolay İade</div>
                        <img src="{{ url('assets/images/login/iade.svg') }}" alt="Kolay İade">
                        <div class="text">Aldığınız ürünü iade etmek hiç bu kadar kolay olmamıştı.</div>
                    </div>
                </div>
                <a class="signup-btn" href="{{ $register_route }}">{{ $button }}</a>
            </div>
        </div>
    </section>

@endsection
@section('js')
    <script>
        $('.forgot-password').on('click', function (e) {
            e.preventDefault();
            $('#form-login').hide();
            $('#form-forgot').show();
        });
        $('.login-user').on('click', function (e) {
            e.preventDefault();
            $('#form-login').show();
            $('#form-forgot').hide();
        });
    </script>
@endsection
