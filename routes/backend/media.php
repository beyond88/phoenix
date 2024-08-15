<?php

use App\Http\Controllers\Backend\MediaController;

Route::get('admin/library', [MediaController::class, 'index']);
Route::get('admin/create', [MediaController::class, 'mediaCreate']);
Route::get('admin/store', [MediaController::class, 'store']);

// Route::prefix('media')->name('media.')->group(function () {
    // Route::get('/', [MediaController::class, 'index'])->name('index');
    // Route::get('create', [MediaController::class, 'create'])->name('create');
    // Route::post('store', [MediaController::class, 'store'])->name('store');
    // Route::get('{id}', [MediaController::class, 'show'])->name('show');
    // Route::delete('{id}', [MediaController::class, 'destroy'])->name('destroy');
// });
