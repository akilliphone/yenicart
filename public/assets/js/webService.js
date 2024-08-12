var productsAjax = null;
var webService = {

    getUserToken:function (username,password){


            const xhr = new XMLHttpRequest();
            const url = "https://api.duzzona.site/login";
            xhr.open("POST", url);
            const requestBody = {
                "username": username,
                "password": password,
            }
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.setRequestHeader( "Authorization" , 'Bearer '+token);
               xhr.send(JSON.stringify(requestBody));

        let userToken;
        xhr.onreadystatechange = function () {
            const parsedResponse = JSON.parse(xhr.response);
            userToken = parsedResponse.token;
            if (userToken){
                getUser(userToken)
            }

        };

        function getUser(userToken){
            var settings = {
                "url": "https://api.duzzona.site/user",
                'cache': false,
                "async": true,
                "crossDomain": true,
                "method": "GET",
                "headers": {
                    "Access-Control-Allow-Origin":"*",
                    "Authorization" :'Bearer '+userToken,
                }
            };
            $.ajax(settings).done(function (response) {
            console.log(response);
            }).fail(function(xhr, status, error) {


            });
        }

    },

    getSectionProducts: function(url, target){
        var settings = {
            "url": webserviceUrl + url,
            'cache': false,
            "async": true,
            "crossDomain": true,
            "method": "GET",
            "headers": {
                "Access-Control-Allow-Origin":"*",
                "Authorization" :'Bearer '+token,
            },
            target:target
        };
        $.ajax(settings).done(function (response) {
            $(response.data.items).each(function (index){
                response.data.items[index] = webService._prepareItem(response.data.items[index]);
            });
            app.sections[this.target]=response.data.items;
            //console.log(app.sections);
            app.target = this.target;

        }).fail(function(xhr, status, error) {
            if (xhr.status === 404) {
                app.error="Aradığınız Kriterde Ürün Bulunamadı..!"
            } else if (xhr.status === 400) {
                app.error="Sunucu Hatası..! Lütfen Tekrar Deneyiniz."
            } else {
                app.error=error;
            }
            app.sections[target]=[];
        });
    },
    getFilteredProducts: function(url, scrolling){
        //scrolling = true;
        var settings = {
            "url": url,
            'cache': false,
            "async": true,
            "crossDomain": true,
            "method": "GET",
            "scrolling":scrolling,
            "headers": {
                "Access-Control-Allow-Origin":"*",
                "Authorization" :'Bearer '+token,
            }
        };
        $('#jscroll-next').attr('href', url);
        if (productsAjax !=null){
            if (productsAjax.readyState > 0 && productsAjax.readyState < 4) return false;
        }
        if(!settings.scrolling && app ){
            app.datas.items = [];
        }
        productsAjax = $.ajax(settings).done(function (response) {

            $(response.data.items).each(function (index){
                response.data.items[index] = webService._prepareItem(response.data.items[index]);

            });
            let nextPageUrl = response.data.nextPageUrl;
            if(response.data.page*1>=response.data.totalPage*1){
                $('#jscroll-next').attr('href', '');
                app.error="Liste Sonuna gelindi."
            } else {
                $('#jscroll-next').attr('href', nextPageUrl);
            }
            if(settings.scrolling){
                //$('#jscroll-next').addClass('jscroll-next');
                let temp = response.data;
                temp.items = app.datas.items.concat(response.data.items);
                app.datas = temp
            } else {
                app.datas=response.data;
            }
            if(response.data.page>1)window.history.pushState(null, 'Title',  webService.replaceUrlParam(base_url , 'p' , response.data.page));
        }).fail(function(xhr, status, error) {
            if (xhr.status === 404) {
                app.error="Aradığınız Kriterde Ürün Bulunamadı..!"
            } else if (xhr.status === 400) {
                app.error="Sunucu Hatası..! Lütfen Tekrar Deneyiniz."
            } else {
                app.error=error;
            }
            app.datas=[];
        });
    },
    createFilter: function(){
        let url_filter = [];
        // create selected color filter
        let colors = []
        $('.color').each(function(){
            if($(this).is(':checked')){
                colors.push($(this).attr('value'))
            }
        });
        const renkler = colors.join(',');
        const fiyatlar = this._fiyatal();
        const kategoriler = this._kategorial();
        const search = this._search();
        const orderBy = this._orderBy();
        const section = this._section();
        // create selected brand filter
        let brand = []
        $('.forfilter.brands').each(function(){
            if($(this).is(':checked')){
                brand.push($(this).attr('value'))
            }
        });
        const markalar = brand.join(',');
        const kargolar = this._kargoal();
        if(kargolar){
            url_filter.push('shipping=' + kargolar) ;
        }
        if(renkler){
            url_filter.push('color=' + renkler) ;
        }
        if(fiyatlar){
            url_filter.push('price=' + fiyatlar) ;
        } if(markalar){
            url_filter.push('brand=' + markalar) ;
        }if(kategoriler){
            url_filter.push('cat=' + kategoriler) ;
        }if(search){
            url_filter.push('text=' + search) ;
        }
        if(section){
            url_filter.push('section=' + section) ;
        }
        if(orderBy){
            url_filter.push( orderBy) ;
        }
        return url_filter.join('&');
    },
    replaceUrlParam: function(url, paramName, paramValue) {
        if (paramValue == null) {
            paramValue = '';
        }
        var pattern = new RegExp('\\b('+paramName+'=).*?(&|#|$)');
        if (url.search(pattern)>=0) {
            return url.replace(pattern,'$1' + paramValue + '$2');
        }
        url = url.replace(/[?#]$/,'');
        return url + (url.indexOf('?')>0 ? '&' : '?') + paramName + '=' + paramValue;
    },

    getProductImageUrl: function(url,w,h){
        if(url.includes('://')) return url;
        if(!w) w = 100;
        if(!h) h = 100;
        let port = 'img'
        url = url.trim('/');
        let parts = url.split('/');
        if(parts){
            port = parts.shift();
        }
        ports = {'up':'8000', 'up2':'8001', 'up3':'8002', 'upwater':'8003','img':'8004' };
        if( ports.hasOwnProperty(port)){

            url = 'https://cdn.akilliphone.com/' + ports[port] + '/' + w  + 'x' + h + '/' + parts.join('/') + '?port';
        } else{
            url = 'https://cdn.akilliphone.com/' + parts.join('/') + '?noport';
        }
        return url;
    },
    _prepareItem: function (item){
        item['newPrice']='*';
        item['oldPrice']='';
        item['thumb']= this.getProductImageUrl(item['featuredImage'], 160, 160);
        if(item.variants.length){
            if(item.variants[0]['price']){
                item['newPrice'] = (item.variants[0]['price'].toFixed(2)*1).toLocaleString('en-US');
                if(item.variants[0]['price']<item.variants[0]['oldPrice']){
                    item['oldPrice'] = (item.variants[0]['oldPrice'].toFixed(2)*1).toLocaleString('en-US') + ' ₺';
                }
            }
        }
        item['newPrice'] += ' ₺';

        return item;
    },
    _kategorial:function (){
        let category = []
        $('.forfilter.category').each(function(){
            if($(this).is(':checked')){
                category.push($(this).attr('value'))
            }
        });
        return category.join(',');
    },
    _fiyatal: function(){
        let price = []
        $('.forfilter.price').each(function(){
            if($(this).is(':checked')){
                price.push($(this).attr('value'))
            }
        });
        return price.join(',');
    },
    _search: function(){
        let search = []
        $('.forfilter.searchText').each(function(){
            if($(this).is(':checked')){
                search.push($(this).attr('value'))
            }
        });
        return search.join(',');
    },
    _orderBy: function(){

        if($('.forfilter.orderBy:checked').length){
            let values = $('.forfilter.orderBy:checked').val();
            let vals = values.split('|');
            let orderby = 'sort='+vals[0]+'&orderby='+vals[1];
            return orderby
        }else{
            let values = $('select.forfilter.orderBy').val();
            if(values){
                let vals = values.split('|');
                let orderby = 'sort='+vals[0]+'&orderby='+vals[1];
                return orderby
            }
        }
        return '';
    },
    _markaal: function(){

    },
    _kargoal: function(){
        let brand = []
        $('.forfilter.shippings').each(function(){
            if($(this).is(':checked')){
                brand.push($(this).attr('value'))
            }
        });
        return brand.join(',');
    },
    _section: function(){
        let sections = []
        $('.forfilter.sections').each(function(){
            if($(this).is(':checked')){
                sections.push($(this).attr('value'))
            }
        });
        return sections.join(',');
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
                webService.SwalAlert('success', response.message);
            } else{
                webService.SwalAlert('error', response.message);
            }
        }).fail(function(xhr, status, error) {
            webService.SwalAlert('error', error);
        });
    },
    SwalAlert: function (type, message){
        Swal.fire({
            title:  message,
            toast: true,
            position: 'top-end',
            timer: 3000,
            icon: type,
            showConfirmButton: false,
        });
    },
}
