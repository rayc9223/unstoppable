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

    public function assembleFlex($take, $offset = 0)
    {
        $jsonTemplate = '{"type":"bubble","hero":{"type":"image","url":"https:\/\/unstoppable1122.com\/images\/rankings.png","size":"full","aspectRatio":"20:4","aspectMode":"cover"},"body":{"type":"box","layout":"vertical","spacing":"md","contents":[{"type":"text","text":"\u6230\u529b\u6392\u884c","size":"md","weight":"bold"},%s]},"footer":{"type":"box","layout":"vertical","contents":[{"type":"spacer","size":"sm"}]}}';

        $rankings = User::select('gameid', 'capability')->orderBy('capability', 'DESC')->skip($offset)->take($take)->get();

        $content = '';
        foreach ($rankings as $ranking) {
            if ($ranking->capability > 4000000) {
                $color = '#8e44ad';
            } elseif ($ranking->capability > 3500000) {
                $color = '#FF0000';
            } elseif ($ranking->capability > 3000000) {
                $color = '#f39c12';
            } elseif ($ranking->capability > 2500000) {
                $color = '#27ae60';
            } else {
                $color = '#2980b9';
            }
            $content .= '{"type":"box","layout":"vertical","spacing":"none","contents":[{"type":"box","layout":"baseline","contents":[{"type":"text","text":"' . $ranking->gameid . '","size":"sm","weight":"bold","align":"start","margin":"none"},{"type":"text","text":"' . $ranking->capability . '","size":"md","align":"end","weight":"bold","color":"' . $color . '"}]}]},';
        }
        $content = rtrim($content, ',');
        $json = sprintf($jsonTemplate, $content);

        return $json;
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
            if ($msgText == 'test') {
                
                // do nothing... 

            // Rankings in Flex Message form
            } elseif ($msgText == '戰力排行') {
                $data = array();
                // Use array when more than one addressee
                $data['to'] = $userId;
                $json = $this->assembleFlex(20);
                $data['messages'] = [['type'=>'flex', 'altText' => '戰力排行前20名', 'contents'=>json_decode($json, true)]];
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data);

                $json = $this->assembleFlex(20, 20);
                $data['messages'] = [['type'=>'flex', 'altText' => '戰力排行', 'contents'=>json_decode($json, true)]];
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data);

            // Rolls Available
            } elseif (in_array($msgText, ['爭奪卷數', '爭奪券數'])) {
                $response = $bot->replyText($replyToken, "{$user->lineid} 當前登記門派爭奪券數: {$user->roll_qty}");

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

                // Team Count
                $tanhungTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '丹紅城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
                $linmoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '蓮慕城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
                $choiloTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城'], ['approx_entry_time', '準時參加']])->count();
                $taihoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '大豪城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
                $buffTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();

                // Team List
                // ChoiLo Team
                // $choiloTeamNotDefined = User::where('approx_entry_time', '')->get();
                // $choiloTeamNotDefinedCount = User::where('approx_entry_time', '')->count();
                // $choiloTeamNotDefinedList = '';
                // foreach ($choiloTeamNotDefined as $choiloNotDefinedMember) {
                //     $choiloTeamNotDefinedList .= "{$choiloNotDefinedMember->lineid}|";
                // }

                $choiloTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->count();
                $choiloTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->get();
                $choiloTeamLateList = '';
                foreach ($choiloTeamLate as $choiloLateMember) {
                    $choiloTeamLateList .= "{$choiloLateMember->lineid}|";
                }
                $choiloTeamLateList = rtrim($choiloTeamLateList, '|');

                $choiloTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->get();
                $choiloTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '塞羅城']])->count();
                $choiloTeamLeaveList = '';
                foreach ($choiloTeamLeave as $choiloLeaveMember) {
                    $choiloTeamLeaveList .= "{$choiloLeaveMember->lineid}|";
                }
                $choiloTeamLeaveList = rtrim($choiloTeamLeaveList, '|');

                // Team Taiho
                $taihoTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->count();
                $taihoTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->get();
                $taihoTeamLateList = '';
                foreach ($taihoTeamLate as $taihoLateMember) {
                    $taihoTeamLateList .= "{$taihoLateMember->lineid}|";
                }
                $taihoTeamLateList = rtrim($taihoTeamLateList, '|');

                $taihoTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->get();
                $taihoTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '大豪城']])->count();
                $taihoTeamLeaveList = '';
                foreach ($taihoTeamLeave as $taihoLeaveMember) {
                    $taihoTeamLeaveList .= "{$taihoLeaveMember->lineid}|";
                }
                $taihoTeamLeaveList = rtrim($taihoTeamLeaveList, '|');
                
                // Team Buff
                $buffTeamLateCount = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->count();
                $buffTeamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->get();
                $buffTeamLateList = '';
                foreach ($buffTeamLate as $buffLateMember) {
                    $buffTeamLateList .= "{$buffLateMember->lineid}|";
                }
                $buffTeamLateList = rtrim($buffTeamLateList, '|');

                $buffTeamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->get();
                $buffTeamLeaveCount = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組']])->count();
                $buffTeamLeaveList = '';
                foreach ($buffTeamLeave as $buffLeaveMember) {
                    $buffTeamLeaveList .= "{$buffLeaveMember->lineid}|";
                }
                $buffTeamLeaveList = rtrim($buffTeamLeaveList, '|');

                // $taihoTeam = User::where([])->get();
                // $buffTeam = User::where([])->get();

                $response = $bot->replyText($replyToken, "未設定進場狀態({$memberCount}): \n{$memberList}\n各分組登記狀態: \n丹紅: {$tanhungTeamCount}\n蓮慕: {$linmoTeamCount}\n-------塞羅:({$choiloTeamCount})------\n晚到({$choiloTeamLateCount}):{$choiloTeamLateList}\n請假({$choiloTeamLeaveCount}):{$choiloTeamLeaveList}\n\n-------大豪:({$taihoTeamCount})------\n晚到({$taihoTeamLateCount}):{$taihoTeamLateList}\n請假({$taihoTeamLeaveCount}):{$taihoTeamLeaveList}\n\n-------鬼怪:({$buffTeamCount})------\n晚到({$buffTeamLateCount}):{$buffTeamLateList}\n請假({$buffTeamLeaveCount}):{$buffTeamLeaveList}");

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
            } elseif (in_array(mb_substr($msgText, 0, 5), ['更新卷數:', '更新卷數：', '更新券數:', '更新券數：'])) {
                $msgText = str_replace('：', ':', $msgText);
                $newRollQty = explode(':', $msgText)[1];
                if ($newRollQty > 0 && $newRollQty < 500) {
                    // Update DB
                    $user->roll_qty = $newRollQty;
                    $user->save();
                    $response = $bot->replyText($replyToken, "門派爭奪券數更新完成，當前數量: {$newRollQty}");
                } else {
                    $response = $bot->replyText($replyToken, "爭奪券數量輸入錯誤，請確認後重新輸入");
                }

            // Call AET Menu
            } elseif ($msgText == '設定進場時間') {
                $data['to'] = $userId;
                $json = '{
                          "type": "template",
                          "altText": "設定進場時間",
                          "template": {
                            "type": "buttons",
                            "actions": [
                              {
                                "type": "message",
                                "label": "準時參加",
                                "text": "準時"
                              },
                              {
                                "type": "message",
                                "label": "晚到10分鐘",
                                "text": "晚10"
                              },
                              {
                                "type": "message",
                                "label": "晚到11~20分鐘",
                                "text": "晚20"
                              },
                              {
                                "type": "message",
                                "label": "晚到30分鐘以上",
                                "text": "晚30"
                              }
                            ],
                            "thumbnailImageUrl": "https://unstoppable1122.com/images/prince.png",
                            "title": "請設定本次門派爭奪進場時間",
                            "text": "如無法參加，請使用 請假:{事由} 指令"
                          }
                        }';
                $data['messages'] = [json_decode($json, true)];
                $response = $client->post('https://api.line.me/v2/bot/message/push', $data); 

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
            } elseif (in_array($msgText, array('請使用以下格式更新戰力(例子) 更新戰力:3560000'))) {
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
                    $response = $bot->replyText($replyToken, "該請求必須由系統管理員發起，請確認後重試");
                }

            // Website Link
            } elseif ($msgText == '無與倫比門派網站') {
                $response = $bot->replyText($replyToken, "https://unstoppable1122.com");

            // Help Information
            } elseif ($msgText == '請協助我使用小幫手') {
                $response = $bot->replyText($replyToken, "指令列表: \n--- 查詢類 ---\n戰力排行\n爭奪券數\n戰力\n等級\n進場狀態\n進場統計\n\n--- 設定類 ---\n更新戰力:{數值}\n更新券數:{數值}\n準時\n晚10\n晚20\n晚30\n請假:{事由}\n");

            } else {
                $randomText = [
                    "小幫手壞掉了嗎？\n好像真的壞掉了耶{$this->Emoji('0x10007B')}", 
                    "這個指令小幫手暫時無法識別呢{$this->Emoji('0x100091')}\n如果希望小幫手加入這項功能\n可以在門派群組提出建議哦{$this->Emoji('0x10008D')}", 
                    "指令列表裡面好像...\n沒有這個指令哦{$this->Emoji('0x10008C')}", 
                    "哈囉，今天小幫手休假哦\n{$this->Emoji('0x100085')}小幫手怎麼會有休假?!\n好像說得也對吼{$this->Emoji('0x10007C')}",
                    "請確認指令後重試",
                    "等一下，我打個電話給會長看看是不是把我的電源給踢掉了...",
                    "我在看水行俠，等下看完回你哦{$this->Emoji('0x100095')}"
                ];
                $response = $bot->replyText($replyToken, $randomText[mt_rand(0, count($randomText)-1)]);
            }
        }
        return response('OK', 200);
    }

    public function Emoji($code)
    {
        if ($code) {
            $code = str_replace('0x', '', $code);
            $bin = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
            return mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
        }
    }
}


