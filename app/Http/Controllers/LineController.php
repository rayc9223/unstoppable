<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index(Request $request)
    {
        file_put_contents('logs.txt', $request->all());
    }
}
