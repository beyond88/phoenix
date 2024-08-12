<?php 

use App\Http\Controllers\Client\ProductsController;
use App\Http\Controllers\Client\ProductController;
Route::get('products', [ProductsController::class, 'index']);
Route::get('product', [ProductController::class, 'index']);