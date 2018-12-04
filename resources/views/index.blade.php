<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>門派首頁</title>

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
                height:150px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                margin-top: 450px;
                border-radius: 0 0 20px 20px;
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

            @media screen and (min-width: 812px) {
                #pc-block {
                    /*display: block;*/
                }

                #mobile-block {
                    display: none;
                }

                html, body {
                    padding-top: 30px;
                    padding-bottom: 30px;
                }
            }

        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @csrf
            <div class="content">
                <div class="title m-b-md">
                    @if($user)
                        {{ $user->lineid }}, 
                    @endif
                    歡迎回到
                    @if($user->guild=='無與倫比')
                        無與倫比
                    @elseif($user->guild=='夜雨花落')
                        夜雨花落
                    @else
                        門派專頁
                    @endif
                </div>

                <div class="row flex-center" id="pc-block">
                    <div id="capability" class="col-lg-2 col-md-2 hidden-sm hidden-xs" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:50% 10%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 成員排行
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="flyer" class="col-lg-2 col-md-2 hidden-sm hidden-xs" style="border-radius: 20px;background-image: url('/images/prince.png');background-position:40% 20%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 門派爭奪
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="relative-links" class="col-lg-2 col-md-2 hidden-sm hidden-xs" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:38% 40%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 相關連結
                        </div>
                    </div>

                    <div style="width:16px;"></div>

                    <div id="posts" class="col-lg-2 col-md-2 hidden-sm hidden-xs" style="border-radius: 20px;background-image: url('/images/yan_long.png');background-position:40% 40%; width: 400px;height: 600px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right" style="padding-top: 80px;padding-right: 20px;">
                            <span style="color: white;font-size: 2.4vw;font-weight: bold;"> 留言區
                        </div>
                    </div>
                </div>

                <div class="row flex-center hidden-lg hidden-md" id="mobile-block" style="padding-left: 10px;">
                   
                    <div id="mb-capability" class="hidden-lg hidden-md hidden-sm col-xs-3" style="border-radius: 20px;background-image: url('/images/yuek_kei.png');background-position:40% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 成員排行
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

                    <div id="mb-flyer" class="hidden-lg hidden-md hidden-sm col-xs-3" style="border-radius: 20px;background-image: url('/images/prince.png');background-position:35% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 數據統計
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

        
                    <div id="mb-relative-links" class="hidden-lg hidden-md hidden-sm col-xs-3" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:35% 20%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 門派爭奪
                        </div>
                    </div>
                    <div style="height: 10px;"></div>

           

                    <div id="mb-posts" class="hidden-lg hidden-md hidden-sm col-xs-3" style="border-radius: 20px;background-image: url('/images/yan_long.png');background-position:35% 10%; width:350px;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 留言區
                        </div>
                    </div>
                </div>

                <div style="height: 50px;"></div>

                <div class="links flex-center">
                    <a href="{{ url('account', Session::get('uid')) }}"><i class="fas fa-user-cog"></i> 個人設定</a>
                    <!-- <a href="{{ url('inbox') }}"><i class="fas fa-inbox"></i> 收件匣</a> -->
                    @if(Auth::user()->isAdmin())
                        <a href="{{ url('guildwar_update') }}"><i class="fas fa-pencil-alt"></i> 數據錄入</a>
                    @endif
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                </div>
            </div>
        </div>
    </body>
    <script>
        $('#capability').on('click', function(){
            location.href = `{{ url('capability') }}`;
        });

        $('#mb-capability').on('click', function(){
            location.href = `{{ url('capability') }}`;
        });

        $('#flyer').on('click', function(){
            location.href = `{{ url('flyer') }}`;
        });

        $('#mb-flyer').on('click', function(){
            location.href = `{{ url('flyer') }}`;
        });

        $('#relative-links').on('click', function(){
            location.href = `{{ url('relative_links') }}`;
        });

        $('#mb-relative-links').on('click', function(){
            location.href = `{{ url('relative_links') }}`;
        });

        // $('#posts').on('click', function(){
        //     location.href = `{{ url('post_list') }}`;
        // });

        // $('#mb-posts').on('click', function(){
        //     location.href = `{{ url('post_list') }}`;
        // });
    </script>
</html>
