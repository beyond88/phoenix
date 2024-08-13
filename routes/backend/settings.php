<?php

use App\Http\Controllers\Backend\SettinsController;

Route::get('settings', [SettinsController::class, 'index']);