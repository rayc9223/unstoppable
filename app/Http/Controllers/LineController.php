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
        Log::info(json_encode($request->all()));
        $type = $request->get('type');
        $replyToken = $request->get('replyToken');
        $userId = $request->get('userId');
        if ($type == 'message') {
            $message = $request->get('message');
        }
        Log::info('Type: '. $type);
        Log::info('replyToken: '. $replyToken);
        Log::info('userId: '. $userId);
        Log::info(json_encode('message: '. $message));
        // Log::info(json_encode($event['events']['replyToken']));

    }

//     [2018-12-17 13:22:34] local.INFO: {"events":[{"replyToken":"00000000000000000000000000000000","type":"message","timestamp":1545053246198,"source":{"type":"user","userId":"Udeadbeefdeadbeefdeadbeefdeadbeef"},"message":{"id":"100001","type":"text","text":"Hello, world"}},{"replyToken":"ffffffffffffffffffffffffffffffff","type":"message","timestamp":1545053246198,"source":{"type":"user","userId":"Udeadbeefdeadbeefdeadbeefdeadbeef"},"message":{"id":"100002","type":"sticker","packageId":"1","stickerId":"1"}}]}  

// [2018-12-17 13:22:56] local.INFO: {"events":[{"type":"follow","replyToken":"d68a1293fffb484593837bcdf162173f","source":{"userId":"U1b7997d75ba52775e41438aa1d502150","type":"user"},"timestamp":1545053267719}],"destination":"U27c9098d14de1f99fd2f750548cc388d"}  

// [2018-12-17 13:22:58] local.INFO: {"events":[{"type":"unfollow","source":{"userId":"U1b7997d75ba52775e41438aa1d502150","type":"user"},"timestamp":1545053269958}],"destination":"U27c9098d14de1f99fd2f750548cc388d"}  

// [2018-12-17 13:26:54] local.INFO: {"events":[
//     {
//         "type":"message",
//         "replyToken":"f89bc63504bb45cda0aac51ab9a667c2",
//         "source":{
//             "userId":"U1b7997d75ba52775e41438aa1d502150",
//             "type":"user"
//         },
//         "timestamp":1545053506139,
//         "message":{
//             "type":"text",
//             "id":"9023507402074",
//             "text":"test message no.1"
//         }}],
//         "destination":"U27c9098d14de1f99fd2f750548cc388d"
//     }

}
