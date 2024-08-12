<link rel="stylesheet" href="{{ url('assets/css/profile/orders/main.css') }}">
<style>
    a.order-detail{
        display: none!important;
    }
    .iade-popup{
        display:none;
    }
    .iade-popup.active{
        display: block;
    }
    input {
         -webkit-appearance: auto;
        -moz-appearance: auto;
         appearance: auto;
    }
</style>
<div class="right">
    <div class="orders">
        <div class="top">
            <div class="title">Sipariş detayı</div>
        </div>
        <div class="detail">
            <div class="order-list">
                <x-profile.order-line :order="$order" />
            </div>
            <div class="detail-body">
                @foreach( $order->items as $item)
                    <div class="product-details">
                        <div class="product-img">
                            <img src="{{ $item['product']->thumb }}" alt="product name">
                        </div>
                        <div class="product-info">
                            <div class="name">
                                {{$item['product']->productName}}
                                @if($item['product']->commentAble)
                                    <br><a href="{{ $item['product']->url }}">Yorum Yap</a>
                                @endif
                            </div>
                            <div class="code">
                                Ürün Kodu: {{$item['product']->productCode}} / Barkodu: {{$item['product']->variants[0]->barcode}}
                            </div>
                            <button class="btn refund-btn" href="#">İade Talebi</button><br>

                            <div  class="iade-popup alert alert-danger" style="">

                                    <a style="cursor:pointer;" class="iade-close  popup-closer"></a>
                                    <p>İade işlemi sırasında gönderimler, akilliphone.com firmasının anlaşmalı olduğu kargo şirketi olan <b>ARAS kargo</b> ile gerçekleşmelidir. Diğer kargo şirketleri kullanılarak gerçekleştirilen iade işlemleri, ücret tarafımıza ait ise kabul edilmeyecektir.<br><br>ARAS kargo <b>İade kodumuz:</b> <span style="color:#E10F13; font-weight:bold;">123 503 691 1206</span></p>
                                    <form class="form-iade" method="post">
                                        <select required name="return[returnWhy]">
                                            <option>Arızalı Ürün</option>
                                            <option>Farklı Ürün</option>
                                            <option>Diğer</option>
                                        </select>
                                        <input type="hidden" name="orderItemId"  value="{{ $item['detail']->id }}">
                                        <input required type="text" name="refund[returnMessage]"  value="" placeholder="İade veya değişim ile ilgili açıklama">
                                        <input required type="text" name="refund[returnCargo]" disabled="" value="ARAS KARGO" placeholder="Gönderim yapacağınız kargo firması">
                                        <input required type="text" name="refund[returnCargoTrack]"  value="" placeholder="Kargo takip numarası">
                                        <input required type="text" name="refund[returnIBAN]"  value="" placeholder="IBAN Numaranız">
                                        <hr>
                                        <div>
                                            <label><input required type="radio" name="refund[returnType]" value="1"> İade</label>
                                            <label><input requireds type="radio" name="refund[returnType]" value="2"> Değişim</label>
                                        </div>
                                        @csrf

                                        <button class="returnproduct returnok2">Gönder</button>
                                        <div class="temiz"></div><div id="form-result" style="text-align:center;"></div>
                                    </form>

                            </div>
                            </div>
                            </div>
                @endforeach


            </div>
        </div>
    </div>
</div>
@section('js')
    <script>
        $('.refund-btn').on('click', function (){
            $('.iade-popup').removeClass('acive');
            $(this).parents('div').find('.iade-popup').addClass('active');
        });
        $('.form-iade').on('submit', function (e) {
            e.preventDefault();
            $.ajax( {
                url:'{{ route('profile.refund.add', $order->id) }}',
                method:'POST',
                data: $(this).serialize()
            } ).done(function(review) {

                Swal.fire({
                    title: review.message,
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    icon: review.status ? 'success':'error',
                    showConfirmButton: false,
                });
                if(review.status){
                    $('#review-menu').toggleClass('review-menu--active');
                    //window.location.reload();
                }

            }).fail(function() {
                Swal.fire({
                    title: 'Yorum Tapılamadı. Lütfen daha sonra tekrar deneyiniz.',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    icon: 'error',
                    showConfirmButton: false,
                });

            });
        });
    </script>
@endsection
