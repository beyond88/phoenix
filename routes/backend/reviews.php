<?php

use App\Http\Controllers\Backend\ReviewsController;

Route::get('admin/productsreviews', [ReviewsController::class, 'index']);
Route::get('admin/products/reviews/1', [ReviewsController::class, 'reviewDetails']);
Route::get('admin/products/reviews/add', [ReviewsController::class, 'addNewReview']);