<?php 

use App\Http\Controllers\Backend\OrdersController;

Route::get('admin/orders', [OrdersController::class, 'index']);
Route::get('admin/orders/1', [OrdersController::class, 'orderDetails']);
Route::get('admin/orders/add', [OrdersController::class, 'addNewOrder']);