<?php 

use App\Http\Controllers\Backend\ProductsController;

Route::get('products', [ProductsController::class, 'index']);