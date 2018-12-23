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
        // $json = '{
        //           "type": "bubble",
        //           "hero": {
        //             "type": "image",
        //             "url": "https://unstoppable1122.com/images/yuek_kei.png",
        //             "size": "full",
        //             "aspectRatio": "20:4",
        //             "aspectMode": "cover"
        //           },
        //           "body": {
        //             "type": "box",
        //             "layout": "vertical",
        //             "spacing": "md",
        //             "contents": [
        //               {
        //                 "type": "text",
        //                 "text": "戰力排行",
        //                 "size": "md",
        //                 "weight": "bold"
        //               },
        //               {
        //                 "type": "box",
        //                 "layout": "vertical",
        //                 "spacing": "none",
        //                 "contents": [
        //                   {
        //                     "type": "box",
        //                     "layout": "baseline",
        //                     "contents": [
                              
        //                       {
        //                         "type": "text",
        //                         "text": "rayc9223",
        //                         "size": "sm",
        //                         "weight": "bold",
        //                         "align": "start",
        //                         "margin": "none"
        //                       },
        //                       {
        //                         "type": "text",
        //                         "text": "3,680,000",
        //                         "size": "md",
        //                         "align": "end",
        //                         "weight": "bold",
        //                         "color": "#FF0000"
        //                       }
        //                     ]
        //                   }
        //                 ]
        //               }
        //             ]
        //           },
        //           "footer": {
        //             "type": "box",
        //             "layout": "vertical",
        //             "contents": [
        //               {
        //                 "type": "spacer",
        //                 "size": "sm"
        //               }
        //             ]
        //           }
        //         }';
        // $data = [];
        // $data['to'] = 'U1b7997d75ba52775e41438aa1d502150';
        // $data['messages'] = [['type'=>'flex', 'altText' => 'this is a flex message', 'contents'=>json_decode($json, true)]];
        // $data = json_decode($json, true);
        $jsonTemplate = '{"type":"bubble","hero":{"type":"image","url":"https:\/\/unstoppable1122.com\/images\/yuek_kei.png","size":"full","aspectRatio":"20:4","aspectMode":"cover"},"body":{"type":"box","layout":"vertical","spacing":"md","contents":[{"type":"text","text":"\u6230\u529b\u6392\u884c","size":"md","weight":"bold"},%s]},"footer":{"type":"box","layout":"vertical","contents":[{"type":"spacer","size":"sm"}]}}';

                $rankings = User::select('gameid', 'capability')->orderBy('capability', 'DESC')->take(15)->get();

                // dd($rankings);

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
                // dd($content);
                $json = sprintf($jsonTemplate, $content);
                // dd($json);
                $data['to'] = 'U1b7997d75ba52775e41438aa1d502150';
                $data['messages'] = [['type'=>'flex', 'altText' => 'this is a flex message', 'contents'=>json_decode($json, true)]];
                // dd($data);
        print_r(json_encode($data));
    }

    public function postData(Request $request){
        dd($request->all());
    }
}
