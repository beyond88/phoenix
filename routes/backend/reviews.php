<?php

use App\Http\Controllers\Backend\ReviewsController;

Route::get('admin/reviews', [ReviewsController::class, 'index']);
Route::get('admin/reviews/1', [ReviewsController::class, 'reviewDetails']);
Route::get('admin/reviews/add', [ReviewsController::class, 'addNewReview']);