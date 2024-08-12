
$(function() {
    const BasketService = {
        int : function (){
            $('body').on('change', '.decrease-increase', function (){
                const count = $(this).val();
                const product_id = $(this).data('product_id');
                const color_id = $(this).data('color_id');

                $.ajax( "/basket/set/" + product_id + '/' + color_id + '/' + count )
                    .done(function(basket) {
                        $('.shopping-cart.mini').html(basket.mini);
                        $('#basket-table').html(basket.table);
                        if(basket.flashes.length>0){
                            Swal.fire({
                                title:  basket.flashes.join("\r\n"),
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'error',
                                showConfirmButton: false,
                            });
                        } else{
                            Swal.fire({
                                title: 'Ürün Sepete Eklendi.',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'success',
                                showConfirmButton: false,
                            });
                        }

                    })
                    .fail(function() {
                        alert( "error" );
                    })
                    .always(function() {
                        //alert( "complete" );
                    });
            });
            $('body').on('click', '.value-button.decrease', function(){
                var value = $(this).parent().find('[data-value]').val();
                if(value > 1) {
                    value--;
                    $(this).parent().find('[data-value]').val(value);
                    $(this).parent().find('[data-value]').change();
                }
            });
            $('body').on('click', '.value-button.increase', function(){
                var value = $(this).parent().find('[data-value]').val();
                if(value < 100) {
                    value++;
                    $(this).parent().find('[data-value]').val(value);
                    $(this).parent().find('[data-value]').change();
                }
            });
            $('body').on('change', '.decrease-increase', function(){
                var value = $(this).val();
                if(value == undefined || isNaN(value) == true || value < 0) {
                    $(this).val(0);
                } else if(value >= 101) {
                    $(this).val(100);
                }
            });
            $('body').on('click', '.addtocart', function (){
                const count = $('#product-qty').val();
                const product_id = $('#product-qty').data('product_id');
                const color_id = $('#product-qty').data('color_id');
                $.ajax( "/basket/add/" + product_id + '/' + color_id + '/' + count )
                    .done(function(basket) {
                        console.log(basket)
                        $('.shopping-cart').html(basket.mini);
                        if(basket.flashes.length>0){
                            Swal.fire({
                                title:  basket.flashes.join("\r\n"),
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'error',
                                showConfirmButton: false,
                            });
                        } else{
                            Swal.fire({
                                title: 'Ürün Sepete Eklendi.',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'success',
                                showConfirmButton: false,
                            });
                        }
                    })
                    .fail(function() {
                        Swal.fire({
                            title: 'Ürün Spete Eklenemedi.',
                            toast: true,
                            position: 'top-end',
                            timer: 3000,
                            icon: 'error',
                            showConfirmButton: false,
                        });
                    })
                    .always(function() {
                        //alert( "complete" );
                    });
            });
            $('body').on('click', '.product-delete', function (){
                const itemcode = $(this).data('itemcode');
                $.ajax( "/basket/remove/" + itemcode)
                    .done(function(basket) {
                        $('.shopping-cart.mini').html(basket.mini);
                        $('#basket-table').html(basket.table);
                        if(basket.flashes.length>0){
                            Swal.fire({
                                title:  basket.flashes.join("\r\n"),
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'error',
                                showConfirmButton: false,
                            });
                        } else{
                            Swal.fire({
                                title: 'Ürün Sepete Eklendi.',
                                toast: true,
                                position: 'top-end',
                                timer: 3000,
                                icon: 'success',
                                showConfirmButton: false,
                            });
                        }

                    })
                    .fail(function() {
                        alert( "error" );
                    })
                    .always(function() {
                        //alert( "complete" );
                    });
            });
        }
    }
    BasketService.int();
});

