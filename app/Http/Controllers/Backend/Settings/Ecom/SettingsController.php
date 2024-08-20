<?php

namespace App\Http\Controllers\Backend\Settings\Ecom;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        return view('backend.settings.ecommerce');
    }
}
