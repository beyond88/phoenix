<?php

use App\Http\Controllers\Backend\Settings\Ecom\SettingsController;

Route::get('admin/settings/ecommerce', [SettingsController::class, 'index']);