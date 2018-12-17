<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use \LINE\LINEBot\HTTPClient\CurlHTTPClient;
use \LINE\LINEBot;
use GuzzleHttp\Client;
use App\User;

class LineController extends Controller
{
    public function lineEvent(Request $request)
    {
        $lineApi = DB::table('credentials')->select('username as access_token', 'password as secret')->where('description', 'line_api')->first();
        $accessToken = $lineApi->access_token;
        $secret = $lineApi->secret;
        $client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($accessToken);
        $bot = new \LINE\LINEBot($client, ['channelSecret' => $secret]);

        Log::info(json_encode($request->all()));
        $events = $request->all();
        $filtered = $events['events'][0];
        $type = $filtered['type'];
        $replyToken = $filtered['replyToken'];
        $userId = $filtered['source']['userId'];

        if ($type == 'message') {
            $message = $filtered['message'];
            $msgType = $message['type'];
            $msgText = $message['text'];
            Log::info(json_encode($message));

            switch ($msgText) {
                case 'push':
                    $data = array();

                    // Use array when more than one addressee
                    $data['to'] = $userId;
                    $data['messages'] = array(array('type'=>'text', 'text'=>'Push Notification test'));
                    // $response = $this->buildPostRequest($data);
                    $response = $client->post('https://api.line.me/v2/bot/message/push', $data);
                    Log::info(json_encode($response));
                    Log::info(json_encode($data));
                    break;
                default:
                    $response = $bot->replyText($replyToken, "歡迎使用無與倫比網站助手");
                    break;
            }
        }
    }

    // public function post($url, array $data, array $headers = null)
    // {
    //     $headers = is_null($headers) ? ['Content-Type: application/json; charset=utf-8'] : $headers;
    //     return $this->sendRequest('POST', $url, $headers, $data);
    // }
//     Array
// (
//     [events] => Array
//         (
//             [0] => Array
//                 (
//                     [type] => message
//                     [replyToken] => c4a9432fc4654838962fa0703f0b4589
//                     [source] => Array
//                         (
//                             [userId] => U1b7997d75ba52775e41438aa1d502150
//                             [type] => user
//                         )

//                     [timestamp] => 1545054386101
//                     [message] => Array
//                         (
//                             [type] => text
//                             [id] => 9023593433979
//                             [text] => test message no.4
//                         )

//                 )

//         )

//     [destination] => U27c9098d14de1f99fd2f750548cc388d
// )


    // [2018-12-17 13:41:34] local.INFO: {"events":[{"type":"message","replyToken":"c4a9432fc4654838962fa0703f0b4589","source":{"userId":"U1b7997d75ba52775e41438aa1d502150","type":"user"},"timestamp":1545054386101,"message":{"type":"text","id":"9023593433979","text":"test message no.4"}}],"destination":"U27c9098d14de1f99fd2f750548cc388d"}

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
