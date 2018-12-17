<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    public function index(Request $request)
    {
        http_response_code(200);
        // file_put_contents('logs.txt', $request->all());
    }
}
