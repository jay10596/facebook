<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct()
    {
        //Use middleware('auth') for default laravel authentication.
        $this->middleware('api');
    }

    public function index()
    {
        return view('home');
    }
}
