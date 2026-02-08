<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Migrate\MigrateCategoryController;
use App\Http\Controllers\Migrate\MigrateVendorController;

Route::get('get-main-categories',[MigrateCategoryController::class,'getMainCategories']);
Route::get('get-sub-categories/{hs_code}',[MigrateCategoryController::class,'getSubCategories']);

Route::get('get-vendors',[MigrateVendorController::class,'index']);
Route::get('get-products/{email}',[MigrateVendorController::class,'getProducts']);
