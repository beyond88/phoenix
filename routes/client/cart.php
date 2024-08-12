<?php 

use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Client\CheckoutController;
use App\Http\Controllers\Client\ThankYouController;
use App\Http\Controllers\Client\TrackOrderController;

Route::get('cart', [CartController::class, 'index']);
Route::get('checkout', [CheckoutController::class, 'index']);
Route::get('track-order', [TrackOrderController::class, 'index']);
// Route::get('thank-you', [ThankYouController::class, 'index']);