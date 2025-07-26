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

Route::group(['prefix' => 'admin/inventory', 'namespace' => 'Modules\Inventory\Http\Controllers', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {

    //Inventory
    Route::get('/', 'InventoryController@index')->name('inventory.index');
    Route::match(['get', 'post'], '/adjust', 'InventoryController@adjust')->name('inventory.adjust');

    //location
    Route::get('/location', 'LocationController@index')->name('location.index');
    Route::get('/location/edit/{id}', 'LocationController@edit')->name('location.edit');
    Route::get('/location/create', 'LocationController@create')->name('location.create');
    Route::post('/location/store', 'LocationController@store')->name('location.store');
    Route::post('/location/update/{id}', 'LocationController@update')->name('location.update');
    Route::post('/location/delete/{id}', 'LocationController@destroy')->name('location.destroy');

    Route::get('/vendor-location', 'LocationController@vendorLocation')->name('vendorLocation.index');

    //supplier
    Route::get('/supplier', 'SupplierController@index')->name('supplier.index');
    Route::get('/supplier/edit/{id}', 'SupplierController@edit')->name('supplier.edit');
    Route::get('/supplier/create', 'SupplierController@create')->name('supplier.create');
    Route::post('/supplier/store', 'SupplierController@store')->name('supplier.store');
    Route::post('/supplier/update/{id}', 'SupplierController@update')->name('supplier.update');
    Route::post('/supplier/delete/{id}', 'SupplierController@destroy')->name('supplier.destroy');

    //purchase
    Route::get('/purchase-order', 'PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/edit/{id}', 'PurchaseController@edit')->name('purchase.edit');
    Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/store', 'PurchaseController@store')->name('purchase.store');
    Route::post('/purchase/update/{id}', 'PurchaseController@update')->name('purchase.update');
    Route::post('/purchase/delete/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::post('/purchase/product-search', 'PurchaseController@search')->name('purchase.search');
    Route::get('/purchase/receive/{id}', 'PurchaseController@receive')->name('purchase.receive');
    Route::post('/purchase/receive-store/{id}', 'PurchaseController@receiveStore')->name('purchase.receiveStore');

    Route::get('/find-supplier-with-ajax', 'PurchaseController@findSupplier')->name('purchase.findSupplier');
    Route::get('/find-location-with-ajax', 'PurchaseController@findLocation')->name('purchase.findLocation');
    Route::get('/find-vendor-with-ajax', 'PurchaseController@findVendor')->name('purchase.findVendor');

    //Transaction
    Route::get('/transaction', 'InventoryController@transaction')->name('inventory.transaction');

    // Settings
    Route::match(['get', 'post'], '/settings', 'InventoryController@settings')->name('inventory.settings');

    //Transfer
    Route::get('/transfer', 'TransferController@index')->name('transfer.index');
    Route::get('/transfer/edit/{id}', 'TransferController@edit')->name('transfer.edit');
    Route::get('/transfer/create', 'TransferController@create')->name('transfer.create');
    Route::post('/transfer/store', 'TransferController@store')->name('transfer.store');
    Route::post('/transfer/update/{id}', 'TransferController@update')->name('transfer.update');
    Route::post('/transfer/delete/{id}', 'TransferController@destroy')->name('transfer.destroy');
    Route::post('/transfer/product-search', 'TransferController@search')->name('transfer.search');
    Route::get('/transfer/receive/{id}', 'TransferController@receive')->name('transfer.receive');
    Route::post('/transfer/receive-store/{id}', 'TransferController@receiveStore')->name('transfer.receiveStore');
});

Route::group(['prefix' => 'vendor/inventory', 'as' => 'vendor.', 'namespace' => 'Modules\Inventory\Http\Controllers\Vendor', 'middleware' => ['auth', 'locale', 'permission', 'web']], function () {

    //location
    Route::get('/location', 'LocationController@index')->name('location.index');
    Route::get('/location/edit/{id}', 'LocationController@edit')->name('location.edit');
    Route::get('/location/create', 'LocationController@create')->name('location.create');
    Route::post('/location/store', 'LocationController@store')->name('location.store');
    Route::post('/location/update/{id}', 'LocationController@update')->name('location.update');
    Route::post('/location/delete/{id}', 'LocationController@destroy')->name('location.destroy');

    Route::get('/vendor-location', 'LocationController@vendorLocation')->name('vendorLocation.index');

    //supplier
    Route::get('/supplier', 'SupplierController@index')->name('supplier.index');
    Route::get('/supplier/edit/{id}', 'SupplierController@edit')->name('supplier.edit');
    Route::get('/supplier/create', 'SupplierController@create')->name('supplier.create');
    Route::post('/supplier/store', 'SupplierController@store')->name('supplier.store');
    Route::post('/supplier/update/{id}', 'SupplierController@update')->name('supplier.update');
    Route::post('/supplier/delete/{id}', 'SupplierController@destroy')->name('supplier.destroy');

    //purchase
    Route::get('/purchase-order', 'PurchaseController@index')->name('purchase.index');
    Route::get('/purchase/edit/{id}', 'PurchaseController@edit')->name('purchase.edit');
    Route::get('/purchase/create', 'PurchaseController@create')->name('purchase.create');
    Route::post('/purchase/store', 'PurchaseController@store')->name('purchase.store');
    Route::post('/purchase/update/{id}', 'PurchaseController@update')->name('purchase.update');
    Route::post('/purchase/delete/{id}', 'PurchaseController@destroy')->name('purchase.destroy');
    Route::post('/purchase/product-search', 'PurchaseController@search')->name('purchase.search');
    Route::get('/purchase/receive/{id}', 'PurchaseController@receive')->name('purchase.receive');
    Route::post('/purchase/receive-store/{id}', 'PurchaseController@receiveStore')->name('purchase.receiveStore');

    Route::get('/find-supplier-with-ajax', 'PurchaseController@findSupplier')->name('purchase.findSupplier');
    Route::get('/find-location-with-ajax', 'PurchaseController@findLocation')->name('purchase.findLocation');

    //Inventory
    Route::get('/', 'InventoryController@index')->name('inventory.index');
    Route::match(['get', 'post'], '/adjust', 'InventoryController@adjust')->name('inventory.adjust');

    //Transaction
    Route::get('/transaction', 'InventoryController@transaction')->name('inventory.transaction');

    //Transfer
    Route::get('/transfer', 'TransferController@index')->name('transfer.index');
    Route::get('/transfer/edit/{id}', 'TransferController@edit')->name('transfer.edit');
    Route::get('/transfer/create', 'TransferController@create')->name('transfer.create');
    Route::post('/transfer/store', 'TransferController@store')->name('transfer.store');
    Route::post('/transfer/update/{id}', 'TransferController@update')->name('transfer.update');
    Route::post('/transfer/delete/{id}', 'TransferController@destroy')->name('transfer.destroy');
    Route::post('/transfer/product-search', 'TransferController@search')->name('transfer.search');
    Route::get('/transfer/receive/{id}', 'TransferController@receive')->name('transfer.receive');
    Route::post('/transfer/receive-store/{id}', 'TransferController@receiveStore')->name('transfer.receiveStore');

});
