<?php 

use App\Http\Controllers\Backend\CustomersController;

Route::get('admin/orders/customers', [CustomersController::class, 'index']);
Route::get('admin/orders/customers/1', [CustomersController::class, 'customerDetails']);
Route::get('admin/orders/customers/add', [CustomersController::class, 'addNewCustomer']);