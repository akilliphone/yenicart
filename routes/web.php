<?php

use App\Api\Controllers\HomeService;
use \App\Api\Controllers\MemberService;
use App\Api\Controllers\ProductService;
use App\Http\Controllers\BasketController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\MemberController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
$clientIpAddress = request()->getClientIp();
$valids = [
    '159.146.47.17',
];
if(!in_array($clientIpAddress, $valids)){
    //die('Lütfen Daha Sonra Deneyiniz!...'.$clientIpAddress);
}

Route::group(['middleware'=>['web', \App\Http\Middleware\CheckUserLogin::class]], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/page', [HomeController::class, 'index'])->name('page');
    Route::get('/logout', [MemberController::class, 'login'])->name('logout');
    Route::get('/login', [MemberController::class, 'login'])->name('login');
    Route::get('/register', [MemberController::class, 'registerUye'])->name('register.uye');
    Route::post('/register', [MemberController::class, 'create'])->name('create');
    Route::get('/register/bayi', [MemberController::class, 'registerBayi'])->name('register.bayi');
    Route::get('/login/out', [MemberController::class, 'out'])->name('login.out');
    Route::post('/login/check', [MemberController::class, 'check'])->name('login.check');
    Route::post('/login/forgot', [MemberController::class, 'forgot'])->name('login.forgot');
    Route::get('/login/bayi', [MemberController::class, 'bayi'])->name('bayi.login');
    Route::get('/reyonlar/{category?}', [SearchController::class, 'search'])->name('product.search');
    Route::get('/incele/{slug}', [ProductController::class, 'detail'])->name('product.detail');
    Route::post('/review/add', [ProductController::class, 'reviewAdd'])->name('product.review.add');
    Route::get('/thankyou/{orderId}/{orderNumber}', [PaymentController::class, 'thankYou'])->name('thankyou');
    Route::get('/sayfa/i/{pageSlug}', [PageController::class, 'index'])->name('page');
    Route::post('/page/iletisim', [PageController::class, 'index'])->name('page.iletisim');

    /*
    Route::group(['basket'=>'xxx','as'=>'xxx.'], function(){
    });
    */

    Route::group(['prefix'=>'profile','as'=>'profile.', 'middleware'=>[ \App\Http\Middleware\RequireUserLogin::class]], function(){
        Route::get('/', [MemberController::class, 'index'])->name('index');
        Route::get('/orders', [MemberController::class, 'orders'])->name('orders');
        Route::get('/orders/{orderId}', [MemberController::class, 'orderDetail'])->name('order.detail');
        Route::get('/favorites', [MemberController::class, 'favorites'])->name('favorites');
        Route::get('/favorite/add/{productId}', [MemberController::class, 'favoriteAdd'])->name('favorite.add');
        Route::get('/favorite/remove/{productId}', [MemberController::class, 'favoriteRemove'])->name('favorite.remove');
        Route::post('/refund/add/{orderId}', [MemberController::class, 'refundAdd'])->name('refund.add');
        Route::get('/comments', [MemberController::class, 'comments'])->name('comments');
        Route::get('/informations', [MemberController::class, 'informations'])->name('informations');
        Route::get('/address', [MemberController::class, 'address'])->name('address');
        Route::get('/address/update/{addressId}', [MemberController::class, 'addressUpdate'])->name('address.update');
        Route::post('/address/save/{addressId}', [MemberController::class, 'addressSave'])->name('address.save');
        Route::get('/address/delete/{addressId}', [MemberController::class, 'addressDelete'])->name('address.delete');
    });
    Route::group(['prefix'=>'basket','as'=>'basket.'], function(){
        Route::get('/', [BasketController::class, 'index'])->name('index');
        Route::get('/add/{productId}/{colorId}/{quantity}', [BasketController::class, 'addProduct'])->name('addProduct');
        Route::get('/set/{productId}/{colorId}/{quantity}', [BasketController::class, 'setProduct'])->name('setProduct');
        Route::get('/remove/{itemcode}', [BasketController::class, 'remove'])->name('remove');
    });
    Route::group(['prefix'=>'payment','as'=>'payment.'], function(){
        Route::get('/', [PaymentController::class, 'index'])->name('index');
        Route::get('/step/{step}', [PaymentController::class, 'step'])->name('step.get');
        Route::post('/step/{step}', [PaymentController::class, 'checkStep'])->name('step.post');
        Route::post('/success', [PaymentController::class, 'validateSuccess'])->name('success');
        Route::post('/fail', [PaymentController::class, 'validateFail'])->name('fail');
        Route::get('/fail', [PaymentController::class, 'validateFail'])->name('fail');
        Route::post('/iyzico-callback', [PaymentController::class, 'iyzicoCallback'])->name('iyzico-callback');
    });
    Route::group(['prefix'=>'product','as'=>'product.'], function(){
        Route::get('/list', [ProductService::class, 'list'])->name('list');
        Route::get('/newly', [ProductService::class, 'newly'])->name('newly');
        Route::get('/bestseller', [ProductService::class, 'bestseller'])->name('bestseller');
        Route::get('/detail/{idProduct}', [ProductService::class, 'detail'])->name('detail');
        Route::get('/category/{idCategory}', [ProductService::class, 'category'])->name('category');
        Route::get('/autocomplate', [ProductService::class, 'autocomplate'])->name('autocomplate');
    });
    Route::group(['prefix'=>'member','as'=>'member.'], function () {
        Route::post('/login', [MemberService::class, 'login'])->name('index');
        Route::post('/register/bayi', [MemberService::class, 'login'])->name('bayi.register');
        Route::post('/add-newsletter', [MemberService::class, 'addNewsletter'])->name('add-newsletter');
    });

});


/*


Route::group(['prefix'=>'home','as'=>'home.', 'middleware'=>['web', \App\Http\Middleware\CheckUserLogin::class]], function () {
    Route::get('/load', [HomeService::class, 'content'])->name('load');
});
Route::group(['prefix'=>'header','as'=>'header.', 'middleware'=>['web', \App\Http\Middleware\CheckUserLogin::class]], function () {
    Route::get('/load', [HomeService::class, 'header'])->name('load');
});
Route::group(['prefix'=>'footer','as'=>'footer.', 'middleware'=>['web', \App\Http\Middleware\CheckUserLogin::class]], function () {
    Route::get('/load', [HomeService::class, 'footer'])->name('load');
});
Route::group(['prefix'=>'product','as'=>'product.', 'middleware'=>['web', \App\Http\Middleware\CheckUserLogin::class]], function () {
    Route::get('/list', [ProductService::class, 'list'])->name('list');
    Route::get('/newly', [ProductService::class, 'newly'])->name('newly');
    Route::get('/bestseller', [ProductService::class, 'bestseller'])->name('bestseller');
    Route::get('/detail/{idProduct}', [ProductService::class, 'detail'])->name('detail');
    Route::get('/category/{idCategory}', [ProductService::class, 'category'])->name('category');
    Route::get('/autocomplate', [ProductService::class, 'autocomplate'])->name('autocomplate');
});
*/
