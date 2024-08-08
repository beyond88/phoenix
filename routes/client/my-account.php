<?php
use App\Http\Controllers\Client\MyAccountController;

Route::get('/my-account', [MyAccountController::class, 'index']);