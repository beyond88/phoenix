<?php

use App\Http\Controllers\Backend\MediaController;
use App\Livewire\Media\AddNew;

Route::get('admin/media', [MediaController::class, 'index']);
Route::get('admin/media/add', [MediaController::class, 'addNew']);
Route::get('admin/media/download/{id}', [MediaController::class, 'downloadMedia'])->name('media.download');
Route::post('admin/media/upload', [MediaController::class, 'uploadNewMedia']);
