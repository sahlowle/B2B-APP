<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Migrate\MigrateCategoryController;

Route::get('get-main-categories',[MigrateCategoryController::class,'getMainCategories']);
