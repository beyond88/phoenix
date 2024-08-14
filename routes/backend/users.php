<?php 

use App\Http\Controllers\Backend\UsersController;

Route::get('admin/users', [UsersController::class, 'index']);
Route::get('admin/users/1', [UsersController::class, 'userDetails']);
Route::get('admin/users/add', [UsersController::class, 'addNewUser']);