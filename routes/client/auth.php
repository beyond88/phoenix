<?php 

use App\Http\Controllers\Client\Auth\SignInController;
use App\Http\Controllers\Client\Auth\SignUpController;
use App\Http\Controllers\Client\Auth\ResetPasswordController;
use App\Http\Controllers\Client\Auth\ForgotPasswordController;

Route::get('login', [SignInController::class, 'index']);
Route::get('register', [SignUpController::class, 'index']);
Route::get('reset-password', [ResetPasswordController::class, 'index']);
Route::get('forgot-password', [ForgotPasswordController::class, 'index']);