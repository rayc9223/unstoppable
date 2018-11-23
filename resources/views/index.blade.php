<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>無與倫比 | 門派專頁</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script defer src="/js/brands.js"></script>
        <script defer src="/js/solid.js"></script>
        <script defer src="/js/fontawesome.js"></script>
        <!-- <link href="/css/fontawesome.css" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->



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
                height:150px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                margin-top: 450px;
                border-radius: 20px;
            }

            @media screen and (max-width: 500px) {
                #pc-block {
                    display: none;
                }

                #mobile-block {
                    display: block;
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

            <div class="content">
                <!-- <img src="/images/final_blade_title.png" class="img-fluid"> -->
                <div class="title m-b-md">
                    {{ $name }}, 歡迎回到無與倫比
                </div>

                <div class="row flex-center" id="pc-block">
                    <div id="capability" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:50% 10%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 成員排行
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="news" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-radius: 20px;background-image: url('/images/prince.png');background-position:40% 20%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 門派公告
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="guildwar" class="col-lg-2 col-md-2 col-sm-2 col-xs-2" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:38% 40%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 門派爭奪
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="comment" class="" style="border-radius: 20px;background-image: url('/images/yan_long.png');background-position:40% 40%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 留言區
                        </div>
                    </div>
                </div>

                <div class="row flex-center" id="mobile-block" style="padding-left: 10px;">
                   
                    <div id="capability" class="col-xs-3" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:40% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 成員排行
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

                    <div id="news" class="col-xs-3" style="border-radius: 20px;background-image: url('/images/prince.png');background-position:35% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 門派公告
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

        
                    <div id="guildwar" class="col-xs-3" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:35% 20%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 門派爭奪
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

           

                    <div id="comment" class="col-xs-3" style="border-radius: 20px;background-image: url('/images/yan_long.png');background-position:35% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 留言區
                        </div>
                    </div>
                </div>

                <div style="height: 50px;"></div>

                <div class="links flex-center">
                    <a href="{{ url('account', Session::get('uid')) }}"><i class="fas fa-user-cog"></i> 個人設定</a>
                    <a href="{{ url('inbox') }}"><i class="fas fa-inbox"></i> 收件匣</a>
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
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
