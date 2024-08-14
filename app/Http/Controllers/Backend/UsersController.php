<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index()
    {
        return view('backend.users.users');
    }

    public function userDetails()
    {
        return view('backend.users.details');
    }

    public function addNewUser()
    {
        return view('backend.users.add-new');
    }
}
