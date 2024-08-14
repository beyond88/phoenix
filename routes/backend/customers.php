<?php 

use App\Http\Controllers\Backend\CustomersController;

Route::get('admin/customers', [CustomersController::class, 'index']);
Route::get('admin/customers/1', [CustomersController::class, 'customerDetails']);
Route::get('admin/customers/add', [CustomersController::class, 'addNewCustomer']);