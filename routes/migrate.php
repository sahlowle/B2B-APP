<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Migrate\MigrateCategoryController;

Route::get('get-main-categories',[MigrateCategoryController::class,'getMainCategories']);
Route::get('get-sub-categories/{hs_code}',[MigrateCategoryController::class,'getSubCategories']);
