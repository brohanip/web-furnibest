<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PageController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MidtransWebhookController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\HomePromoController as AdminHomePromoController;
use App\Http\Controllers\Admin\HomeHeroController as AdminHomeHeroController;
use App\Http\Controllers\Admin\AboutController as AdminAboutController;
use App\Http\Controllers\Admin\MaterialController as AdminMaterialController;
use App\Http\Controllers\Admin\ColorSampleController as AdminColorSampleController;
use App\Http\Controllers\Admin\BankAccountController as AdminBankAccountController;
use App\Http\Controllers\Admin\BrandingController as AdminBrandingController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/produk', [PageController::class, 'products'])->name('products');
Route::get('/produk/{product:slug}', [PageController::class, 'productShow'])->name('products.show');

Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
Route::post('/keranjang', [CartController::class, 'store'])->name('cart.store');
Route::patch('/keranjang/{product:slug}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/keranjang/{product:slug}', [CartController::class, 'destroy'])->name('cart.destroy');

Route::post('/payment/midtrans/notification', [MidtransWebhookController::class, 'handle'])->name('payment.midtrans');

Route::middleware('guest')->group(function () {
    Route::get('/masuk', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/masuk', [LoginController::class, 'login']);
    Route::get('/daftar', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/daftar', [RegisterController::class, 'register']);
});

Route::post('/keluar', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

Route::middleware('auth')->group(function () {
    Route::get('/keranjang/checkout', [CheckoutController::class, 'createFromCart'])->name('checkout.cart');
    Route::get('/produk/{product:slug}/checkout', [CheckoutController::class, 'create'])->name('checkout.create');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/pesanan/{order:order_number}/transfer', [CheckoutController::class, 'transfer'])->name('checkout.transfer');
    Route::post('/pesanan/{order:order_number}/transfer', [CheckoutController::class, 'confirmTransfer'])->name('checkout.transfer.confirm');
    Route::get('/pesanan/{order:order_number}/bayar', [CheckoutController::class, 'pay'])->name('checkout.pay');
    Route::post('/pesanan/{order:order_number}/simulasi-bayar', [CheckoutController::class, 'simulatePay'])->name('checkout.simulate-pay');
    Route::get('/pesanan/{order:order_number}/selesai', [CheckoutController::class, 'finish'])->name('checkout.finish');
    Route::get('/pesanan/{order:order_number}', [CheckoutController::class, 'show'])->name('checkout.show');
    Route::get('/pesanan-saya', [CheckoutController::class, 'myOrders'])->name('orders.mine');
});

Route::get('/tentang-kami', [PageController::class, 'about'])->name('about');
Route::get('/kontak', [PageController::class, 'contact'])->name('contact');

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    Route::resource('products', AdminProductController::class)->except(['show']);
    Route::get('branding', [AdminBrandingController::class, 'edit'])->name('branding.edit');
    Route::put('branding', [AdminBrandingController::class, 'update'])->name('branding.update');
    Route::put('branding/hero', [AdminBrandingController::class, 'updateHero'])->name('branding.hero');
    Route::put('branding/promo', [AdminBrandingController::class, 'updatePromo'])->name('branding.promo');
    Route::put('branding/about', [AdminBrandingController::class, 'updateAbout'])->name('branding.about');
    Route::get('home-promo', [AdminHomePromoController::class, 'edit'])->name('home-promo.edit');
    Route::put('home-promo', [AdminHomePromoController::class, 'update'])->name('home-promo.update');
    Route::get('home-hero', [AdminHomeHeroController::class, 'edit'])->name('home-hero.edit');
    Route::put('home-hero', [AdminHomeHeroController::class, 'update'])->name('home-hero.update');
    Route::get('about', [AdminAboutController::class, 'edit'])->name('about.edit');
    Route::put('about', [AdminAboutController::class, 'update'])->name('about.update');
    Route::resource('materials', AdminMaterialController::class)->except(['show']);
    Route::resource('color-samples', AdminColorSampleController::class)->except(['show']);
    Route::resource('bank-accounts', AdminBankAccountController::class)->except(['show']);
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order:order_number}', [AdminOrderController::class, 'show'])->name('orders.show');
    Route::post('orders/{order:order_number}/confirm-payment', [AdminOrderController::class, 'confirmPayment'])->name('orders.confirm-payment');
});
