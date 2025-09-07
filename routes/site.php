<?php

/**
 * @author TechVillage <support@techvill.org>
 *
 * @contributor Sakawat Hossain Rony <[sakawat.techvill@gmail.com]>
 * @contributor Al Mamun <[almamun.techvill@gmail.com]>
 *
 * @created 07-11-2021
 *
 * @modified 19-12-2021
 */

use App\Http\Controllers\LoginController;
use App\Http\Controllers\Site\AuthController;
use App\Http\Controllers\Site\QuotationController;
use App\Mail\SendOtp;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Site Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// homepage
Route::group(['middleware' => ['locale']], function () {

    Route::view('/landing', 'landing.index')->name('site.landing-page');
    Route::view('/email-template', 'emails.send-otp')->name('site.email-template');



    Route::get('/send-otp', function(){
        Mail::to('sahlowle@gmail.com')->send(new SendOtp(User::first(),1234));

        return '<h1>success</h1>';

    })->name('send.otp-test');

    Route::controller(AuthController::class)
    ->prefix('account')
    ->middleware(['guest','themeable'])
    ->group(function () {
        Route::get('login', 'showLoginForm')->name('login');
        Route::get('login', 'showLoginForm')->name('site.login');
        Route::post('login', 'login')->name('login');
        Route::get('register', 'showRegisterForm')->name('registration');
        Route::get('buyer/register', 'buyerRegisterForm')->name('buyer.register');
        Route::get('factory/register', 'factoryRegisterForm')->name('factory.register');
        Route::post('buyer/register', 'buyerRegister')->name('buyer.register');
        Route::post('factory/register', 'factoryRegister')->name('factory.register');
    });

    Route::get('/', 'SiteController@index')->name('site.index')->middleware('themeable');
    Route::post('review/pagination/fetch', 'SiteController@fetch')->name('fetch.review')->middleware('themeable');
    Route::post('change-language', 'DashboardController@switchLanguage')->middleware(['checkForDemoMode']);
    Route::match(['get', 'post'], 'change-language-for-get', 'DashboardController@switchLanguageForGet')->name('change-language')->middleware(['checkForDemoMode']);
    Route::post('change-currency', 'DashboardController@switchCurrency');

    Route::get('shops', 'SellerController@index')->name('site.shop.index')->middleware('themeable');
    Route::get('shop/{alias}', 'SellerController@showVendor')->name('site.shop')->middleware('themeable');
    Route::get('shop/profile/{alias}', 'SellerController@vendorProfile')->name('site.shop.profile')->middleware('themeable');

    // Route::get('auth', [LoginController::class, 'showLoginForm'])->middleware('themeable');
    // Route::get('auth/login', [LoginController::class, 'showLoginForm'])->name('login')->middleware('themeable');
    // Route::get('auth/registration', [LoginController::class, 'showRegisterForm'])->name('registration')->middleware('themeable');

    Route::get('/page/quotations', [QuotationController::class, 'create'])->name('site.quotations.create')->middleware('themeable');
    Route::post('/page/quotations', [QuotationController::class, 'store'])->name('site.quotations.store')->middleware('themeable');
    // login register
    // Route::get('login', 'LoginController@login');
    // Route::get('user/login', 'LoginController@login')->name('site.login');
    Route::redirect('user/login', 'login');
    Route::post('authenticate', 'LoginController@authenticate')->name('site.authenticate');
    Route::get('user-verify/{token}/{from?}', 'LoginController@verification')->name('site.verify');
    Route::get('user-verification/{otp}', 'LoginController@verifyByOtp');
    Route::post('sign-up-store', 'LoginController@signUp')->name('site.signUpStore');
    Route::get('myaccount/logout', 'LoginController@logout')->name('site.logout');
    Route::get('check-email-existence/{email}', 'LoginController@checkEmailExistence');
    Route::post('resend-verification-code', 'LoginController@resendUserVerificationCode');

    // Password reset
    Route::get('password/resets/{token}', 'LoginController@showResetForm')->name('site.password.reset');
    Route::post('password/resets', 'LoginController@setPassword')->name('site.password.resets');
    Route::post('password/email', 'LoginController@sendResetLinkEmail')->name('site.login.sendResetLink');
    Route::get('password/reset-otp/{token}', 'LoginController@resetOtp')->name('site.reset.otp');
    // Check valid mail
    Route::post('valid-mail/{mail}', 'LoginController@validMail')->name('site.valid_mail');

    // Seller register
    Route::get('seller/sign-up', 'RegisteredSellerController@showSignUpForm')->name('site.seller.signUp')->middleware('themeable');
    Route::post('seller/sign-up-store', 'RegisteredSellerController@signUp')->name('site.seller.signUpStore');
    Route::get('seller/otp', 'RegisteredSellerController@otpForm')->name('site.seller.otp')->middleware('themeable');
    Route::get('seller/resend-otp/{email?}', 'RegisteredSellerController@resendVerificationCode')->name('site.seller.resend-otp');
    Route::get('seller-verify/{token}', 'RegisteredSellerController@verification')->name('site.seller.verify');
    Route::post('seller-verify/otp', 'RegisteredSellerController@otpVerification')->name('site.seller.otpVerify');

    // Review
    Route::post('site/review/filter', 'SiteController@filterReview');
    Route::post('site/review/search', 'SellerController@searchReview');

    // product
    Route::get('products/{slug}', 'SiteController@productDetails')->name('site.productDetails')->middleware('themeable');

    // Blog
    Route::get('blogs/{value?}', 'SiteController@allBlogs')->name('blog.all')->middleware('themeable');
    Route::get('blog/search', 'SiteController@blogSearch')->name('blog.search')->middleware('themeable');
    Route::get('blog/details/{slug}', 'SiteController@blogDetails')->name('blog.details')->middleware('themeable');
    Route::get('blog-category/{id}', 'SiteController@blogCategory')->name('blog.category')->middleware('themeable');

    // Brands
    Route::get('brand/{id}/products', 'SiteController@brandProducts')->name('site.brandProducts')->middleware('themeable');

    // cart
    Route::get('carts', 'CartController@index')->name('site.cart')->middleware('themeable', 'locale');
    Route::post('cart-store', 'CartController@store')->name('site.addCart');
    Route::post('cart-reduce-qty', 'CartController@reduceQuantity')->name('site.cartReduceQuantity');
    Route::post('cart-delete', 'CartController@destroy')->name('site.delete');
    Route::post('cart-selected-delete', 'CartController@destroySelected');
    Route::post('cart-selected-store', 'CartController@storeSelected');
    Route::post('cart-all-delete', 'CartController@destroyAll');
    Route::post('cart-select-shipping', 'CartController@selectShipping');

    // Order
    Route::post('order', 'OrderController@store')->middleware(['checkGuest'])->name('site.orderStore');
    Route::get('order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm')->middleware('themeable');
    Route::get('order-paid', 'OrderController@orderPaid')->name('site.orderpaid');
    Route::post('order-get-shipping-tax', 'OrderController@getShippingTax')->name('site.orderTaxShipping');

    // Check Out
    Route::get('checkout', 'OrderController@checkOut')->middleware(['checkGuest', 'themeable'])->name('site.checkOut');

    Route::get('buynow', 'OrderController@buynow')->middleware(['checkGuest', 'themeable'])->name('site.buynow');


    // check coupon
    Route::post('check-coupon', 'CartController@checkCoupon')->name('site.checkCoupon');
    Route::post('delete-coupon', 'CartController@deleteCoupon')->name('site.deleteCoupon');

    // search
    Route::get('search-products', 'SiteController@search')->name('site.productSearch')->middleware('themeable');

    // userSearch
    Route::post('get-search-data', 'SiteController@getSearchData')->name('site.searchData');

    // compare
    Route::get('/compare', 'CompareController@index')->name('site.compare')->middleware('themeable');
    Route::post('/compare-store', 'CompareController@store')->name('site.addCompare');
    Route::post('/compare-delete', 'CompareController@destroy')->name('site.compareDestroy');

    // Track order
    Route::get('/track-order', 'OrderController@track')->name('site.trackOrder')->middleware('themeable');

    // Quick View
    Route::get('product/quick-view/{id}', 'SiteController@quickView')->name('quickView')->middleware('themeable');

    // coupon
    Route::get('/coupon', 'SiteController@coupon')->name('site.coupon')->middleware('themeable');

    // shipping
    Route::get('/get-shipping', 'SiteController@getShipping')->middleware('themeable');

    // downloadable link
    Route::get('/download', 'SiteController@download')->name('site.downloadProduct')->middleware('themeable');

    // Pages
    Route::get('page/{slug}', 'SiteController@page')->name('site.page')->middleware('themeable');

    Route::get('/get-component-product', 'SiteController@getComponentProduct')->name('ajax-product')->middleware('themeable');

    // all categories
    Route::get('/categories', 'SiteController@allCategories')->name('all.categories')->middleware('themeable');

    // payment link
    Route::get('/order/payment/{reference}', 'SiteController@orderPayment')->name('site.order.custom.payment');

    // Product search
    Route::get('products', 'ProductController@search')->name('site.product.search');
});

