<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>戰力排行</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script defer src="/js/brands.js"></script>
        <script defer src="/js/solid.js"></script>
        <script defer src="/js/fontawesome.js"></script>

        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.3.3.1.min.js"></script>

       <!--  <link rel="stylesheet" type="text/css" href="/easyui/themes/default/easyui.css">
        <link rel="stylesheet" type="text/css" href="/easyui/themes/icon.css">
        <script type="text/javascript" src="/easyui/jquery.min.js"></script>
        <script type="text/javascript" src="/easyui/jquery.easyui.min.js"></script> -->

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                /*height: 100vh;*/
                /*padding-top: 30px;*/
                margin: 0;
            }

            .full-height {
                /*height: 100vh;*/
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                /*font-size: 84px;*/
                font-size: 2em;
            }

            .links > a {
                color: #636b6f;
                padding: 0 20px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 24px;
            }

            .linear{
                width:100%;
                height:50px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                position: relative;
                top:110px;
                border-radius: 0 0 20px 20px;
            }

            @media screen and (max-width: 500px) {
                #capability {
                    display: none;
                }

                #mb-capability {
                    display: block;
                }

               /* .links {
                    display: none;
                }*/

                .pc-table, .links {
                    display: none;
                }

                html, body {
                    padding-top: 10px;
                    padding-bottom: 20px;
                }
                .linear{
                    width:100%;
                    height:50px;
                    background: -webkit-linear-gradient(transparent,black);
                    background: -o-linear-gradient(transparent,black);
                    background: -moz-linear-gradient(transparent,black);
                    background: linear-gradient(transparent,black);
                    margin:0px;
                    position: relative;
                    top:110px;
                    bottom: 0px;
                    border-radius: 0px 0px 20px 20px;
                    padding-right: 10px;
                }
            }

            @media screen and (min-width: 812px) {
                #capability {
                    /*display: block;*/
                }

              /*  #mb-capability {
                    display: none;
                }*/

                html, body {
                    padding-top: 10px;
                    padding-bottom: 30px;
                }

              /*  .dropdown {
                    display: none;
                }*/
