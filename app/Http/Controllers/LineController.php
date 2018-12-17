<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class LineController extends Controller
{
    public function index(Request $request)
    {
        // http_response_code(200);
        // file_put_contents('logs.txt', $request->all());
    }

    public function lineEvent(Request $request)
    {
        Log::info(json_encode($request->all());
    }
}
