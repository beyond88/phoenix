<?php
use App\Http\Controllers\Client\MyAccountController;
use App\Http\Controllers\Client\WishlistController;

Route::get('my-account', [MyAccountController::class, 'index']);
Route::get('my-account/wishlist', [WishlistController::class, 'index']);