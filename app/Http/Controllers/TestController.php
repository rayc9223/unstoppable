<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use Illuminate\Support\Facades\Crypt;
use App\User;

class TestController extends Controller
{
    public function list(){
        dd(Auth::user()->isAdmin());
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
