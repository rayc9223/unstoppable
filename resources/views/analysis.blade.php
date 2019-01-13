<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>數據統計</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script defer src="/js/brands.js"></script>
        <script defer src="/js/solid.js"></script>
        <script defer src="/js/fontawesome.js"></script>

        <script type="text/javascript" src="/js/app.js"></script>
        <script type="text/javascript" src="/js/bootstrap.min.js"></script>
        <script type="text/javascript" src="/js/jquery.3.3.1.min.js"></script>

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

            <div class="content" style="width: 80%">
                <div class="title m-b-md flex-center">
                    <div class="mb-title col-md-10" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:40% 10%; width:90%;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 數據統計
                        </div>
                    </div>
                </div>

                <div class="row flex-center">
                    <div id="mb-capability" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 10px;">
                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                    <table class="table" style="font-weight: 600;width: 1100px;">
                        <thead>
                            <tr>
                                <th width="30%">統計類目</th>
                                <th width="10%">人數</th>
                                <th width="60%">成員名單</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    總計註册
                                </td>
                                <td>
                                    {{ $data['total_users'] }}
                                </td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>預計準時進場</td>
                                <td>
                                    @if(count($data['ontime']) < 10)
                                        <span style="color:red;">{{ count($data['ontime']) }}</span>
                                    @else
                                        {{ count($data['ontime']) }}
                                    @endif</td>
                                <td></td>
            
                            </tr>
                            <tr>
                                <td>晚到</td>
                                <td>
                                    {{ $data['late'] }}
                                </td>
                                <td>
                                    
                                            <div class="panel-heading">
                                                <h6 class="panel-title">
                                                    <a data-toggle="collapse" data-parent="#accordion" 
                                                       href="#collapseOne">
                                                        點此檢視詳情
                                                    </a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                            <div id="collapseOne" class="panel-collapse collapse in">
                                <div class="panel-body">
                            <table class="table" style="font-weight: 600;">
                                <tr>
                                    <td width="30%">晚到10分鐘</td>
                                    <td width="10%">{{ count($data['late_by_10']) }}</td>
                                    <td width="60%">
                                        @foreach($data['late_by_10'] as $member)
                                            @if($loop->last)
                                                {{ $member->lineid }}
                                            @else
                                                {{ $member->lineid }} | 
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>晚到20分鐘</td>
                                    <td>{{ count($data['late_by_20']) }}</td>
                                    <td>
                                        @foreach($data['late_by_20'] as $member)
                                            @if($loop->last)
                                                {{ $member->lineid }}
                                            @else
                                                {{ $member->lineid }} | 
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                                <tr>
                                    <td>晚到30分鐘（或以上）</td>
                                    <td>{{ count($data['late_by_30']) }}</td>
                                    <td>
                                        @foreach($data['late_by_30'] as $member)
                                            @if($loop->last)
                                                {{ $member->lineid }}
                                            @else
                                                {{ $member->lineid }} | 
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                        </table>
                        </div>
                    </div>
                
                    <table class="table" style="font-weight: 600;width: 1100px;">
                        <tbody>
                            <tr>
                                <td width="30%">無法參加本次爭奪</td>
                                <td width="10%">
                                    @if(count($data['absent']) > 3)
                                        <span style="color:red;">{{ count($data['absent']) }}</span>
                                    @else
                                        {{ count($data['absent']) }}
                                    @endif</td>
                                <td width="60%">
                                    @foreach($data['absent'] as $member)
                                        @if($loop->last)
                                            {{ $member->lineid }}
                                        @else
                                            {{ $member->lineid }} | 
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                            <tr>
                                <td>未設定入場時間</td>
                                <td>
                                    @if(count($data['approx_undefined']) > 5)
                                        <span style="color:red;">{{ count($data['approx_undefined']) }}</span>
                                    @else
                                        {{ count($data['approx_undefined']) }}
                                    @endif
                                </td>
                                <td>
                                    @foreach($data['approx_undefined'] as $member)
                                        @if($loop->last)
                                            {{ $member->lineid }}
                                        @else
                                            {{ $member->lineid }} | 
                                        @endif
                                    @endforeach
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>
            <div id="mb-capability" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 10px;">
                <table class="table" style="font-weight: 600;width: 1100px;">
                    <thead>
                        <th width="10%"></th>
                        <th width="15%">丹紅 
                            @if($tanhung['teamCount'])
                                ( {{ $tanhung['teamCount'] }} )
                            @endif
                        </th>
                        <th width="15%">蓮慕
                            @if($linmo['teamCount'])
                                ( {{ $linmo['teamCount'] }} )
                            @endif
                        </th>
                        <th width="20%">塞羅 ( {{ $choilo['teamCount'] }} )</th>
                        <th width="20%">大豪 ( {{ $taiho['teamCount'] }} )</th>
                        <th width="20%">鬼怪 ( {{ $buff['teamCount'] }} )</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>晚到</td>
                            <td></td>
                            <td></td>
                            <td class="text-left">
                                @if($choilo['teamLateCount'])
                                    ( {{ $choilo['teamLateCount'] }} ) {{ $choilo['teamLateList'] }}
                                @endif
                            </td>
                            <td class="text-left">
                                @if($taiho['teamLateCount'])
                                    ( {{ $taiho['teamLateCount'] }} ) {{ $taiho['teamLateList'] }}
                                @endif
                            </td>
                            <td class="text-left">
                                @if($buff['teamLateCount'])
                                    ( {{ $buff['teamLateCount'] }} ) {{ $buff['teamLateList'] }}
                                @endif
                            </td>
                            
                        </tr>

                        <tr>
                            <td>請假</td>
                            <td></td>
                            <td></td>
                            <td class="text-left">
                                @if($choilo['teamLeaveCount'])
                                    ( {{ $choilo['teamLeaveCount'] }} ) {{ $choilo['teamLeaveList'] }}
                                @endif
                            </td>
                            <td class="text-left">
                                @if($taiho['teamLeaveCount'])
                                    ( {{ $taiho['teamLeaveCount'] }} ) {{ $taiho['teamLeaveList']}}
                                @endif
                            </td>
                            <td class="text-left">
                                @if($buff['teamLeaveCount'])
                                    ( {{ $buff['teamLeaveCount'] }} ) {{ $buff['teamLeaveList']}}
                                @endif
                            </td>
                       
                        </tr>
                    </tbody>
                </table>
            </div>
                    <div style="height: 30px;"></div>

        <div class="links">
            <a href="{{ url('index') }}">無與倫比 | 夜雨花落 &copy; 2018</a>
        </div>

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
