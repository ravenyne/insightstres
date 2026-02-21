<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BreathingController extends Controller
{
    public function index()
    {
        return view('user.breathing');
    }
}
