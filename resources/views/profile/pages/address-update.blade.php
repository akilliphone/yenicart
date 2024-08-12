<style>
    .district-option{
        display: none;
    }
</style>
    <form action="{{ route('profile.address.save', ['addressId' => $addressId]) }}" method="post">
        @csrf
        <div class="form-wrapper">
            <div class="signup-input">
                <span class="label">Adres Başlık</span>
                <input required type="text" name="address[addressDescription]" value="{{$address->addressDescription}}">
            </div>
            <div class="signup-input">
                <span class="label">Adresiniz</span>
                <input required type="text" name="address[address]" value="{{$address->address}}">
            </div>

            <div class="signup-input">
                <select required id="shippingAddress-cityId" required class="select-with-name" data-nametarget=".select-city" name="address[city]" style="width: 100%;height: 100%;font-size: 14px;color: var(--text-color);border: 1px solid #eee;border-radius: 4px;padding: 10px;">
                    <option value=""> -İl Seçiniz- </option>
                    @if($cities)
                        @foreach($cities as $cityCode=>$city)
                            <option value="{{ $city->City }}" @if($address->city==$city->City) selected @endif>{{ $city->City }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="signup-input">
                <select required id="shippingAddress-districtId" required class="select-with-name" data-nametarget=".select-district" name="address[state]"style="width: 100%;height: 100%;font-size: 14px;color: var(--text-color);border: 1px solid #eee;border-radius: 4px;padding: 10px;">
                    <option value=""> -İlçe Seçiniz- </option>
                    @if($districts)
                        @foreach($districts as $districtCode=>$district)
                            <option class="district-option city-{{ $district->City }}" value="{{ $district->State }}" @if($address->state==$district->State) selected @endif>{{ $district->State }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="signup-input">
                <span class="label">Telefon</span>
                <input required type="text" name="address[phone]" value="{{$address->phone}}">
            </div>
            <div class="signup-input">
                <span class="label">GSM</span>
                <input required type="text"  name="address[gsm]" value="{{$address->gsm}}">
            </div>
            <div class="signup-input">
                <span class="label">Firma </span>
                <input type="text" name="address[companyName]" value="{{$address->companyName}}">
            </div>
            <div class="signup-input">
                <span class="label">Vegi Dairesi </span>
                <input type="text" name="address[taxOffice]" value="{{$address->taxOffice}}">
            </div>
            <div class="signup-input">
                <span class="label">Vergi No </span>
                <input type="text" name="address[taxNo]" value="{{$address->taxNo}}">
            </div>
            <div class="signup-buttons">
                <input type="hidden" name="address[country]" value="{{$address->country?$address->country:'Türkiye'}}">
                <input type="hidden" name="address[addressType]" value="{{$address->addressType?$address->addressType:'1'}}">
                <button type="submit" class="submit-btn">Kaydet</button>
            </div>
        </div>
    </form>


</div>


@section('js')
    <script>
        $('#shippingAddress-cityId').on('change', function(){
            $('#shippingAddress-districtId').val('');
            $('.district-option').hide();
            $('.district-option.city-' + $(this).val()).show();
            $('#shippingAddress-city').val($('#shippingAddress-cityId option:selected').text());
        });
        $('#shippingAddress-cityId').change();
        $('#shippingAddress-districtId').val('<?php echo e($address->state); ?>');

    </script>
@endsection
