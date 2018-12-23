<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
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
    public function showBinding()
    {
        if (Auth::user()) {
            $user = Auth::user();
            $lineUserId = $user->line_userid ? $user->line_userid : '';
            return view('line_binding', ['line_userid' => $lineUserId]);
        } else {
            return redirect('login');
        }
    }

    public function bind(Request $request)
    {
        if (Auth::user()) {
            if (!$request->filled('line_userid')) {
                Session::flash('error_msg','請填寫 LINE USER ID');
                return back()->withInput($request->input());
            }

            if (strlen($request->line_userid) < 33 ) {
                Session::flash('error_msg','LINE USER ID 長度不正確，請確認後重試');
                return back()->withInput($request->input());
            }

            if (substr($request->line_userid, 0, 1) <> 'U') {
                Session::flash('error_msg','LINE USER ID 格式不符，請確認後重試');
                return back()->withInput($request->input());
            }
            $user = Auth::user();
            if ($user) {
                $user->line_userid = $request->line_userid;
                $user->save();
                return redirect('bind_success');
            } else {
                return redirect('login');
            }
        } else {
            return redirect('login');
        }
    }

    public function bindSuccess()
    {
        return view('bind_success');
    }

    public function lineEvent(Request $request)
    {
        $lineApi = DB::table('credentials')->select('username as secret', 'password as access_token')->where('description', 'line_api')->first();
        $accessToken = $lineApi->access_token;
        $secret = $lineApi->secret;
        $client = new \LINE\LINEBot\HTTPClient\CurlHTTPClient($accessToken);
        $bot = new \LINE\LINEBot($client, ['channelSecret' => $secret]);

        Log::info(json_encode($request->all()));
        $events = $request->all();
        // Looping Needed?
        Log::info(json_encode($events));
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

            /*
             * ===============================
             * Category Query
             * ===============================
             */
            // Ranking
            if ($msgText == '戰力排行') {
                $data = array();
                // Use array when more than one addressee
                $data['to'] = $userId;
                // Content
                $content = "-門派戰力排行前15名- \n";
                $rankings = User::select('gameid', 'capability')->orderBy('capability', 'DESC')->take(15)->get();
                foreach ($rankings as $ranking) {
                    $content .= "{$ranking->gameid} - {$ranking->capability} \n";
                }
                $data['messages'] = array(array('type'=>'text', 'text'=>$content));
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data);
                // Log::info(json_encode($response));
                // Log::info(json_encode($data));

            // Flex messages test
            } elseif ($msgText == 'test') {
                $data = array();
                // Use array when more than one addressee
                $data['to'] = $userId;
                $data['messages'] = array(
                        array(
                            'type' => 'bubble', 
                            'header' => array(
                                'type' => 'box',
                                'layout' => 'vertical', 
                                'contents' => array(
                                    'type' => 'text', 
                                    'text' => 'Capability Ranking',
                                    'size' => 'xl',
                                    'weight' => 'bold'
                                ),
                                'hero' => array(
                                    'type' => 'image',
                                    'url' => 'https://sitthi.me:3807/static/fifa.jpg',
                                    'size' => 'full',
                                    'aspectRatio' => '20:13',
                                    'aspectMode' => 'cover'
                                ),
                                'body' => array(
                                    'type' => 'box',
                                    'layout' => 'vertical',
                                    'spacing' => 'md',
                                    'contents' => array(
                                        array(
                                            'type' => 'box',
                                            'text' => 'LIVE',
                                            'size' => 'lg',
                                            'color' => '#555555',
                                            'weight' => 'bold',
                                            'align' => 'center'
                                        ),
                                    )
                                ),
                            )
                        )
                    );
                                
                
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data);

            // {
            //   "to": "U1b7997d75ba52775e41438aa1d502150",
            //   "messages": [
            //     {
            //       "type": "flex",
            //       "altText": "This is a Flex Message",
            //       "contents": {
            //         "type": "bubble",
            //         "body": {
            //           "type": "box",
            //           "layout": "horizontal",
            //           "contents": [
            //             {
            //               "type": "text",
            //               "text": "Hello,"
            //             },
            //             {
            //               "type": "text",
            //               "text": "World!"
            //             }
            //           ]
            //         }
            //       }
            //     }
            //   ]
            // }'

                // {  
                //   "type": "flex",
                //   "altText": "this is a flex message",
                //   "contents": {
                //     "type": "bubble",
                //     "body": {
                //       "type": "box",
                //       "layout": "vertical",
                //       "contents": [
                //         {
                //           "type": "text",
                //           "text": "hello"
                //         },
                //         {
                //           "type": "text",
                //           "text": "world"
                //         }
                //       ]
                //     }
                //   }
                // }
                // $data = json_decode('{
                //   "type": "template",
                //   "altText": "This is a buttons template",
                //   "template": {
                //       "type": "buttons",
                //       "thumbnailImageUrl": "https://example.com/bot/images/image.jpg",
                //       "imageAspectRatio": "rectangle",
                //       "imageSize": "cover",
                //       "imageBackgroundColor": "#FFFFFF",
                //       "title": "Menu",
                //       "text": "Please select",
                //       "defaultAction": {
                //           "type": "uri",
                //           "label": "View detail",
                //           "uri": "http://example.com/page/123"
                //       },
                //       "actions": [
                //           {
                //             "type": "postback",
                //             "label": "Buy",
                //             "data": "action=buy&itemid=123"
                //           },
                //           {
                //             "type": "postback",
                //             "label": "Add to cart",
                //             "data": "action=add&itemid=123"
                //           },
                //           {
                //             "type": "uri",
                //             "label": "View detail",
                //             "uri": "http://example.com/page/123"
                //           }
                //       ]
                //   }
                // }', true);
                // $response = $client->post('https://api.line.me/v2/bot/message/push', $data);


            // Rolls Available
            } elseif ($msgText == '爭奪卷數') {
                $response = $bot->replyText($replyToken, "{$user->lineid} 當前登記門派爭奪卷數: {$user->roll_qty}");

            // User Capability
            } elseif ($msgText == '戰力') {
                $response = $bot->replyText($replyToken, "{$user->lineid} 當前登記戰力: {$user->capability}");

            // User Level
            } elseif ($msgText == '等級') {
                $response = $bot->replyText($replyToken, "{$user->lineid} 當前登記等級: {$user->level}");

            // User Approx Entry Time
            } elseif ($msgText == '進場狀態') {
                $status = $user->approx_entry_time ? $user->approx_entry_time : '未設定';
                $response = $bot->replyText($replyToken, "{$user->lineid} 當前登記進場狀態: {$status}");

            // Approx Entry Time empty member list
            } elseif ($msgText == '進場統計') {
                $members = User::where([['guild','無與倫比'],['approx_entry_time', '']])->get();
                $memberCount = $members->count();
                $memberList = '';
                foreach ($members as $member) {
                    $memberList .= "{$member->lineid}\n";
                }
                // $response = $bot->replyText($replyToken, "未設定進場狀態({$memberCount}): \n{$memberList}");

                $tanhungTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '丹紅城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '<>', '無法參與本次爭奪']])->count();
                $linmoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '蓮慕城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '<>', '無法參與本次爭奪']])->count();
                $choiloTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '<>', '無法參與本次爭奪']])->count();
                $taihoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '大豪城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '<>', '無法參與本次爭奪']])->count();
                $buffTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '<>', '無法參與本次爭奪']])->count();

                $response = $bot->replyText($replyToken, "未設定進場狀態({$memberCount}): \n{$memberList}\n各分組登記狀態: \n丹紅: {$tanhungTeamCount}\n蓮慕: {$linmoTeamCount}\n塞羅: {$choiloTeamCount}\n大豪: {$taihoTeamCount}\n鬼怪組: {$buffTeamCount}");

            /*
             * ===============================
             * Category Update
             * ===============================
             */
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
                    $response = $bot->replyText($replyToken, "戰力更新完成，當前戰力: {$newCapability}");
                } else {
                    $response = $bot->replyText($replyToken, "戰力輸入錯誤，請確認後重新輸入");
                }

            // Available Rolls
            } elseif (mb_substr($msgText, 0, 5) == '更新卷數:' || mb_substr($msgText, 0, 5) == '更新卷數：') {
                $msgText = str_replace('：', ':', $msgText);
                $newRollQty = explode(':', $msgText)[1];
                if ($newRollQty > 0 && $newRollQty < 500) {
                    // Update DB
                    $user->roll_qty = $newRollQty;
                    $user->save();
                    $response = $bot->replyText($replyToken, "門派爭奪卷數更新完成，當前數量: {$newRollQty}");
                } else {
                    $response = $bot->replyText($replyToken, "爭奪卷數量輸入錯誤，請確認後重新輸入");
                }

            // Approximate Entry Time
            } elseif (in_array($msgText, array('準時', '晚10', '晚20', '晚30'))) {
                $msgText = str_replace(array('準時', '晚10', '晚20', '晚30'), array('準時參加', '晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'), $msgText);
                $user->approx_entry_time = $msgText;
                $user->save();
                $response = $bot->replyText($replyToken, "您的門派爭奪進場狀態已更新為: {$msgText}");
            
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
                    $response = $bot->replyText($replyToken, "系統管理員: {$user->lineid} 送出的數據抹除請求已完成");
                } else {
                    $response = $bot->replyText($replyToken, "該請求必需由系統管理員發起，請確認後重試");
                }

            // Website Link
            } elseif ($msgText == '無與倫比門派網站') {
                $response = $bot->replyText($replyToken, "https://unstoppable1122.com");

            // Help Information
            } elseif ($msgText == '請協助我使用門派助手') {
                $response = $bot->replyText($replyToken, "門派助手指令列表: \n--- 查詢類 ---\n戰力排行\n爭奪卷數\n戰力\n等級\n進場狀態\n進場統計\n\n--- 設定類 ---\n更新戰力:{數值}\n更新卷數:{數值}\n準時\n晚10\n晚20\n晚30\n請假:{事由}\n");

            } else {
                $response = $bot->replyText($replyToken, "");
            }
        }
        return response('OK', 200);
    }
}