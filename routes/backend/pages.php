<?php 

use App\Http\Controllers\Backend\PagesController;

Route::get('admin/pages', [PagesController::class, 'index']);
Route::get('admin/pages/add', [PagesController::class, 'addNewPage']);
Route::get('admin/pages/{id}', [PagesController::class, 'pageDetails']);