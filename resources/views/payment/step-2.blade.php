@extends('layouts.payment')
@section('head')
    <title>Ödeme Sayfası - AkıllıPhone</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/css/intlTelInput.css">
    <link rel="stylesheet" href="{{ url('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/shopping/shopping-section2.css') }}?_v=<?=env('ASSETS_VER')?>">
    <style>
        .district-option{
            display: none;
        }
        .form-wrapper.billing.hide{
            display: none;
        }
        .form-wrapper.invoice-type.hide{
            display: none;
        }
        @media (min-width: 768px){
            .form-wrapper.invoice-type .signup-input {
                width: calc(33.333% - 15px);
            }
        }
    </style>
@endsection
@section('content')

    <section class="shopping_section" style="padding-top: 20px">
        <div class="container" id="basket-table">
            <x-payment.steps :step="2"/>
            <div class="signup-title">
                <h1>Bu Adresi Kullan</h1>
                @if($member=Help::getMemberInfo())
                    <div class="radio-group p-1">
                        <label class="custom-radio">Yeni Adres
                            <input class="address-manualy" required id="test" type="radio" name="shippingAddress[addressId]" checked="" value="">
                            <span></span>
                        </label>
                        @foreach(Help::getMemberAddresses() as $address)
                            <label class="custom-radio">{{ $address->addressDescription }}
                                <input class="address-registered" required type="radio" name="shippingAddress[addressId]" value="{{$address->id}}" data-adress="{{ json_encode($address, JSON_UNESCAPED_UNICODE) }}">
                                <span></span>
                            </label>
                        @endforeach
                    </div>
                @endif
                Teslimat adresiniz için lütfen aşağıdaki formu doldurun.
            </div>
            <form id="form-payment" action="{{ route('payment.step.post', 3) }}" class="shopping-wrapper" method="post" >
                <div class="form-wrapper" style="padding-bottom: 10px">
                    <div class="signup-input hide-address-registered">
                        <input required id="customer-firstName" name="customer[firstName]" type="text" placeholder="Ad" value="{{ $basket->customer['firstName'] }}">
                    </div>
                    <div class="signup-input hide-address-registered">
                        <input required id="customer-lastName" name="customer[lastName]" type="text" placeholder="Soyad" value="{{ $basket->customer['lastName'] }}">
                    </div>
                    <div class="signup-input hide-address-registered">
                        <div class="signup-select">
                            <select required id="shippingAddress-countryId" class="select-with-name" data-nametarget=".select-country" name="shippingAddress[countryId]">
                                @if($countries)
                                        <?php
                                        $selectedCountry = $basket->shippingAddress['countryId']?$basket->shippingAddress['countryId']:2;
                                        ?>
                                    @foreach($countries as $countryCode=>$country)
                                        <option value="{{ $countryCode }}" @if($selectedCountry==$countryCode) selected @endif>{{ $country }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="signup-input hide-address-registered">
                        <div class="signup-select">

                            <select id="shippingAddress-cityId" required class="select-with-name" data-nametarget=".select-city" name="shippingAddress[cityId]">
                                <option value=""> -- </option>
                                @if($cities)
                                    @foreach($cities as $cityCode=>$city)
                                        <option value="{{ $city->City }}" @if($basket->shippingAddress['cityId']==$city->City) selected @endif>{{ $city->City }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="signup-input hide-address-registered">
                        <div class="signup-select">
                            <select id="shippingAddress-districtId" required class="select-with-name" data-nametarget=".select-district" name="shippingAddress[districtId]">
                                <option value=""> -- </option>
                                @if($districts)
                                    @foreach($districts as $districtCode=>$district)

                                        <option class="district-option city-{{ $district->City }}" value="{{ $district->State }}" @if($basket->shippingAddress['districtId']==$district->State) selected @endif>{{ $district->State }}</option>

                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>
                    <div class="signup-input hide-address-registered">
                        <span class="label">Adres Adı</span>
                        <input id="shippingAddress-name" name="shippingAddress[name]" type="text" value="{{$basket->shippingAddress['name']}}">
                    </div>
                    <div class="signup-input textarea hide-address-registered">
                        <span class="label">Açık Adres</span>
                        <textarea id="shippingAddress-address" required name="shippingAddress[addressLine1]" id="" cols="30" rows="2" placeholder="Mahalle, sokak, cadde ve diğer bilgilerinizi giriniz">{{$basket->shippingAddress['addressLine1']}}</textarea>
                    </div>

                    <div class="signup-input">
                        <span class="label">Telefon</span>
                        <input name="customer[phone]" required type="text" id="mobile_code" class="form-control" value="{{$basket->customer['phone']}}">
                    </div>
                    <div class="signup-input hide-address-registered">
                        <input name="customer[email]" required type="text" placeholder="Eposta Adresi" style="height: 83%;" value="{{$basket->customer['email']}}">
                    </div>
                    <div class="signup-bill">
                        <label for="bill">
                            <input name="use_payment_adress" class="option-input checkbox" type="checkbox"  id="bill" value="1">
                            Fatura için farklı bir adres kullanılsın.
                        </label>

                    </div>
                    <div class="form-wrapper billing hide" style="width: 100%;">
                        <div class="signup-title">
                            <h1>Fatura Adresi</h1> Fatura adresiniz için lütfen aşağıdaki formu doldurun.
                        </div>
                        <div class="signup-input hide-address-registered">
                            <input required id="billingAddress-firstName" name="billingAddress[firstName]" type="text" placeholder="Ad" value="{{ $basket->billingAddress['firstName'] }}">
                        </div>
                        <div class="signup-input hide-address-registered">
                            <input required id="billingAddress-lastName" name="billingAddress[lastName]" type="text" placeholder="Soyad" value="{{ $basket->billingAddress['lastName'] }}">
                        </div>
                        <div class="signup-input hide-address-registered">
                            <div class="signup-select">
                                <select required id="billingAddress-countryId" class="select-with-name" data-nametarget=".select-country" name="billingAddress[countryId]">
                                    @if($countries)
                                            <?php
                                            $selectedCountry = $basket->billingAddress['countryId']?$basket->billingAddress['countryId']:2;
                                            ?>
                                        @foreach($countries as $countryCode=>$country)
                                            <option value="{{ $countryCode }}" @if($selectedCountry==$countryCode) selected @endif>{{ $country }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="signup-input hide-address-registered">
                            <div class="signup-select">
                                <select id="billingAddress-cityId" class="select-with-name" data-nametarget=".select-city" name="billingAddress[cityId]">
                                    <option value=""> -- </option>
                                    @if($cities)
                                        @foreach($cities as $cityCode=>$city)
                                            <option value="{{ $city->City }}" @if($basket->billingAddress['cityId']==$city->City) selected @endif>{{ $city->City }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="signup-input hide-address-registered">
                            <div class="signup-select">
                                <select id="billingAddress-districtId" class="select-with-name" data-nametarget=".select-district" name="billingAddress[districtId]">
                                    <option value=""> -- </option>
                                    @if($districts)
                                        @foreach($districts as $districtCode=>$district)

                                            <option class="district-option city-{{ $district->City }}" value="{{ $district->State }}" @if($basket->billingAddress['districtId']==$district->State) selected @endif>{{ $district->State }}</option>

                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="signup-input hide-address-registered">
                            <span class="label">Adres Adı</span>
                            <input id="billingAddress-name" name="billingAddress[name]" type="text" value="{{$basket->billingAddress['name']}}">
                        </div>
                        <div class="signup-input textarea hide-address-registered">
                            <span class="label">Açık Adres</span>
                            <textarea id="billingAddress-address" name="billingAddress[addressLine1]" id="" cols="30" rows="2" placeholder="Mahalle, sokak, cadde ve diğer bilgilerinizi giriniz">{{$basket->billingAddress['addressLine1']}}</textarea>
                        </div>
                    </div>
                    <div class="signup-bill signup-bill-type" style="width: 100%">
                        <span>Fatura Tipi:</span>
                        <label for="bireysel">
                            <input class="option-input checkbox" name="invoiceType" type="radio" id="bireysel" @if($basket->billingAddress['invoiceType']=='bireysel') checked @endif  required value="bireysel">
                            Bireysel
                        </label>
                        <label for="kurumsal">
                            <input class="option-input checkbox"  name="invoiceType" type="radio" id="kurumsal" @if($basket->billingAddress['invoiceType']=='kurumsal') checked @endif required value="kurumsal">
                            Kurumsal
                        </label>
                    </div>
                    <div class="form-wrapper invoice-type @if($basket->billingAddress['invoiceType']=='bireysel') hide  @endif" style="padding-bottom: 10px;padding-top: 10px">
                        <div class="signup-input billing hide-address-registered">
                            <input id="billingAddress-" name="billing[company]" type="text" placeholder="Şirket" value="{{$basket->billingAddress['company']}}">
                        </div>
                        <div class="signup-input billing hide-address-registered">
                            <input id="billingAddress-lastName" name="billing[taxOffice]" type="text" placeholder="Vergi Dairesi" value="{{$basket->billingAddress['taxOffice']}}">
                        </div>
                        <div class="signup-input billing hide-address-registered">
                            <input id="billingAddress-lastName" name="billing[taxNumber]" type="text" placeholder="Vergi No" value="{{$basket->billingAddress['taxNumber']}}">
                        </div>
                    </div>
                    <div class="signup-title shipping">
                        <h1>Kargo Seçenekleri</h1>
                    </div>
                    <div class="radio-group">
                        @foreach($basket->shippingBrands as $shippingBrand)
                            <label class="custom-radio">
                                <img src="{{ $shippingBrand['icon'] }}" alt="">
                                <input required type="radio" {{ $shippingBrand['checked'] }} name="shippingBrand" value="{{  $shippingBrand['code'] }}">
                                <span></span>
                            </label>
                        @endforeach
                    </div>

                </div>
                <?php $buttonText="Devam Et";?>
                <x-payment.cart-wrapper :basket="$basket" :buttonText="'Devam Et'"/>
                <input type="hidden" class="select-country" id="shippingAddress-country" name="shippingAddress[country]" value="{{$basket->shippingAddress['country']?$basket->shippingAddress['country']:'Türkiye'}}">
                <input type="hidden" class="select-city" id="shippingAddress-city" name="shippingAddress[city]" value="{{$basket->shippingAddress['city']}}">
                <input type="hidden" class="select-district" is="shippingAddress-district" name="shippingAddress[district]" value="{{$basket->shippingAddress['district']}}">
            </form>
        </div>
    </section>
@endsection
@section('js')
    <script src="{{ url('assets/js/signup-select.js.') }}?_v={{ env('ASSETS_VER') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.13/js/intlTelInput-jquery.min.js"></script>
    <script>
        $("#mobile_code").intlTelInput({
            initialCountry: "tr",
            separateDialCode: true,
        });
        $('.address-registered').on('click', function(){

            let address = $(this).data('adress');
            console.log(address);

            $("#shippingAddress-name").val(address.addressDescription);
            $("#shippingAddress-address").val(address.address);
            $("#mobile_code").val(address.phone);
            $("#shippingAddress-cityId").val(address.city);
            $("#shippingAddress-cityId").change();
            $("#shippingAddress-districtId").append('<option value="'+address.state+'" selected>'+address.state+'</option>');

        });
        {{--$('.address-registered').on('click', function(){--}}
        {{--@if(userInfo('addresses'))--}}
        {{--    let addresses = {!! json_encode(userInfo('addresses'), JSON_UNESCAPED_UNICODE) !!} ;--}}
        {{--@else--}}
        {{--    let addresses = [];--}}
        {{--@endif--}}
        {{--    $(addresses).each(function(){--}}
        {{--        console.log(this);--}}
        {{--        if($('.address-registered:checked').val() == this.addressId){--}}
        {{--            $("#customer-firstName").val(this.name)--}}
        {{--            $("#customer-lastName").val(this.surname)--}}
        {{--            $("#shippingAddress-name").val(this.title)--}}
        {{--            $("#shippingAddress-address").val(this.address1)--}}
        {{--            $("#shippingAddress-countryId").val(this.countryId)--}}
        {{--            $("#shippingAddress-cityId").val(this.cityId)--}}
        {{--            $("#shippingAddress-districtId").val(this.districtId)--}}

        {{--            $("#shippingAddress-countryId + .select-selected").text($("#shippingAddress-countryId option:selected").text())--}}
        {{--            $("#shippingAddress-cityId + .select-selected").text($("#shippingAddress-cityId option:selected").text())--}}
        {{--            $("#shippingAddress-districtId + .select-selected").text($("#shippingAddress-districtId option:selected").text())--}}

        {{--        }--}}
        {{--    });--}}
        {{--});--}}
        $('.address-manualy').on('click', function(){
            $("#customer-firstName").val('')
            $("#customer-lastName").val('')
            $("#shippingAddress-name").val('')
            $("#shippingAddress-address").val('')
            $("#shippingAddress-countryId").val('')
            $("#shippingAddress-cityId").val('')
            $("#shippingAddress-districtId").val('')

            $("#shippingAddress-countryId + .select-selected").text('')
            $("#shippingAddress-cityId + .select-selected").text('')
            $("#shippingAddress-districtId + .select-selected").text('')
            $('.hide-address-registered').fadeIn();
        });

        /* kargo adresi */
        $('#shippingAddress-cityId').on('change', function(){
            $('#shippingAddress-districtId').val('');
            $('.district-option').hide();
            $('.district-option.city-' + $(this).val()).show();
            $('#shippingAddress-city').val($('#shippingAddress-cityId option:selected').text());
        });
        $('#shippingAddress-cityId').change();
        $('#shippingAddress-districtId').val('{{ $basket->shippingAddress['districtId'] }}');
        /* fatura adresi */
        $('#billingAddress-cityId').on('change', function(){
            $('#billingAddress-districtId').val('');
            $('.district-option').hide();
            $('.district-option.city-' + $(this).val()).show();
            $('#billingAddress-city').val($('#shippingAddress-cityId option:selected').text());
        });
        $('#sbillingAddress-cityId').change();
        $('#billingAddress-districtId').val('{{ $basket->billingAddress['districtId'] }}');

        $('.select-with-name').on('change', function(){
            $($(this).data('nametarget')).val( $(this).find('option:checked').text() );
        });
        $('input[name=invoiceType]').on('change', function(){
            if($(this).val()=='kurumsal'){
                $('.form-wrapper.invoice-type').removeClass('hide');
            } else {
                $('.form-wrapper.invoice-type').addClass('hide');
            }
        });
        $('#bill').on('change', function(){
            if($(this).is(':checked')){
                $('.form-wrapper.billing').removeClass('hide');
                $('.form-wrapper.billing input, .form-wrapper.billing select').attr('required', true);
            } else {
                $('.form-wrapper.billing').addClass('hide');
                $('.form-wrapper.billing input, .form-wrapper.billing select').removeAttr('required');
            }
        });
        $('#bill').change();

        $('#shippingAddress-countryId, #shippingAddress-cityId, #shippingAddress-districtId').on('change', function(){
            setAdressName()
        });
        function setAdressName(){
            $('#shippingAddress-district').val($('#shippingAddress-districtId option:selected').text());
            $('#shippingAddress-country').val($('#shippingAddress-countryId option:selected').text());
            $('#billingAddress-city').val($('#shippingAddress-cityId option:selected').text());
        }
        $('#form-payment').on('submit', function(){
            $('#shippingAddress-district').val($('#shippingAddress-districtId option:selected').text());
            $('#shippingAddress-country').val($('#shippingAddress-countryId option:selected').text());
            $('#billingAddress-city').val($('#shippingAddress-cityId option:selected').text());
        });
    </script>
@endsection