// login or register by google
Route::get('login/google', 'LoginController@redirectToGoogle')->name('login.google');
Route::get('login/google/callback', 'LoginController@handelGoogleCallback')->name('google');

// login or register by facebook
Route::get('login/facebook', 'LoginController@redirectToFacebook')->name('login.facebook');
Route::get('login/facebook/callback', 'LoginController@handelFacebookCallback')->name('facebook');

Route::group(['middleware' => ['site.auth', 'locale', 'permission']], function () {
    Route::post('/site/review/destroy', 'SiteController@deleteReview');
    Route::post('/site/review/update', 'SiteController@updateReview');
    // be a seller request
    Route::post('/seller/request-store', 'RegisteredSellerController@sellerRequestStore')->name('seller.store.request');
});

Route::get('/reset-data', 'ResetDataController@reset');

Route::get('guest/payment/{reference}', 'OrderController@payment')->name('site.order.payment.guest');
Route::get('guest/order-paid', 'OrderController@orderPaid')->name('site.orderpaid.guest');
Route::get('guest/order-confirm/{reference}', 'OrderController@confirmation')->name('site.orderConfirm.guest')->middleware('themeable');
Route::get('guest/invoice/print/{id}', 'OrderController@invoicePrint')->name('site.invoice.print.guest')->middleware('themeable');

