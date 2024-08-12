var getSupport={

    'getMessage': function(name,mail,message){


        if(name & mail & message){


            var message_url = "?name="+name+"&email="+mail+"&message="+message+"/";
            var settings = {
                "url": "https://json.akilliphone.com/concact"+message_url,
                'cache': false,
                "async": true,
                "crossDomain": true,
                "method": "GET",
                "headers": {
                    "Access-Control-Allow-Origin":"*"
                }
            };
            console.log(settings);
        }
        else{
            alert("Bilgileri Eksiksiz Doldurmalısınız.")
        }

    }


 }


