<?php 

use App\Http\Controllers\Backend\PostsController;

Route::get('admin/posts/categories', [PostsController::class, 'categories']);
Route::get('admin/posts', [PostsController::class, 'index']);
Route::get('admin/posts/add', [PostsController::class, 'addNewPost']);
Route::get('admin/posts/{id}', [PostsController::class, 'postDetails']);
Route::get('admin/posts/tags', [PostsController::class, 'tags']);