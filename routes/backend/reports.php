<?php

use App\Http\Controllers\Backend\ReportsController;

Route::get('admin/reports', [ReportsController::class, 'index']);
Route::get('admin/reports/1', [ReportsController::class, 'reportDetails']);
Route::get('admin/reports/add', [ReportsController::class, 'addNewReport']);