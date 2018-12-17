<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LineController extends Controller
{
    public function index(Request $request)
    {
        // http_response_code(200);
        // file_put_contents('logs.txt', $request->all());
    }

    public function lineEvent(Request $request)
    {
        file_put_contents('/usr/local/nginx/html/unstoppable/logs.txt', $request->all(), FILE_APPEND);
    }
}
