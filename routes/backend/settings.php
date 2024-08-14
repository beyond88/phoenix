<?php

use App\Http\Controllers\Backend\SettinsController;

Route::get('admin/settings', [SettinsController::class, 'index']);