/*
                .mb-title {
                    display: none;
                }*/
            }

        </style>
    </head>
    <body>
        <div class="dropdown hidden-lg hidden-md hidden-sm" style="margin-left: 10px;">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bars"></i>
            </button>
            <div class="dropdown-menu">
                <a href="{{ url('index') }}" class="dropdown-item"><i class="fas fa-home"></i> 回到首頁</a>
                    @if(Session::get('uid'))
                        <a href="{{ url('account', Session::get('uid')) }}" class="dropdown-item"><i class="fas fa-user-cog"></i> 個人設定</a>
                        
                        <div class="dropdown-divider"></div>

                        @if(Auth::user()->isAdmin())
                            <a href="{{ url('modify') }}" class="dropdown-item"><i class="fas fa-pen" class="dropdown-item"></i> 編輯成員資料</a>
                            <a href="{{ url('announcement/edit') }}" class="dropdown-item"><i class="fas fa-gopuram" class="dropdown-item"></i> 編輯門派公告</a>
                            <a href="{{ url('leave/list') }}" class="dropdown-item"><i class="fas fa-gopuram" class="dropdown-item"></i> 檢視請假記錄</a>
                            
                            <div class="dropdown-divider"></div>
                        @endif

                        <a href="{{ url('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt" class="dropdown-item"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}" class="dropdown-item"><i class="fas fa-sign-in-alt" class="dropdown-item"></i> 會員登入</a>
                        <a href="{{ url('register')}}" class="dropdown-item"><i class="fas fa-hands-helping" class="dropdown-item"></i> 加入我們</a>
                    @endif
            </div>
          </div>

        <div class="flex-center position-ref full-height">

            <div class="content" style="width: 90%">
                <div class="title m-b-md flex-center">
                    <div class="mb-title col-md-10" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:40% 10%; width:90%;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 成員排行</span>
                        </div>
                    </div>
                    
                </div>
                <div class="row bg-info text-white" style="box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:10px;margin-bottom: 10px;">
                    <table width="100%">
                        <tr>
                            <td style="font-size: 24px;font-weight:500;" class="text-left"> 門派公告</td>
                            <td class="text-right" style="font-weight: bold;">
                            @if(isset($announcement->last_update))
                                    {{ date('d M Y',$announcement->last_update) }}
                            @else
                                未設定
                            @endif</td>
                        </tr>
                        <tr>
                            <td colspan="2" style="font-size: 15px;font-weight:bold;" class="text-left">
                                @if(isset($announcement->content))
                                    {!! $announcement->content !!}
                                @else
                                    未設定
                                @endif
                            </td>
                        </tr>
                    </table>
                        
                </div>

                <div class="row flex-center">
                    @php
                        $count = 1;
                    @endphp
                    @foreach($ranking as $rank)
                    <div id="mb-capability" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 10px;">
                        <table width="100%">
                            <tr>
                                <td rowspan="4" width="10%">
                                    <span style="font-weight: bold;font-size: 18px;
                                        @if($count == 1)
                                            color:red;
                                        @elseif($count == 2)
                                            color:orange;
                                        @elseif($count == 3)
                                            color:darkgreen;
                                        @else
                                            color:darkblue;
                                        @endif
                                        ">{{ $count }}
                                    </span>
                                </td>
                                <td width="40%" style="text-align: left;font-weight: bold;">
                                    {{ $rank->lineid }}({{ $rank->gameid }})
                                </td>
                                <td rowspan="2" width="50%" style="padding-right: 8px; text-align: right; font-size: 28px;
                                    @if($rank->capability > 3500000)
                                        color:red;
                                    @elseif(3000000 < $rank->capability)
                                        color:orange;
                                    @elseif(2500000 < $rank->capability)
                                        color:darkgreen;
                                    @else
                                        color:darkblue;
                                    @endif
                                    font-weight: bold">
                                        {{ number_format($rank->capability) }}
                                </td>
                            </tr>
                            <tr>
                                <td width="40%" style="text-align: left;">
                                    Lv.{{ $rank->level }} <span class="badge badge-danger" style="font-size: 10px;">
                                        @if($rank->title != '')
                                            {{ $rank->title }}
                                        @else
                                            未設定
                                        @endif</span>
                                <td class="hidden-sm hidden-xs">
                                    
                                </td>
                                </td>
                            </tr>
                            <tr id="tr-detail" class="hidden-sm hidden-xs">
                                <td colspan="2" style="text-align: left;font-size: 14px;">
                                    參與爭奪次數: {{ $rank->guildwar_times }} ｜ 本次爭奪入場時間: 
                                    @if($rank->approx_entry_time != '')
                                        {{ $rank->approx_entry_time }}
                                    @else
                                        未設定
                                    @endif
                                </td>
                            </tr>
                            <tr id="guildwar_available" class="hidden-sm hidden-xs">
                                <td colspan="2" style="text-align: left;font-size: 14px;">
                                    進攻所屬分組: @if($rank->guildwar_phase_1 != '')
                                        {{ $rank->guildwar_phase_1 }}
                                    @else
                                        未設定
                                    @endif
                                     - 
                                    @if($rank->guildwar_phase_2 != '')
                                        {{ $rank->guildwar_phase_2 }}
                                    @else
                                        未設定
                                    @endif
                                     | 可用爭奪卷數: {{ $rank->roll_qty }}
                                </td>
                            </tr>
                        </table>
                    </div>
                        @php
                            $count+=1;
                        @endphp
                    @endforeach

                    <div style="height: 20px;"></div>

                <!-- <div class="links hidden-sm hidden-xs">
                    <a href="{{ url('index') }}"><i class="fas fa-home"></i> 回到首頁</a>
                    @if(Session::get('uid'))
                        <a href="{{ url('account', Session::get('uid')) }}"><i class="fas fa-user-cog"></i> 個人設定</a>
                        <a href="{{ url('inbox') }}"><i class="fas fa-inbox"></i> 收件匣</a>
                        <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                        <a href="{{ url('register')}}"><i class="fas fa-hands-helping"></i> 加入我們</a>
                    @endif
                </div> -->

            </div>

        </div>
    </body>
    <script>
        $('#capability').on('click', function(){
            location.href = `{{ url('capability') }}`;
        });

        $('#news').on('click', function(){
            location.href = `{{ url('news') }}`;
        });

        $('#guildwar').on('click', function(){
            location.href = `{{ url('guildwar') }}`;
        });

        $('#comment').on('click', function(){
            location.href = `{{ url('comment') }}`;
        });
    </script>
</html>
