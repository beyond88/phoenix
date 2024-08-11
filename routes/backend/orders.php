<?php 

use App\Http\Controllers\Backend\OrdersController;

Route::get('orders', [OrdersController::class, 'index']);