Route::get('shipping/provider/{id}', 'ShippingProviderController@shippingProvider')->name('shipping.provider');
Route::get('find-shipping-providers', 'ShippingProviderController@findShippingProviders')->name('find.shipping.providers');
Route::group(['prefix' => 'myaccount', 'as' => 'site.', 'middleware' => ['site.auth', 'locale', 'permission']], function () {
    Route::get('overview', 'DashboardController@index')->name('dashboard')->middleware('themeable');
    Route::get('wishlists', 'WishlistController@index')->name('wishlist')->middleware('themeable');
    Route::get('reviews', 'ReviewController@index')->name('review')->middleware('themeable');
    Route::get('profile', 'UserController@edit')->name('userProfile')->middleware('themeable');
    Route::get('setting', 'UserController@setting')->name('userSetting')->middleware('themeable');
    Route::get('activity', 'UserController@activity')->name('userActivity')->middleware('themeable');
    Route::get('downloads', 'DownloadController@index')->name('download')->middleware('themeable');
    Route::get('addresses', 'AddressController@index')->name('address')->middleware('themeable');
    Route::get('address/create', 'AddressController@create')->name('addressCreate')->middleware('themeable');
    Route::get('address/edit/{id}', 'AddressController@edit')->name('addressEdit')->middleware('themeable');
    Route::get('orders', 'OrderController@index')->name('order')->middleware('themeable');
    Route::get('orders/{reference}', 'OrderController@orderDetails')->name('orderDetails')->middleware('themeable');
    Route::get('notifications', 'NotificationController@index')->name('notifications.index')->middleware('themeable');

    // user
    Route::post('profile/update', 'UserController@update')->middleware(['checkForDemoMode'])->name('profile.update');
    Route::post('profile/update-password', 'UserController@updatePassword')->middleware(['checkForDemoMode'])->name('password.update');
    Route::post('delete', 'UserController@destroy')->name('user.delete')->middleware(['checkForDemoMode']);
    Route::get('profile/remove-image', 'UserController@removeImage')->name('profile.delete');
    Route::get('invoice/print/{id}', 'OrderController@invoicePrint')->name('invoice.print');

    // Wishlist
    Route::post('wishlist/store', 'WishlistController@store')->name('wishlist.store');

    // Address
    Route::post('address/store', 'AddressController@store')->name('address.store');
    Route::post('address/update/{id}', 'AddressController@update')->name('address.update');
    Route::post('address/delete/{id}', 'AddressController@destroy')->name('address.delete');
    Route::post('check-default-address', 'AddressController@checkDefault');
    Route::get('make-default-address/{id}', 'AddressController@makeDefault')->name('address.set.default');

    // review
    Route::post('review-store', 'SiteController@reviewStore')->name('review.store');
    Route::post('review/delete/{id}', 'ReviewController@destroy')->name('review.destroy');

    // Notifications
    Route::delete('notifications/{id}', 'NotificationController@destroy')->name('notifications.destroy');
    Route::patch('notifications/mark-as-read/{id}', 'NotificationController@markAsRead')->name('notifications.mark_read');
    Route::patch('notifications/mark-as-unread/{id}', 'NotificationController@markAsUnread')->name('notifications.mark_unread');
    Route::get('notifications/view/{id}', 'NotificationController@view')->name('notifications.view');
});

Route::group(['middleware' => ['locale']], function () {
    Route::get('products', 'ProductController@search')->name('site.product.search')->middleware('themeable');
});

Route::get('load-web-categories', 'SiteController@loadWebCategories')->middleware('locale');
Route::get('load-mobile-categories', 'SiteController@loadMobileCategories')->middleware('locale');

Route::get('load-login-modal', 'SiteController@loadLoginModal')->middleware('locale');

Route::get('load-same-shop/{id}', 'SiteController@loadSameShop')->middleware('locale');
Route::get('load-related-products/{id}', 'SiteController@loadRelatedProducts')->middleware('locale');
Route::get('load-upsale-products/{id}', 'SiteController@loadUpSaleProducts')->middleware('locale');
