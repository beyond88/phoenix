<?php 

use App\Http\Controllers\Backend\PostsController;

Route::get('admin/posts', [PostsController::class, 'index']);
Route::get('admin/posts/1', [PostsController::class, 'postDetails']);
Route::get('admin/posts/add', [PostsController::class, 'addNewPost']);