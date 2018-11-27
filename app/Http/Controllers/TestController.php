<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Crypt;

class TestController extends Controller
{
    public function list(){
        
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
