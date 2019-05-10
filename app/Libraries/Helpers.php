<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class Helpers
{
	public function getValue($userInput)
	{
		$userInput = str_replace('：', ':', $userInput);
        return explode(':', $userInput)[1];
	}

	public function randomReply()
	{
		$randomText = [
                    "小幫手壞掉了嗎？\n好像真的壞掉了耶{$this->emoji('0x10007B')}", 
                    "這個指令小幫手暫時無法識別呢{$this->emoji('0x100091')}\n如果希望小幫手加入這項功能\n可以在門派群組提出建議哦{$this->emoji('0x10008D')}", 
                    "指令列表裡面好像...\n沒有這個指令哦{$this->emoji('0x10008C')}", 
                    "哈囉，今天小幫手休假哦\n{$this->emoji('0x100085')}小幫手怎麼會有休假?!\n好像說得也對吼{$this->emoji('0x10007C')}",
                    "請確認指令後重試",
                    "等一下，我打個電話給會長看看是不是把我的電源給踢掉了...",
                    "我在看終局之戰，怎麼會這麼好看{$this->emoji('0x100095')}",
                    "愛你3000遍"
                ];
        return $randomText[mt_rand(0, count($randomText)-1)];
	}

	public function emoji($code)
    {
        if ($code) {
            $code = str_replace('0x', '', $code);
            $bin = hex2bin(str_repeat('0', 8 - strlen($code)) . $code);
            return mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
        }
    }

    public function assembleFlex($take, $offset = 0, $guild)
    {
        $jsonTemplate = '{"type":"bubble","hero":{"type":"image","url":"https:\/\/unstoppable1122.com\/images\/rankings.png","size":"full","aspectRatio":"20:4","aspectMode":"cover"},"body":{"type":"box","layout":"vertical","spacing":"md","contents":[{"type":"text","text":"\u6230\u529b\u6392\u884c","size":"md","weight":"bold"},%s]},"footer":{"type":"box","layout":"vertical","contents":[{"type":"spacer","size":"sm"}]}}';

        $rankings = User::select('gameid', 'capability')->where('guild', $guild)->orderBy('capability', 'DESC')->skip($offset)->take($take)->get();

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

    public function statistics($guild)
    {
    	$members = User::where([['guild', $guild],['approx_entry_time', '']])->get();
        $memberCount = $members->count();
        $memberList = '';
        foreach ($members as $member) {
            $memberList .= "{$member->lineid}\n";
        }

        $tanHung = $this->getTeamData('丹紅城', $guild);
        $linMo = $this->getTeamData('蓮慕城', $guild);
        $choiLo = $this->getTeamData('塞羅城', $guild);
        $taiHo = $this->getTeamData('大豪城', $guild);
        $buff = $this->getTeamData('增益：鬼怪組', $guild);

        $response = "未設定進場狀態({$memberCount}): \n{$memberList}\n各分組登記狀態: \n-------丹紅:({$tanHung['teamCount']})------\n晚到({$tanHung['teamLateCount']}):{$tanHung['teamLateList']}\n請假({$tanHung['teamLeaveCount']}):{$tanHung['teamLeaveList']}\n\n-------蓮慕:({$linMo['teamCount']})------\n晚到({$linMo['teamLateCount']}):{$linMo['teamLateList']}\n請假({$linMo['teamLeaveCount']}):{$linMo['teamLeaveList']}\n\n-------塞羅:({$choiLo['teamCount']})------\n晚到({$choiLo['teamLateCount']}):{$choiLo['teamLateList']}\n請假({$choiLo['teamLeaveCount']}):{$choiLo['teamLeaveList']}\n\n-------大豪:({$taiHo['teamCount']})------\n晚到({$taiHo['teamLateCount']}):{$taiHo['teamLateList']}\n請假({$taiHo['teamLeaveCount']}):{$taiHo['teamLeaveList']}\n\n-------鬼怪:({$buff['teamCount']})------\n晚到({$buff['teamLateCount']}):{$buff['teamLateList']}\n請假({$buff['teamLeaveCount']}):{$buff['teamLeaveList']}";

        return $response;
    }

    public function getTeamData($teamName, $guild)
    {
        $teamData = [];
        $teamData['teamCount'] = User::where([['guild', $guild],['guildwar_phase_1', $teamName], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $teamData['teamLateCount'] = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild', $guild],['guildwar_phase_1', $teamName]])->count();
        $teamLate = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where([['guild', $guild],['guildwar_phase_1', $teamName]])->get();
        $teamLateList = '';
        foreach ($teamLate as $member) {
            $teamLateList .= "{$member->lineid}|";
        }
        $teamData['teamLateList'] = rtrim($teamLateList, '|');

        $teamLeave = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild', $guild],['guildwar_phase_1', $teamName]])->get();
        $teamData['teamLeaveCount'] = User::where([['approx_entry_time', '無法參加本次爭奪'], ['guild', $guild],['guildwar_phase_1', $teamName]])->count();
        $teamLeaveList = '';
        foreach ($teamLeave as $leaveMember) {
            $teamLeaveList .= "{$leaveMember->lineid}|";
        }
        $teamData['teamLeaveList'] = rtrim($teamLeaveList, '|');

        return $teamData;
    }

    public function analysis($guild)
    {
        $data = [];
        $data['total_users'] = User::where('guild',  $guild)->count();

        $data['ontime'] = User::where([['guild', $guild],['approx_entry_time','準時參加']])->get();

        $data['late'] = User::whereIn('approx_entry_time', array('晚到10分鐘', '晚到11~20分鐘', '晚到30分鐘以上'))->where('guild', $guild)->count();

        $data['late_by_10'] = User::where([['guild', $guild],['approx_entry_time','晚到10分鐘']])->get();

        $data['late_by_20'] = User::where([['guild', $guild],['approx_entry_time','晚到11~20分鐘']])->get();

        $data['late_by_30'] = User::where([['guild', $guild],['approx_entry_time','晚到30分鐘以上']])->get();

        $data['absent'] = User::where([['guild', $guild],['approx_entry_time','無法參加本次爭奪']])->get();

        $data['approx_undefined'] = User::where([['guild', $guild],['approx_entry_time', '']])->get();

        $data['guildwar_p1'] = User::where([['guild', $guild],['guildwar_phase_1', '<>', '']])->get();

        $data['guildwar_p1_buff'] = User::where([['guild', $guild],['guildwar_phase_1', '增益：鬼怪組']])->get();

        $data['guildwar_p1_tanhung'] = User::where([['guild', $guild],['guildwar_phase_1', '丹紅城']])->get();

        $data['guildwar_p1_taiho'] = User::where([['guild', $guild],['guildwar_phase_1', '大豪城']])->get();

        $data['guildwar_p1_linmo'] = User::where([['guild', $guild],['guildwar_phase_1', '蓮慕城']])->get();

        $data['guildwar_p1_choilo'] = User::where([['guild', $guild],['guildwar_phase_1', '塞羅城']])->get();

        $data['guildwar_p1_undefined'] = User::where([['guild', $guild],['guildwar_phase_1', '']])->get();

        $data['guildwar_p2'] = User::where([['guild', $guild],['guildwar_phase_2', '<>', '']])->get();

        $data['guildwar_p2_urban'] = User::where([['guild', $guild],['guildwar_phase_2', '城外郊區組']])->get();

        $data['guildwar_p2_forbidden'] = User::where([['guild', $guild],['guildwar_phase_2', '皇城內組']])->get();

        $data['guildwar_p2_palace'] = User::where([['guild', $guild],['guildwar_phase_2', '皇宮組']])->get();

        $data['guildwar_p2_undefined'] = User::where([['guild', $guild],['guildwar_phase_2', '']])->get();

        return $data;
    }

    public function aetJson()
    {
    	return '{
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
    }
}