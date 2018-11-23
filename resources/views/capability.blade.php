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

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
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
                font-size: 2.5em;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .linear{
                width:100%;
                height:150px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                margin-top: 450px;
                border-radius: 20px;
            }

        </style>
    </head>
    <body>
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

            <!-- {{ print_r($ranking) }} -->
            <div class="content">
                <!-- <img src="/images/final_blade_title.png" class="img-fluid" width="100px;"> -->
                <div class="title m-b-md">
                    門派成員
                </div>

                <div class="row flex-center">
                    <div id="capability" class="col-lg-2 col-md-2 col-sm-2 hidden-xs" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:50% 10%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 戰力排行
                        </div>
                    </div>

                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12" style="width: 800px;overflow-y:auto;max-height: 600px;">
                        <table class="table table-borderd">
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

                <div class="links">
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
