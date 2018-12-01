<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>忘記密碼</title>

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
                padding-top: 50px;
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

            <div class="content">
                <img src="/images/final_blade_title.png" class="img-fluid" width="50%">
                <div class="title m-b-md">
                    忘記密碼
                </div>

                <form action="" method="post">
                  @csrf
                  @if(Session::has('error_msg'))
                    <span class="text-danger" style="font-weight: 400;color: red;">{{ Session::get('error_msg') }}</span>
                  @endif
                  @if(Session::has('success_msg'))
                    <span class="text-success" style="font-weight: 400;color: darkgreen;">{{ Session::get('success_msg') }}</span>
                  @endif
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="email">請輸入電郵地址</label>
                    <input type="email" class="form-control text-center" id="email" name="email" value="{{ old('email') }}"
                    @if(Session::has('error_msg'))
                        style="border-color: red;"
                    @endif
                    >
                  </div>
                  

                  <div style="height: 20px;"></div>
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8">獲取密碼重置電郵</button>
                </form>

                <div style="height: 20px;"></div>

                <div class="links">
                    <a href="{{ url('login') }}"><i class="fas fa-fingerprint"></i> 會員登入</a>
                    <a href="{{ url('register')}}"><i class="fas fa-hands-helping"></i> 加入我們</a>
                </div>
            </div>
        </div>
    </body>
</html>
