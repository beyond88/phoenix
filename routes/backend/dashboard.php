<?php

use App\Http\Controllers\Backend\DashboardController;

Route::get('admin', [DashboardController::class, 'index']);