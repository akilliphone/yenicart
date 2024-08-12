<?php
if(!function_exists('member_get')){
    function member_get($key){
        return \Help::userGet($key);
    }
}
if(!function_exists('member_logged')){
    function member_logged(){
        return defined('MEMBER_ID')?MEMBER_ID:false;
    }
}
if(is_file(__DIR__.'/Enums.php')){
    include(__DIR__.'/Enums.php');
}
if(is_file(__DIR__.'/BasketService.php')){
    include(__DIR__.'/BasketService.php');
}
if(is_file(__DIR__.'/PaymentService.php')){
    include(__DIR__.'/PaymentService.php');
}
if(is_file(__DIR__.'/MailService.php')){
    include(__DIR__.'/MailService.php');
}

