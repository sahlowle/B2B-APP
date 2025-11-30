<?php

use Modules\Moyasar\Http\Controllers\MoyasarController;
use Illuminate\Support\Facades\Route;

Route::any('/save-card-webhook/{user}', [MoyasarController::class, 'saveCardWebHook'])->name('moyasar.save-card-webhook');