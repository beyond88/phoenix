<?php 

use App\Http\Controllers\Client\ProductsController;
Route::get('product', [ProductsController::class, 'index']);