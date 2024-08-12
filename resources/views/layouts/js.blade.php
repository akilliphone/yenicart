<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="{{ url('assets/js/basketService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>
{{--    <script src="{{ url('assets/js/webService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>--}}
{{--    <script src="{{ url('assets/js/contact-us.js') }}?_v={{ env('ASSETS_VER') }}"></script>--}}
<script src="{{ url('assets/js/owl.carousel.min.js') }}?_v={{ env('ASSETS_VER') }}"></script>
<script src="{{ url('assets/js/owl.carousel.thumb.js') }}?_v={{ env('ASSETS_VER') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11?_v={{ env('ASSETS_VER') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@9/swiper-bundle.min.js"></script>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
            new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','GTM-N8XV95D');
</script>

<script src="https://cdn.jsdelivr.net/npm/lazyload@2.0.0-rc.2/lazyload.js"></script>
<script src="//code.jivosite.com/widget/sveoVcXmdS" async></script>
{{--<script src="{{ url('assets/js/app.js') }}?_v={{ env('ASSETS_VER') }}"></script>--}}
{{--<script src="{{ url('assets/js/owl.carousel.min.js') }}?_v={{ env('ASSETS_VER') }}"></script>--}}
<script>
    const Help = {
        loginMember(email, password, membertype){
            var formData = new FormData();
            formData.append('email', email);
            formData.append('password', password);
            formData.append('membertype', membertype);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url:'{{ route('login.check') }}',
                method:'POST',
                data:formData,
                contentType: false,
                processData: false
            }).done(function (response) {
                if(response.status){
                    Help.alertSuccess(response.message);
                    if(response.redirect){
                        window.location.replace(response.redirect);
                    }

                } else{
                    Help.alertError(response.message);
                }
            }).fail(function(xhr, status, error) {
                Help.alertError(error);
            });
        },
        forgotPassword(email, membertype){
            var formData = new FormData();
            formData.append('email', email);
            formData.append('membertype', membertype);
            formData.append('_token', '{{ csrf_token() }}');

            $.ajax({
                url:'{{ route('login.forgot') }}',
                method:'POST',
                data:formData,
                contentType: false,
                processData: false
            }).done(function (response) {
                if(response.status){
                    Help.alertSuccess(response.message);
                    if(response.redirect){
                        window.location.replace(response.redirect);
                    }

                } else{
                    Help.alertError(response.message);
                }
            }).fail(function(xhr, status, error) {
                Help.alertError(error);
            });
        },
        logoutMember(){
            $.ajax({
                url:'{{ route('login.out') }}',
            }).done(function (response) {
                if(response.status){
                    Help.alertSuccess(response.message);
                    window.location.replace('{{ url('/') }}');
                } else{
                    Help.alertError(response.message);
                }
            }).fail(function(xhr, status, error) {
                Help.alertError(error);
            });
        },
        getHeaders(){
            let headers = {
                'Authorization': 'Bearer {{ JWT_TOKEN }}' ,
                'Content-Type': 'application/json'
            }
            return headers;
        },
        getCookie(name) {
            const value = `; ${document.cookie}`;
            const parts = value.split(`; ${name}=`);
            if (parts.length === 2) return parts.pop().split(';').shift();
        },
        setCookie(name, value, days) {
            const date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            const expires = `expires=${date.toUTCString()}`;
            document.cookie = `${name}=${value};${expires};path=/`;
        },
        alertSuccess(message){
            this.alert(message, 'success')
        },
        alertError(message){
            this.alert(message, 'error')
        },
        alert(message, type){
            Swal.fire({
                title:  message,
                toast: true,
                position: 'top-end',
                timer: 4000,
                icon: type,
                showConfirmButton: false,
            });
        },
        formatPrice(price){
            return price + '₺'
            if(+price){
            } else {
                return 'Sorunuz';
            }
        },
        sendAjaxForm: function(form){
            form.find('button').attr('disabled', true);
            form.find('button').addClass('disabled');
            var settings = {
                "url": form.attr('action'),
                'cache': false,
                "method":  form.attr('method'),
                data:form.serialize(),
                form:form
            };
            $.ajax(settings).done(function (response) {
                if(response.status){
                    Help.alertSuccess(response.message);
                } else{
                    Help.alertError(response.message);
                }
                if(response.hasOwnProperty('redirect') ){
                    if(response.redirect){
                       window.location.href =  response.redirect;
                    }
                }
            }).fail(function(xhr, status, error) {
                Help.alertError(error);
            }).always(function (xhr, status, error) {
                this.form.find('button').attr('disabled', false);
                this.form.find('button').removeClass('disabled');
            });
        },
        createFilter: function(){
            let url_filters = [];

            if($('.forfilter.text').length){
                url_filters.push('text=' + $('.forfilter.text').val()) ;
            }
            let categories = [];
            if($('.forfilter.category').length){
                $('.forfilter.category').each(function(){
                    if($(this).is(':checked')){
                        categories.push($(this).attr('value'))
                    }
                });
                if(categories.length){
                    url_filters.push('category=' + categories.join(',')) ;
                }
            }
            //
            let providers = []
            if($('.forfilter.provider').length){
                $('.forfilter.provider').each(function(){
                    if($(this).is(':checked')){
                        providers.push($(this).attr('value'))
                    }
                });
                if(providers.length){
                    url_filters.push('provider=' + providers.join(',')) ;
                }
            }
            let colors = []
            if($('.forfilter.color').length){
                $('.forfilter.color').each(function(){
                    if($(this).is(':checked')){
                        colors.push($(this).attr('value'))
                    }
                });
                if(colors.length){
                    url_filters.push('color=' + colors.join(',')) ;
                }
            }
            if($('.forfilter.orderBy').length){

                url_filters.push('orderby=' + $('input[name="orderby"]:checked').val()) ;
                url_filters.push('dir=' + $('input[name="orderby"]:checked').data('dir')) ;

            }
            if($('#priceMin').length){
                if($('#priceMin').val()){
                    url_filters.push('pricemin=' + $('#priceMin').val());
                }
            }
            if($('#priceMax').length){
                if($('#priceMax').val()){
                    url_filters.push('pricemax=' +  $('#priceMax').val());
                }
            }
            if($('.forfilter.custom').length){
                if($('.forfilter.custom').val()){
                    url_filters.push('custom=' + $('.forfilter.custom').val()) ;
                }
            }

            return url_filters.join('&');
        },
        init(){
            $(document).ready(function () {
                $('body').on('click', 'a.confirm', function(e){
                    e.preventDefault();
                    Help.logoutMember();
                    return false;
                });
                $('body').on('submit', '#form-login', function(e){
                    e.preventDefault();
                    Help.loginMember($('#email').val(), $('#password').val(), $('#membertype').val());
                    return false;
                });
                $('body').on('submit', '#form-forgot', function(e){
                    e.preventDefault();
                    Help.forgotPassword($('#forgotemail').val(), $('#membertype').val());
                    return false;
                });
                $('.ajaxForm').on('submit', function(e){
                    e.preventDefault();
                    Help.sendAjaxForm($(this));
                });

            });
            console.log('Load: 5bc4a4a9e09868645adac1cddda07371');
        },
        _uyari: function () {
            this.alertError('Sadece Bu sayfayı kontrol ediniz');
        }
    }
    Help.init();

    (function () {
        if (window.innerWidth >= 768) {
            var options = {
                whatsapp: "+905492785372", // WhatsApp numarası
                call_to_action: "Merhaba, nasıl yardımcı olabilirim?", // Görüntülenecek yazı
                position: "left", // Sağ taraf için 'right' sol taraf için 'left'
            };
            var proto = '';//document.location.protocol,
            var host = "getbutton.io", url = proto + "//static." + host;
            var s = document.createElement('script');
            s.type = 'text/javascript';
            s.async = true;
            s.src = url + '/widget-send-button/js/init.js';
            s.onload = function () {
                WhWidgetSendButton.init(host, proto, options);
            };
            var x = document.getElementsByTagName('script')[0];
            x.parentNode.insertBefore(s, x);
        }
    })();
    $('.hasyTc').remove();

    window.onscroll = function () {
        scrollFunction();
    };

    function scrollFunction() {
        var scrollButton = document.querySelector('.scroll-to-top');
        if(scrollButton){
            if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
                scrollButton.style.display = 'block';
            } else {
                scrollButton.style.display = 'none';
            }
        }
    }

    function scrollToTop() {
        document.body.scrollTop = 0; // For Safari
        document.documentElement.scrollTop = 0; // For Chrome, Firefox, IE, and Opera
    }

    function searchInputKeyPress(event) {
        if (event.keyCode === 13) {
            event.preventDefault();
            if($('#searchTextButton').length){
                $('#searchTextButton').click();
            }
        }
    }

    $('.search-bar').on('focusout', function(){
        setTimeout(function (){
            $('.search-results').hide();
        }, 300);
    });
    $('.search-input').on('focus', function(){
        if($('.search-input').val()){
            $('.search-results').show();
        }
    });
    $( ".search-input" ).autocomplete({
        source: function( request, response ) {
            $.ajax( {
                url: "{{ route('product.autocomplate') }}",
                dataType: "json",
                data: {
                    text: request.term
                },
                success: function (data) {
                    $('.search-results').html(data.html);
                    $('.search-results').show();
                }
            });
        },
        minLength: 2,
        select: function( event, ui ) {
            log( "Selected: " + ui.item.value + " aka " + ui.item.id );
        },
        close: function( event, ui ) {

        }
    } );
    $('body').on('click', '.hidePass', function (){
        if($($(this).data('target')).length){
            if($($(this).data('target')).attr('type')=='text'){
                $($(this).data('target')).attr('type', 'password');
            } else {
                $($(this).data('target')).attr('type', 'text');
            }
        }
    });
    $('#mobile-show-provider').on('click', function (){
        if($('.btn-mobile.provider').hasClass('is-visible')){
            $('.btn-mobile.provider').removeClass('is-visible')

        } else{
            $('.btn-mobile').removeClass('is-visible')
            $('.btn-mobile.provider').addClass('is-visible')
        }
    });
    $('#mobile-show-category').on('click', function (){
        if($('.btn-mobile.category').hasClass('is-visible')){
            $('.btn-mobile.category').removeClass('is-visible')

        } else{
            $('.btn-mobile').removeClass('is-visible')
            $('.btn-mobile.category').addClass('is-visible')
        }
    });
    $("img.lazyload").lazyload();
    function isValidURL(url) {
        try {
            new URL(url);
            return true;
        } catch (error) {
            return false;
        }
    }

    function create_product_owl_slider(target){
        $(document).ready(function () {
            if($(target).length){
                $(target).owlCarousel({
                    responsiveClass: true,
                    nav:true,
                    dots:false,
                    responsive: {
                        0: {
                            items: 2,
                            margin: 8,
                        },
                        425: {
                            items: 2,
                            margin: 15,
                        },
                        500: {
                            items: 3,
                            margin: 20,
                        },
                        768: {
                            items: 4,
                            margin: 15,
                        },
                        1024: {
                            items: 5,
                            margin: 10,
                        },
                        1200: {
                            items: 6,
                            margin: 30,
                            drag: true,
                            mouseDrag: true,
                        }
                    }
                });
            }
        });
    }
    if($('.product-asyn-slider.owl-carousel').length){
        $('.product-asyn-slider.owl-carousel').each(function(){
            create_product_owl_slider('#'+$(this).attr('id'));
        });
    }
    create_product_owl_slider('.product-slider.owl-carousel');
    @if($flash = session()->get('flash-error'))
    Swal.fire({
        title: '{{ $flash[0] }} {{ $flash[1] }}',
        toast: true,
        position: 'top-end',
        timer: 3000,
        icon: 'error',
        showConfirmButton: false,
    });
    @endif
    @if($flash = session()->get('flash-success'))
    Swal.fire({
        title: '{{ $flash[0] }} {{ $flash[1] }}',
        toast: true,
        position: 'top-end',
        timer: 3000,
        icon: 'success',
        showConfirmButton: false,
    });
    @endif

    $('body').on('click', '.confirm-link', function (e){
        e.preventDefault();
        if(confirm($(this).data('confirm'))){
            window.location.href = $(this).attr('href');
        }
    })
</script>
