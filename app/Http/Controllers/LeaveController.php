<?php

namespace App\Http\Controllers;

use App\Leave;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function leaveRecord(){
        $records = Leave::orderBy('call_leave_time', 'DESC')->get();
        return view('leave_record', ['records'=>$records]);
    }
}
