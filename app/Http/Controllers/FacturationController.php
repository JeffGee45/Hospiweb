<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FacturationController extends Controller
{
    public function index()
    {
        return view('facturation.index');
    }
    //
}
