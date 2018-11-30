<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>會員註冊</title>

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
                height: 110vh;
                margin: 0;
            }

            .full-height {
                height: 120vh;
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
                    無與倫比 | 會員註冊
                </div>

                @if(Session::has('error_msg')) 
                    <span id="error-msg" class="pull-right" style="color: red;"><i class="fa fa-exclamation-circle"></i> {{ Session::pull('error_msg')}}</span>
                @endif

                <form action="" method="post">
                  @csrf
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="email">電郵地址*</label>
                    <input type="email" class="form-control text-center" id="email" name="email" required="required" value="{{ old('email') }}">
                  </div>
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="pwd">密碼*</label>
                    <input type="password" class="form-control text-center" id="pwd" name="pwd" required="required">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="confirm_pwd">確認密碼*</label>
                    <input type="password" class="form-control text-center" id="confirm_pwd" name="confirm_pwd" required="required">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="gameid">遊戲ID</label>
                    <input type="text" class="form-control text-center" id="gameid" name="gameid" value="{{ old('gameid') }}">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="lineid">LINE名稱</label>
                    <input type="text" class="form-control text-center" id="lineid" name="lineid" value="{{ old('lineid') }}">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="invitation_code">邀請碼(新會員請透過以下連結申請邀請碼)</label>
                    <input type="text" class="form-control text-center" id="invitation_code" name="invitation_code" value="{{ old('invitation_code') }}">
                  </div>

                  <a href="{{ url('contact_us') }}" target="_blank" title="申請加入無與倫比" class="btn btn-success col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;">申請邀請碼</a>
                  {{-- <a href="http://line.me/ti/g/E0tuhiJXuX" target="_blank" title="申請加入無與倫比LINE群組" class="btn btn-success col-lg-4 col-md-4 col-sm-6 col-xs-8 disabled" style="width: 300px;">申請邀請碼</a> --}}

                  <div style="height: 20px;"></div>
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;">確認註冊</button>
                </form>

                <div style="height: 20px;"></div>

                <div class="links">
                    <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                </div>

                <div style="height: 50px;"></div>
            </div>
        </div>
    </body>
</html>
