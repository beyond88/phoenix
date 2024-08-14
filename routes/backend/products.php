<?php 

use App\Http\Controllers\Backend\ProductsController;

Route::get('admin/products', [ProductsController::class, 'index']);
Route::get('admin/products/1', [ProductsController::class, 'productDetails']);
Route::get('admin/products/add', [ProductsController::class, 'addNewProduct']);