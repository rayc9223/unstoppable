<?php

namespace App\Libraries;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\User;

class Helpers
{
	public function ramdomReply()
	{
		$randomText = [
                    "小幫手壞掉了嗎？\n好像真的壞掉了耶{$this->emoji('0x10007B')}", 
                    "這個指令小幫手暫時無法識別呢{$this->emoji('0x100091')}\n如果希望小幫手加入這項功能\n可以在門派群組提出建議哦{$this->emoji('0x10008D')}", 
                    "指令列表裡面好像...\n沒有這個指令哦{$this->emoji('0x10008C')}", 
                    "哈囉，今天小幫手休假哦\n{$this->emoji('0x100085')}小幫手怎麼會有休假?!\n好像說得也對吼{$this->emoji('0x10007C')}",
                    "請確認指令後重試",
                    "等一下，我打個電話給會長看看是不是把我的電源給踢掉了...",
                    "我在看水行俠，等下看完回你哦{$this->emoji('0x100095')}"
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

    public function statistics()
    {
    	$members = User::where([['guild','無與倫比'],['approx_entry_time', '']])->get();
        $memberCount = $members->count();
        $memberList = '';
        foreach ($members as $member) {
            $memberList .= "{$member->lineid}\n";
        }

        // Team Count
        $tanhungTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '丹紅城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $linmoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '蓮慕城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $choiloTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '塞羅城'], ['approx_entry_time', '準時參加']])->count();
        $taihoTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '大豪城'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();
        $buffTeamCount = User::where([['guild','無與倫比'],['guildwar_phase_1', '增益：鬼怪組'], ['approx_entry_time', '<>', ''], ['approx_entry_time', '準時參加']])->count();

        // Team List
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

        $response = "未設定進場狀態({$memberCount}): \n{$memberList}\n各分組登記狀態: \n丹紅: {$tanhungTeamCount}\n蓮慕: {$linmoTeamCount}\n-------塞羅:({$choiloTeamCount})------\n晚到({$choiloTeamLateCount}):{$choiloTeamLateList}\n請假({$choiloTeamLeaveCount}):{$choiloTeamLeaveList}\n\n-------大豪:({$taihoTeamCount})------\n晚到({$taihoTeamLateCount}):{$taihoTeamLateList}\n請假({$taihoTeamLeaveCount}):{$taihoTeamLeaveList}\n\n-------鬼怪:({$buffTeamCount})------\n晚到({$buffTeamLateCount}):{$buffTeamLateList}\n請假({$buffTeamLeaveCount}):{$buffTeamLeaveList}";

        return $response;
    }
}