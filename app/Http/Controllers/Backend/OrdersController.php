<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        return view('backend.orders.orders');
    }

    public function orderDetails()
    {
        return view('backend.orders.details');
    }

    public function addNewOrder()
    {
        return view('backend.orders.add-new');
    }
}
