<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class TestController extends Controller
{
    public function list(){
        $users = DB::table('users')->get();
        return view('test', ['users'=>$users]);
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
