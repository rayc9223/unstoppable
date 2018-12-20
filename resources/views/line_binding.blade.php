<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>登記LINE連動</title>

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
                padding-top: 40px;
                /*height: 110vh;*/
                margin: 0;
            }

            .full-height {
                /*height: 120vh;*/
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

            .notice {
                font-size: 1.2em;
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
                <img src="/images/final_blade_title.png" class="img-fluid" width="300px;">
                <div class="title m-b-md">
                    登記<i class="fab fa-line"></i>LINE連動
                </div>

                <div class="notice m-b-md col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <span style="font-size: 1.0em;font-weight: 600">*什麼是LINE_USER_ID?</span><br>
                    <span style="font-size: 0.8em; font-weight: 600;">
這裡LINE_USER_ID並非指LINE使用者之名稱，而是LINE用於識別使用者的唯一標識，用以區分不同的使用者
LINE_USER_ID屬於使用者之個人隠私，為避免LINE帳號受到不明來歷之惡意攻擊，請勿將該組ID張貼在公共群組或與他人分享。</span>
                </div>

                <div class="notice m-b-md col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <span style="font-size: 1.0em;font-weight: 600">為什麼要登記連動?</span><br>
                    <span style="font-size: 0.8em; font-weight: 600;">
                        登記與網站連動後，您可以使用無與倫比網站助手(LINE Bot)的便捷功能，省確重複登入網站的動作</span>
                </div>

                @if(Session::has('error_msg')) 
                    <span id="error-msg" class="pull-right" style="color: red;"><i class="fa fa-exclamation-circle"></i> {{ Session::pull('error_msg')}}</span>
                @endif

                <form action="{{ url('line_binding')}}" method="post">
                  @csrf
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="line_userid">LINE USER ID*</label>
                    <input type="line_userid" class="form-control text-center" id="line_userid" name="line_userid" required="required" value="{{ $line_userid }}">
                  </div>
        
                  <div style="height: 20px;"></div>
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;">確認連動</button>
                </form>

                <div style="height: 20px;"></div>

                <div class="links">
                    @if(Auth::user())
                        <a href="{{ url('index') }}"><i class="fas fa-home"></i> 首頁</a>
                        <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                        <a href="{{ url('register/show')}}"><i class="fas fa-hands-helping"></i> 加入我們</a>
                    @endif
                </div>

                <div style="height: 50px;"></div>
            </div>
        </div>
    </body>
</html>
