const BasketService = {
    init : function (){
        $('body').on('change', '.decrease-increase', function (){
            $.ajax( "{{ url('basket/set') }}/" + $(this).data('variyantid') + '/' + $(this).val() )
                .done(function(basket) {
                    $('.shopping-cart.mini').html(basket.mini);
                    $('#basket-table').html(basket.table);
                    Swal.fire({
                        title: 'Ürün Adedi Değiştirildi.',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        icon: 'success',
                        showConfirmButton: false,
                    });

                })
                .fail(function() {
                    alert( "error" );
                })
                .always(function() {
                    //alert( "complete" );
                });
        });
        console.log('Basket service is runing...');
    }
}
BasketService::int();
