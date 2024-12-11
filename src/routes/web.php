<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MyPageController;
use App\Http\Controllers\StripePaymentsController;
use App\Http\Controllers\PurchaseController;

//ユーザ登録
Route::get('/register', [AuthController::class, 'getRegister']);
Route::post('/register', [AuthController::class, 'postRegister']);

//ログイン
Route::get('/login', [AuthController::class, 'getLogin'])->name('login');;
Route::post('/login', [AuthController::class, 'postLogin']);
Route::get('/items/{id}', [ItemController::class, 'showDetail'])->name('items.detail');


Route::get('/', [
    RestaurantController::class,
    'index'
])->name('index');


Route::get('/complete', [StripePaymentsController::class, 'complete'])->name('complete');

Route::get('/reservation/complete', [RestaurantController::class, 'complete'])->name('reservation.complete');

Route::get('/', [ItemController::class, 'index'])->name('index');
Route::get('/', [ItemController::class, 'index'])->name('home');

Route::get('/item/search', [ItemController::class, 'search'])->name('item.search');


Route::get('/checkout', [PurchaseController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [PurchaseController::class, 'process'])->name('checkout.process');

Route::get('/address/edit', [PurchaseController::class, 'edit'])->name('address.edit');
Route::put('/address/update', [PurchaseController::class, 'update'])->name('address.update');

Route::get('/payment/edit/{item_id}', [PurchaseController::class, 'edit'])->name('payment.edit');

Route::put('/payment/update', [PurchaseController::class, 'update'])->name('payment.update');

// 購入ページ
Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');

// 購入処理
Route::post('/purchase/process', [PurchaseController::class, 'process'])->name('purchase.process');

Route::post('/purchase/complete', [PurchaseController::class, 'complete'])->name('purchase.complete');
Route::get('/purchase/success', function () {
    return view('purchase_success');
})->name('purchase.success');


Route::get('/item/create', [ItemController::class, 'itemCreate'])->name('item.create');

Route::post('/item/store', [ItemController::class, 'store'])->name('item.store');

// 住所変更ページ
Route::get('/address/edit', [MyPageController::class, 'address_index'])->name('address.edit');

Route::get('/mypage/item', [MypageController::class, 'index'])->name('mypage');

// 住所更新
Route::put('/address/update', [MyPageController::class, 'address_update'])->name('address.update');

// プロフィール編集ページ
Route::get('/profile/edit', [MyPageController::class, 'profile'])->name('profile.edit');

// プロフィール更新
Route::put('/profile/update', [MyPageController::class, 'update'])->name('profile.update');

// プロフィール更新
Route::get('/address/update', [MyPageController::class, 'address_index'])->name('address.update');

// 商品を保存
Route::post('/items', [ItemController::class, 'store'])->name('item.store');

Route::get('/item/detail/{id}', [ItemController::class, 'showDetail'])->name('items.detail');

Route::post('/item/detail/store', [ItemController::class, 'review_store'])->name('reviews.store');

Route::post('/favorites/toggle', [ItemController::class, 'favoriteToggle'])->name('favorites.toggle');




Route::get('/register/complete', function () {
    return view('register_complete');
})->name('register.complete');

Route::get('/reservation/complete', function () {
    return view('reservation_complete');
});

Route::get('/restaurants', [RestaurantController::class, 'index'])->name('restaurants.index');

Route::middleware(['auth', 'verified'])->group(function () {

    Route::post('/admin/sendMailToAll', [MailController::class, 'sendMailToAll'])->name('admin.sendMailToAll');


    Route::post('/admin/sendMail', [MailController::class, 'sendMail'])->name('admin.sendMail');

    Route::post('/payment/index', [StripePaymentsController::class, 'index'])->name('paymentindex');
    Route::post('/payment', [StripePaymentsController::class, 'payment'])->name('payment.store');




    Route::get('/reservations/verify/{id}', [RestaurantController::class, 'verify'])->name('reservation.verify');

    Route::get('/qrtest/{id}', [RestaurantController::class, 'generateQrCode']);
    Route::get('/reservations/{id}/qrcode', [RestaurantController::class, 'showQrCode'])->name('reservation.qrcode');


    Route::post('/favorite', [RestaurantController::class, 'favorite'])->name('favorite.store');

    Route::post('/reservations/{id}/delete', [MyPageController::class, 'destroy'])->name('reservations.destroy');

    Route::post('/restaurants/{id}/favorite', [RestaurantController::class, 'favorite']);

    Route::post('/restaurants/{id}/unfavorite', [RestaurantController::class, 'favorite'])->name('restaurants.favorite');
    Route::post('/restaurants/{id}/unfavorite', [RestaurantController::class, 'unfavorite'])->name('restaurants.unfavorite');

    Route::post('/reservations', [RestaurantController::class, 'store'])->name('reservation.store');

    Route::post('/restaurants/{id}/rate', [RestaurantController::class, 'rate'])->name('restaurant.rate');


    Route::get('/reservations/{id}/edit', [RestaurantController::class, 'edit'])->name('reservation.edit');
    Route::put('/reservations/{id}', [RestaurantController::class, 'update'])->name('reservation.update');
    Route::get('/reservations', [RestaurantController::class, 'index'])->name('reservations.index');

    //ログイン
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage.index');
});

require __DIR__ . '/auth.php';
require __DIR__ . '/owner.php';
require __DIR__ . '/admin.php';
