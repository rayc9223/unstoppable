<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>相關連結</title>

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
                margin: 0 auto;
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
    <body class="flex-center">
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
                            <a href="{{ url('leave/list') }}" class="dropdown-item"><i class="fas fa-file-alt" class="dropdown-item"></i> 檢視請假記錄</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item bg-danger text-white" data-toggle="modal" data-target="#resetWarningModal"><i class="fas fa-exclamation-circle" class="dropdown-item"></i> 重置入場時間</a>
                            <div class="dropdown-divider"></div>
                        @endif

                        <a href="{{ url('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt" class="dropdown-item"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}" class="dropdown-item"><i class="fas fa-sign-in-alt" class="dropdown-item"></i> 會員登入</a>
                        <a href="{{ url('register')}}" class="dropdown-item"><i class="fas fa-hands-helping" class="dropdown-item"></i> 加入我們</a>
                    @endif
            </div>

        <div class="flex-center position-ref full-height" style="max-width: 1250px;">

            <div class="content" style="width: 90%">
                <div class="title m-b-md flex-center">
                    <div class="mb-title col-md-10" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:40% 20%; width:90%;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;margin-right: 10px;"> 遊戲相關連結</span>
                        </div>
                    </div>
                    
                </div>
                <div class="row bg-warning text-white" style="box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:10px;margin-bottom: 10px;">
                    <table width="100%">
                        <!-- <tr>
                            <td style="font-size: 24px;font-weight:500;" class="text-left"> 未設定</td>
                            <td class="text-right" style="font-weight: bold;">
                            @if(isset($announcement->last_update))
                                    {{ date('d M Y',$announcement->last_update) }}
                            @else
                                未設定
                            @endif</td>
                        </tr> -->
                        <tr>
                            <td colspan="2" style="font-size: 15px;font-weight:bold;" class="text-left">
                                <!-- @if(isset($announcement->content))
                                    {!! $announcement->content !!}
                                @else
                                    未設定
                                @endif -->
                                歡迎大家提供遊戲相關連結
                            </td>
                        </tr>
                    </table>
                        
                </div>

                <div class="row flex-center">
                    <div id="bahamut" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 20px;cursor: pointer;">
                        <table width="100%" style="padding: 0px;">
                            <tr style="font-weight: bold;">
                                <td class="text-left bg-info text-white" style="padding: 10px;">
                                    巴哈姆特 - 英雄不滅 哈啦區
                                </td>
                                <td class="text-right bg-info text-white" style="padding: 10px;">
                                    <a href="https://forum.gamer.com.tw/B.php?bsn=33969&subbsn=0" target="_blank" style="text-decoration: none;color: white;">點此前往</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;padding: 0px;">
                                    <img src="/images/bahamut.JPG" class="img-fluid float-center">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div id="final-blade-youtube" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 20px;cursor: pointer;">
                        <table width="100%" style="padding: 0px;">
                            <tr style="font-weight: bold;">
                                <td class="text-left bg-danger text-white" style="padding: 10px;">
                                    YOUTUBE - 英雄不滅 TV
                                </td>
                                <td class="text-right bg-danger text-white" style="padding: 10px;">
                                    <a href="https://www.youtube.com/channel/UC5TrEKbNJEMSq68e_74g6Bg" target="_blank" style="text-decoration: none;color: white;">點此前往</a>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2" style="text-align: left;padding: 0px;">
                                    <img src="/images/Final_Blade_TV.png" class="img-fluid float-center">
                                </td>
                            </tr>
                        </table>
                    </div>

                    <div style="height: 20px;"></div>

                <div class="links hidden-sm hidden-xs">
                    <a href="{{ url('index') }}">無與倫比 &copy; 2018</a>
                </div>
            </div>
        </div>
    </body>
    <script>
        $('#bahamut').on('click', function(){
            window.open('https://forum.gamer.com.tw/B.php?bsn=33969&subbsn=0', '_blank');
        });

        $('#final-blade-youtube').on('click', function(){
            window.open('https://www.youtube.com/channel/UC5TrEKbNJEMSq68e_74g6Bg', '_blank');
        })
    </script>
</html>
