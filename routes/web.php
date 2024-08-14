<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;

require __DIR__.'/backend/dashboard.php';
require __DIR__.'/backend/customers.php';
require __DIR__.'/backend/products.php';
require __DIR__.'/backend/orders.php';
require __DIR__.'/backend/reports.php';
require __DIR__.'/backend/reviews.php';
require __DIR__.'/backend/settings.php';

require __DIR__.'/client/home.php';
require __DIR__.'/client/product.php';
require __DIR__.'/client/cart.php';
require __DIR__.'/client/my-account.php';
require __DIR__.'/client/auth.php';


Route::prefix('media')->group(function () {
    Route::get('library', [MediaController::class, 'index'])->name('media.library');
    Route::get('create', [MediaController::class, 'create'])->name('media.create');
    Route::post('store', [MediaController::class, 'store'])->name('media.store');
});
