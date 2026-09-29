<?php

use App\Http\Controllers\MobileAppController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Mobile App Customer Routes
|--------------------------------------------------------------------------
*/

// Catalog & Home
Route::get('/', [MobileAppController::class, 'index'])->name('mobile.home');

// Checkout Submission
Route::post('/checkout', [MobileAppController::class, 'submitOrder'])->name('mobile.checkout');

// Order Placed Success
Route::get('/order-success/{orderNumber}', [MobileAppController::class, 'success'])->name('mobile.success');

// Order Tracking
Route::match(['get', 'post'], '/track', [MobileAppController::class, 'track'])->name('mobile.track');
