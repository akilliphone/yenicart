@extends('layouts.default')
@section('head')
    <link rel="stylesheet" href="{{ url('assets/css/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/signup.css') }}">
    <title> Üye ol - Akıllıphone</title>

@endsection
@section('content')

    <section class="sign-up" >
        <div class="container">
            <div class="signup-title">
                <h1>{{ $title }}</h1>
                Size Size özel kupon, indirim ve diğer avantajlardan yararlanın.
            </div>
            <form class="ajaxForm" action="/register" method="post">
                @csrf
                <div class="form-wrapper">
                    @if( $membertype == App\Helpers\MemberTypes::BAYI)
                        <div class="signup-input">
                            <span class="label">Sorumlu Adı<span>&nbsp;*</span></span>
                            <input type="text" name="member[name]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Soyadı<span>&nbsp;*</span></span>
                            <input type="text" name="member[surName]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Firma Adı<span>&nbsp;*</span></span>
                            <input  type="text" name="member[companyName]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Vergi Dairesi<span>&nbsp;*</span></span>
                            <input  type="text" name="member[taxOffice]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Vergi No<span>&nbsp;*</span></span>
                            <input  type="text" name="member[taxNumber]" required>
                        </div>
                    @else
                        <div class="signup-input">
                            <span class="label">Adı<span>&nbsp;*</span></span>
                            <input type="text" name="member[name]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Soyadı<span>&nbsp;*</span></span>
                            <input type="text" name="member[surName]" required>
                        </div>
                        <div class="signup-input">
                            <span class="label">Tc Kimlik No<span>&nbsp;*</span></span>
                            <input  type="text" name="member[tckimlik]" required>
                        </div>
                    @endif
                    <div class="signup-input">
                        <span class="label">E-Posta Adresi<span>&nbsp;*</span></span>
                        <input type="text" name="member[email]" required>
                    </div>
                    <div class="signup-input">
                        <span class="label">Şifre<span>&nbsp;*</span></span>
                        <input type="password" name="password"  id="pass"  required>
                    </div>

                    <div class="signup-input">
                        <span class="label">Cep Tel<span>&nbsp;*</span></span>
                        <input id="mobilePhone" type="text" name="member[gsm]"  required>
                    </div>
                    <div class="signup-input">
                        <span class="label">Şifre Tekrar<span>&nbsp;*</span></span>
                        <input type="password" name="password2"  required>
                    </div>
                    <div class="signup-agreement">
                        <label for="membership">
                            <input class="option-input checkbox" type="checkbox" id="membership" required>
                            Üyelik Sözleşmesi şartlarını okudum ve kabul ediyorum.
                        </label>
                        <label for="permission">
                            <input class="option-input checkbox" type="checkbox" id="permission" required>
                            Tarafımla pazarlama ve tanıtım amaçlı iletişime geçilmesine izin veriyorum.
                        </label>
                    </div>
                    <div class="signup-buttons">
                        <button type="submit" class="submit-btn" >{{ $button }}</button>
                        <a href="{{route('login')}}">Üye misin? Hemen Giriş Yap</a>
                        <input type="hidden" name="member[idMemberGroup]"  value="{{ $membertype }}">
                    </div>
                    <a class="kvkk" href="#">KVKK kapsamında akilliphone.com Kişisel Verilerin Korunması ve İşlenmesi Şartları na buradan ulaşabilirsiniz.</a>
                </div>
            </form>
        </div>
    </section>

@endsection
@section('js')

@endsection
