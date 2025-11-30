<?php

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

Route::group(['prefix' => 'admin', 'namespace' => 'Modules\Subscription\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    // Package
    Route::get('packages', 'PackageController@index')->name('package.index');
    Route::get('packages/create', 'PackageController@create')->name('package.create');
    Route::post('packages', 'PackageController@store')->name('package.store');
    Route::get('packages/{id}', 'PackageController@show')->name('package.show');
    Route::get('packages/{id}/edit', 'PackageController@edit')->name('package.edit');
    Route::put('packages/{id}', 'PackageController@update')->name('package.update');
    Route::delete('packages/{id}', 'PackageController@destroy')->name('package.destroy');

    Route::get('package/get-info/{id}', 'PackageController@getInfo');

    Route::get('package/generate-link/show/{id}', 'PackageController@generateLinkIndex')->name('package.generate.link.index');
    Route::post('package/generate-link', 'PackageController@generateLink')->name('package.generate.link');
    Route::get('package/generate-link/{id}', 'PackageController@getGenerateLink')->name('package.generate.link.get');
    Route::delete('packages/generate-link/{id}', 'PackageController@destroyLink')->middleware(['checkForDemoMode'])->name('package.destroy.link');

    // Package Subscription
    Route::get('package/subscriptions', 'PackageSubscriptionController@index')->name('package.subscription.index');
    Route::get('package/subscriptions/create', 'PackageSubscriptionController@create')->name('package.subscription.create');
    Route::post('package/subscriptions', 'PackageSubscriptionController@store')->name('package.subscription.store');
    Route::get('package/subscriptions/{id}', 'PackageSubscriptionController@show')->name('package.subscription.show');
    Route::get('package/subscriptions/{id}/edit', 'PackageSubscriptionController@edit')->name('package.subscription.edit');
    Route::put('package/subscriptions/{id}', 'PackageSubscriptionController@update')->name('package.subscription.update');
    Route::delete('package/subscriptions/{id}', 'PackageSubscriptionController@destroy')->name('package.subscription.destroy');
    Route::match(['get', 'post'], 'subscriptions/settings', 'PackageSubscriptionController@setting')->name('package.subscription.setting');

    Route::get('payments', 'PackageSubscriptionController@payment')->name('package.subscription.payment');
    Route::put('payments/{id}/paid', 'PackageSubscriptionController@paid')->name('payment.paid');

    Route::get('package/subscription/{id}/invoice', 'PackageSubscriptionController@invoice')->name('package.subscription.invoice');
    Route::get('package/subscription/{id}/invoice/pdf', 'PackageSubscriptionController@invoicePdf')->name('package.subscription.invoice.pdf');
    Route::get('package/subscription/{id}/invoice/email', 'PackageSubscriptionController@invoiceEmail')->name('package.subscription.invoice.email');

    Route::post('package-subscriptions/notification', 'PackageSubscriptionController@notification')->name('package.subscription.notification');
    
    Route::post('/subscription-verify', 'SubscriptionVerifyController@verify')->name('subscription.verify');
});

Route::group(['prefix' => 'vendor', 'namespace' => 'Modules\Subscription\Http\Controllers\Vendor', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {
    // Vendor Subscription
    Route::get('/subscription', 'SubscriptionController@index')->name('vendor.subscription.index');
    Route::post('subscription/store', 'SubscriptionController@store')->name('vendor.subscription.store');
    Route::post('subscription/add-card', 'SubscriptionController@addCard')->name('vendor.subscription.add-card');
    Route::get('subscription/paid', 'SubscriptionController@paid')->name('vendor.subscription.paid');
    Route::get('subscription/history', 'SubscriptionController@history')->name('vendor.subscription.history');
    Route::get('subscription/history/invoice/{id}', 'SubscriptionController@invoice')->name('vendor.subscription.invoice');
    Route::get('subscription/history/invoice/pdf/{id}', 'SubscriptionController@pdfInvoice')->name('vendor.subscription.invoice.pdf');
    Route::get('subscription/cancel/{user_id}', 'SubscriptionController@cancel')->name('vendor.subscription.cancel');
    Route::get('subscription/private-plan/{link}', 'SubscriptionController@privatePlan')->name('vendor.private-plan');
});
