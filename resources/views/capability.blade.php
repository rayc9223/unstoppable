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
                height:100px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                margin-top: 500px;
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
                    padding-top: 30px;
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

                #mb-capability {
                    display: none;
                }

                html, body {
                    padding-top: 30px;
                    padding-bottom: 30px;
                }

                .dropdown {
                    display: none;
                }

                .mb-title {
                    display: none;
                }
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
                        <a href="{{ url('inbox') }}" class="dropdown-item"><i class="fas fa-inbox" class="dropdown-item"></i> 收件匣</a>
                        <a href="{{ url('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt" class="dropdown-item"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt" class="dropdown-item"></i> 會員登入</a>
                        <a href="{{ url('register')}}"><i class="fas fa-hands-helping" class="dropdown-item"></i> 加入我們</a>
                    @endif
            </div>
          </div>

        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md flex-center">
                    <div class="mb-title hidden-lg hidden-md hidden-sm col-xs-3" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:40% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 成員排行
                        </div>
                    </div>
                </div>

                <div class="row flex-center">
                    @php
                        $count = 1;
                    @endphp
                    @foreach($ranking as $rank)
                    <div id="mb-capability" class="row flex-center" style="width: 90%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 10px;">
                        <table width="100%">
                            <tr>
                                <td rowspan="2" width="10%">
                                    <span style="font-weight: bold;
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
                                <td width="40%" style="text-align: left;">
                                    {{ $rank->lineid }}({{ $rank->gameid }})
                                </td>
                                <td rowspan="2" width="50%" style="font-size: 28px;
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
                                    Lv.{{ $rank->level }} <span class="badge badge-danger" style="font-size: 10px;">{{ $rank->title }}</span>
                                </td>
                            </tr>
                        </table>
                    </div>
                        @php
                            $count+=1;
                        @endphp
                    @endforeach

                    
                    <div id="capability" class="col-lg-2 col-md-2 hidden-sm hidden-xs" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:50% 10%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color:white;font-size: 2.4vw;font-weight: bold;"> 戰力排行
                        </div>
                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12 pc-table" style="width:600px;overflow-y:auto;max-height: 600px;">
                    <div class="container" style="vertical-align: top;">
                            
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>排名</th>
                                    <th>LineID</th>
                                    <th>遊戲ID</th>
                                    <th>等級</th>
                                    <th>戰力</th>
                                    <th>爭奪總次數</th>
                                    @if(Session::has('senior'))
                                        <th>編輯成員資料</th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody style="font-weight: 400;">
                                @php
                                    $count = 1;
                                @endphp
                                @foreach($ranking as $rank)
                                    <tr>
                                        <td style="font-weight: bold;
                                        @if($count == 1)
                                            color: red;
                                        @elseif($count == 2)
                                            color: orange;
                                        @elseif($count == 3)
                                            color: darkgreen;
                                        @else
                                            color: darkblue;
                                        @endif">{{ $count }}</td>
                                        <td>{{ $rank->lineid }}</td>
                                        <td>{{ $rank->gameid }} <span class="badge badge-danger">{{ $rank->title }}</span></td>
                                        <td>{{ $rank->level }}</td>
                                        <td style="font-weight: bold;color: red;">{{ number_format($rank->capability) }}</td>
                                        <td style="font-weight: bold;">{{ number_format($rank->guildwar_times) }}</td>

                                        @if(Session::has('senior'))
                                            <td><a class="btn btn-primary" href="{{ url('account', $rank->uid) }}" target="_blank" title="編輯"><i class="fa fa-pencil"></i></a></td>
                                        @endif
                                    </tr>
                                    @php
                                        $count += 1;
                                    @endphp
                                @endforeach
                            </tbody>

                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>

                <div style="height: 50px;"></div>

                <div class="links hidden-sm hidden-xs">
                    <a href="{{ url('index') }}"><i class="fas fa-home"></i> 回到首頁</a>
                    @if(Session::get('uid'))
                        <a href="{{ url('account', Session::get('uid')) }}"><i class="fas fa-user-cog"></i> 個人設定</a>
                        <a href="{{ url('inbox') }}"><i class="fas fa-inbox"></i> 收件匣</a>
                        <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                        <a href="{{ url('register')}}"><i class="fas fa-hands-helping"></i> 加入我們</a>
                    @endif
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
