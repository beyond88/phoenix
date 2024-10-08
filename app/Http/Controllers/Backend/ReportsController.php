<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function index()
    {
        return view('backend.reports.reports');
    }

    public function reportDetails()
    {
        return view('backend.reports.details');
    }
    
    public function addNewReport()
    {
        return view('backend.reports.add-new');
    }
}
