<?php
namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ThankYouController extends Controller
{
    public function index()
    {
        return view('client.thank-you');
    }
}
