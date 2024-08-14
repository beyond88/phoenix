<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    public function index()
    {
        return view('backend.pages.pages');
    }

    public function pageDetails()
    {
        return view('backend.pages.details');
    }

    public function addNewPage()
    {
        return view('backend.pages.add-new');
    }
}
