<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MediaController extends Controller
{
    public function index()
    {
        return view('backend.media.media');
    }

    public function mediaDetails()
    {
        return view('backend.media.details');
    }

    public function addNewMedia()
    {
        return view('backend.media.add-new');
    }
}
