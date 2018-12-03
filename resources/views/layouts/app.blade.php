<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', '無與倫比') }}</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <script defer src="/js/brands.js"></script>
    <script defer src="/js/solid.js"></script>
    <script defer src="/js/fontawesome.js"></script>

    <script type="text/javascript" src="/js/app.js"></script>
    <script type="text/javascript" src="/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="/js/jquery.3.3.1.min.js"></script>

    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/bootstrap.css" rel="stylesheet">
    <link href="/css/font-awesome.min.css" rel="stylesheet">
    <link href="/css/post.css" rel="stylesheet">
    {!! editor_css() !!}
    <script src="/js/app.js"></script>
    <script src="/js/jquery-3.2.1.min.js"></script>

    <!-- Styles -->
        <style>
            html, body {
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                /*height: 100vh;*/
                padding-top: 20px;
                margin: 0;
            }
            td {
                padding: 5px;
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
    <!-- Drop Down Menu -->
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
          </div>
        <!-- Drop Down Menu -->
    <div class="sep10"></div>

    <div id="app" class="flex-center position-ref full-height">
        @yield('content')
    </div>

    @include('footer')


    <!-- Scripts -->
    <script type="text/javascript">
        $('#btn-reg').on('click', function(){
            location.href= `{{ url('/register') }}`;
        });
    </script>
</body>
</html>
