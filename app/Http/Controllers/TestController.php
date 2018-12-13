<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use DB;
use App\Role;
use Illuminate\Support\Facades\Crypt;
use App\User;

class TestController extends Controller
{
    public function list(){
        $role = Auth::user()->role();
        var_dump($role);
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
