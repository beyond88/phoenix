<?php 

use App\Http\Controllers\Backend\PagesController;

Route::get('admin/pages', [PagesController::class, 'index']);
Route::get('admin/pages/1', [PagesController::class, 'pageDetails']);
Route::get('admin/pages/add', [PagesController::class, 'addNewPage']);