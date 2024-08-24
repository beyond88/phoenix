<?php

use App\Http\Controllers\Backend\MediaController;
use App\Livewire\Media\AddNew;

Route::get('admin/media', [MediaController::class, 'index']);
Route::get('admin/media/add', [MediaController::class, 'addNew']);
Route::post('admin/media/upload', [MediaController::class, 'uploadNewMedia']);
// Route::post('admin/media/upload', AddNew::class);
