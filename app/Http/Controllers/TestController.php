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
        $response = '{"events":[{"type":"message","replyToken":"c4a9432fc4654838962fa0703f0b4589","source":{"userId":"U1b7997d75ba52775e41438aa1d502150","type":"user"},"timestamp":1545054386101,"message":{"type":"text","id":"9023593433979","text":"test message no.4"}}],"destination":"U27c9098d14de1f99fd2f750548cc388d"}';
        // $events = json_decode($response, true);
        $events = json_decode($response);
        $type = $events->0->type;
        // print_r($events['events'][0]);
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
