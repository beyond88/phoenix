<?php 

use App\Http\Controllers\Backend\CustomersController;

Route::get('customers', [CustomersController::class, 'index']);