<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReviewsController extends Controller
{
    public function index()
    {
        return view('backend.reviews.reviews');
    }

    public function reviewDetails()
    {
        return view('backend.reviews.details');
    }

    public function addNewReview()
    {
        return view('backend.reviews.add-new');
    }
}
