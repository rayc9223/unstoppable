<?php

namespace App\Http\Controllers;

use App\Leave;
use App\User;
use Illuminate\Http\Request;

class LeaveController extends Controller
{
    public function leaveRecord(){
        $members = User::select('lineid', 'gameid')->where('guild', '無與倫比')->orderBy('capability', 'DESC')->get();
        $records = Leave::orderBy('call_leave_time', 'DESC')->get();
        return view('leave_record', ['records'=>$records, 'members'=>$members]);
    }

    public function filterByLineId(Request $request)
    {
        if ($request->lineid == '') {
            $this->leaveRecord();
        }
        $members = User::select('lineid', 'gameid')->where('guild', '無與倫比')->orderBy('capability', 'DESC')->get();
        $records = Leave::where('gameid', $request->gameid)->orderBy('call_leave_time', 'DESC')->get();
        return view('leave_record', ['records'=>$records, 'members'=>$members]);
    }
}
