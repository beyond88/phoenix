<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function index()
    {
        return view('backend.products.products');
    }

    public function productDetails()
    {
        return view('backend.products.details');
    }

    public function addNewProduct()
    {
        return view('backend.products.add-new');
    }
}
