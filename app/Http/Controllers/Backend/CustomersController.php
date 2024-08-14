<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function index()
    {
        return view('backend.customers.customers');
    }

    public function customerDetails()
    {
        return view('backend.customers.details');
    }

    public function addNewCustomer()
    {
        return view('backend.customers.add-new');
    }
}
