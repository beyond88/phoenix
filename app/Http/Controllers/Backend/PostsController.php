<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        return view('backend.posts.orders');
    }

    public function orderDetails()
    {
        return view('backend.posts.details');
    }

    public function addNewOrder()
    {
        return view('backend.posts.add-new');
    }
}
