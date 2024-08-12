<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
{{--    <script src="{{ url('assets/js/webService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>--}}
{{--    <script src="{{ url('assets/js/basketService.js') }}?_v={{ env('ASSETS_VER') }}{{ time() }}"></script>--}}
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
            fetch('{{ route('member.login') }}', {method: 'POST', body:JSON.stringify({email:email, password:password, membertype:membertype})})
                .then(response => response.json())
                .then(response => {
                    if(response.status){
                        Help.alertSuccess(response.message);
                        Help.setCookie('jwtToken', response.data.jwtToken);
                        window.location.replace('{{ url('/') }}');
                    } else{
                        Help.alertError(response.message);
                    }
                })
                .catch(error => {
                    Help.alertError('Üzgünüz, iletişim Hatası nedeniyle oturum başlatılamıyor. Lütfen daha sonra tekrar deneyiniz!');
                    console.error('API Hatası:', error);
                });
        },
        logoutMember(){
            this.setCookie('jwtToken', null);
            window.location.replace('{{ url('/') }}');
        },
        getHeaders(){
            let headers = {
                'Authorization': 'Bearer ' + this.getCookie('jwtToken'),
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
        updateToken(newToken) {
            this.apiToken = newToken;
            this.setCookie('jwtToken', newToken, 7);
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
            }).fail(function(xhr, status, error) {
                Help.alertError(error);
            }).always(function (xhr, status, error) {
                this.form.find('button').attr('disabled', false);
                this.form.find('button').removeClass('disabled');
            });
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
                $('.ajaxForm').on('submit', function(e){
                    e.preventDefault();
                    Help.sendAjaxForm($(this));
                });

            });
            console.log('Load: 5bc4a4a9e09868645adac1cddda07371');
        }
    }
    Help.init()
    const vueHeader = new Vue({
        el: '#app-header',
        data: {
            mega_menu: [],
            first_category: [],
            member: {},
        },
        mounted() {
            this.loadHeader();
        },
        methods: {
            loadHeader() {
                fetch('{{ route('header.load') }}', {headers:Help.getHeaders()})
                    .then(response => response.json())
                    .then(response => {
                        if(response.mega_menu){
                            this.mega_menu = response.mega_menu;
                            this.first_category = response.mega_menu.first_category;
                        }
                        if(response.member){
                            this.member = response.member;
                        }
                    })
                    .catch(error => {
                        console.error('API Hatası:', error);
                    });
            }
        }
    });
    const vueFooter = new Vue({
        el: '#app-footer',
        data: {
            providers: [],
        },
        mounted() {
            this.loadHeader();
        },
        methods: {
            loadHeader() {
                fetch('{{ route('footer.load') }}', { headers:Help.getHeaders()})
                    .then(response => response.json())
                    .then(response => {
                        if(response.providers){
                            this.providers = response.providers;
                        }
                    })
                    .catch(error => {
                        console.error('API Hatası:', error);
                    });
            }
        }
    });

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
        if (document.body.scrollTop > 20 || document.documentElement.scrollTop > 20) {
            scrollButton.style.display = 'block';
        } else {
            scrollButton.style.display = 'none';
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

</script>
