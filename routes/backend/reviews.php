<?php

use App\Http\Controllers\Backend\ReviewsController;

Route::get('reviews', [ReviewsController::class, 'index']);