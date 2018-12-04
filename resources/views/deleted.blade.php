<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>成員賬號已删除</title>

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
                padding-top: 70px;
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
        </style>
    </head>
    <body>
        <!-- {{ csrf_field() }} -->
        <div class="flex-center position-ref full-height">
            @csrf
            <div class="content">
                <img src="/images/final_blade_title.png" class="img-fluid" width="50%">
                <div class="title m-b-md">
                    成員賬號已删除
                </div>
                <i class="fas fa-check-circle lg text-success" style="font-size: 80px;"></i><br>
                <div style="height: 40px;"></div>
                @if(Session::has('success_msg'))
                    {{ Session::get('success_msg')}}
                @endif
                <div>
                    <a href="{{ url('choose_delete') }}" target="_self" class="btn btn-danger col-4">繼續删除</a>
                </div>

                <div style="height: 40px;"></div>

                <div class="links">
                    <a href="{{ url('index') }}"><i class="fas fa-home"></i> 門派首頁</a>
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                </div>

                <div style="height: 50px;"></div>
            </div>
        </div>
    </body>
</html>
