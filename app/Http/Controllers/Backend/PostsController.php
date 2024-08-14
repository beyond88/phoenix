<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostsController extends Controller
{

    public function index()
    {
        return view('backend.posts.posts');
    }

    public function postDetails()
    {
        return view('backend.posts.details');
    }

    public function addNewPost()
    {
        return view('backend.posts.add-new');
    }

    public function categories()
    {
        return view('backend.posts.categories');
    }

    public function tags()
    {
        return view('backend.posts.tags');
    }
}
