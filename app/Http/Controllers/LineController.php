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
use App\Leave;

class LineController extends Controller
{

    public function lineEvent(Request $request)
    {
        $lineApi = DB::table('credentials')->select('username as secret', 'password as access_token')->where('description', 'line_api')->first();
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

        if ($userId) {
            $user = User::byLineUserId($userId)->first();

            if (!$user) {
                $response = $bot->replyText($replyToken, "您的LINE_USER_ID為: " . $userId . "\n此ID尚未與門派網站帳號綁定，請聯繫門派管理員");
            }
        }

        if ($type == 'message') {
            $message = $filtered['message'];
            $msgType = $message['type'];
            $msgText = $message['text'];
            Log::info(json_encode($message));

            // Ranking
            if ($msgText == '戰力排行') {
                $data = array();

                // Use array when more than one addressee
                $data['to'] = $userId;

                // Content
                $content = "-門派戰力排行前15名- \n";
                $rankings = User::select('gameid', 'capability')->orderBy('capability', 'DESC')->take(15)->get();
                foreach ($rankings as $ranking) {
                    $content .= $ranking->gameid . ' - ' . $ranking->capability . "\n";
                }
                $data['messages'] = array(array('type'=>'text', 'text'=>$content));
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data);
                // Log::info(json_encode($response));
                // Log::info(json_encode($data));

            // Inform format
            } elseif ($msgText == '更新戰力') {
                $response = $bot->replyText($replyToken, "請使用以下格式更新戰力(例子)\n更新戰力:3560000");

            // Capability update
            } elseif (mb_substr($msgText, 0, 5) == '更新戰力:' || mb_substr($msgText, 0, 5) == '更新戰力：') {
                
                $msgText = str_replace('：', ':', $msgText);
                $newCapability = explode(':', $msgText)[1];
                if ($newCapability > 0 && $newCapability < 5000000) {
                    // Update DB
                    $user->capability = $newCapability;
                    $user->save();
                    $response = $bot->replyText($replyToken, "戰力更新完成，當前戰力: " . $newCapability);
                } else {
                    $response = $bot->replyText($replyToken, "戰力輸入錯誤，請確認後重新輸入");
                }

            // Approximate Entry Time
            } elseif (in_array($msgText, array('準時', '晚10', '晚20', '晚30'))) {
                $msgText = str_replace(array('準時', '晚10', '晚20', '晚30'), array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'), $msgText);
                $user->approx_entry_time = $msgText;
                $user->save();
                $response = $bot->replyText($replyToken, "您的門派爭奪進場狀態已更新成功為: " . $msgText);
            
            // Casual / Sick Leave
            } elseif (mb_substr($msgText, 0, 3) == '請假:' || mb_substr($msgText, 0, 3) == '請假：') {
                $user->approx_entry_time = '無法參與本次爭奪';
                $user->save();
                $msgText = str_replace('：', ':', $msgText);
                $leaveReason = explode(':', $msgText)[1];

                $call_leave = new Leave();
                $call_leave->uid = $user->uid;
                $call_leave->gameid = $user->gameid;
                $call_leave->reason = $leaveReason ? $leaveReason : '未注明';
                $call_leave->call_leave_time = time();
                $call_leave->save();
                
                $response = $bot->replyText($replyToken, "您的門派爭奪進場狀態已更新為: 無法參加本次爭奪");

            // Ignore messages
            } elseif (in_array($msgText, array('請使用以下格式更新戰力(例子) 更新戰力:3560000', '
                請輸入進場狀態（格式：準時 | 晚10 | 晚20 | 晚30 | 請假:加班）'))) {
                // No replies

            // Reset Approx Entry Time
            } elseif ($msgText == '重置門派爭奪進場狀態') {
                $response = $bot->replyText($replyToken, "請輸入: 確認清除\n以完成本次數據抹除請求");
            } elseif ($msgText == '確認清除') {
                if (in_array($user->uid, array(1,2,3,12,13,27,45))) {
                    $allUsers = User::get();
                    foreach ($allUsers as $singleUser) {
                        $singleUser->update(['approx_entry_time' => '']);
                    }
                    $response = $bot->replyText($replyToken, "系統管理員: " . $user->lineid . " 送出的數據抹除請求已完成");
                } else {
                    $response = $bot->replyText($replyToken, "該請求必需由系統管理員發起，請確認後重試");
                }

            // Website Link
            } elseif ($msgText == '無與倫比門派網站') {
                $response = $bot->replyText($replyToken, "https://unstoppable1122.com");

            // Help Information
            } elseif ($msgText == '請協助我使用門派助手') {
                $response = $bot->replyText($replyToken, "門派助手指令列表:（測試版本待更新）");

            } else {
                $response = $bot->replyText($replyToken, "");
            }
                
            // 
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

}
