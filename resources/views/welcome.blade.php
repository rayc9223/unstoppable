<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>無與倫比 | 夜雨花落 門派專頁</title>

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
                padding-top: 80px;
                /*height: 100vh;*/
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
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @csrf
            <div class="content">
                <img src="/images/final_blade_title.png" class="img-fluid">
                <div class="title m-b-md">
                    歡迎來到<br>無與倫比 | 夜雨花落
                </div>

                <div class="links">
                    @if(Auth::user())
                        <a href="{{ url('index') }}"><i class="fas fa-home"></i> 首頁</a>
                    @else
                        <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                        <a href="{{ url('register')}}"><i class="fas fa-hands-helping"></i> 加入我們</a>
                    @endif
                    <a href="{{ url('contact_us')}}"><i class="fas fa-envelope"></i> 聯繫我們</a>
                    @if(Auth::user())
                        <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                    @endif
                </div>
            </div>
        </div>
    </body>
</html>
