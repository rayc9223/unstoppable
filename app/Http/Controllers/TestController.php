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
        $roles = User::find(1)->roles()->first();
        // foreach ($roles as $role) {
        //     if ($role->role == 'admin') {
        //         echo 'true';
        //     } else {
        //         echo 'false';
        //     }
        // }
        echo $roles->role;
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
