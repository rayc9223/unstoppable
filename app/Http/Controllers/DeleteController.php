<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Auth;

class DeleteController extends Controller
{
    public function showList()
    {
        if (!Auth::user() || Auth::user()->uid != 27) {
            return redirect('capability');
        }
        $users = User::select('uid', 'gameid')->where('uid', '<>', 27)->get();
        return view('choose_delete', ['users'=>$users]);
    }

    public function deleteConfirm(Request $request)
    {
        if (!$request->filled('uid')) {
            return back()->withInput($request->input());
        }
        User::find($request->uid)->forceDelete();
        return redirect('deleted');
    }

    public function deleted()
    {
        return view('deleted');
    }
}
