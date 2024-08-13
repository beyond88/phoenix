<?php

use App\Http\Controllers\Backend\ReportsController;

Route::get('reports', [ReportsController::class, 'index']);