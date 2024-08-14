<?php 

use App\Http\Controllers\Backend\MediaController;

Route::get('admin/media', [MediaController::class, 'index']);
Route::get('admin/media/1', [MediaController::class, 'orderDetails']);
Route::get('admin/media/add', [MediaController::class, 'addNewMedia']);