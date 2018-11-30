<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>修改門派公告 ｜ 爭奪規則</title>

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
                padding-top: 50px;
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
                    修改門派公告 ｜ 爭奪規則
                </div>

                @if(Session::has('error_msg')) 
                    <span id="error-msg" class="pull-right" style="color: red;font-weight: bold;"><i class="fa fa-exclamation-circle"></i> {{ Session::get('error_msg')}}</span>
                @endif

                <form action="" method="post">
                  @csrf
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="type">請選擇類別*</label>
                    @if(Session::has('error_msg'))
                        <select name="type" id="type" class="form-control" style="border-color: red;">
                    @else
                        <select name="type" id="type" class="form-control">
                    @endif
                        <option value="">請選擇內容分類</option>
                        <option value="1">門派公告</option>
                        <!-- <option value="2">招募規則</option> -->
                        <!-- <option value="3">門派爭奪規則</option> -->
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="content">請輸入內容</label>
                    <textarea name="content" id="content" cols="30" rows="8" style="resize: none;" class="form-control"></textarea>
                  </div>

                  <div style="height: 20px;"></div>
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;"> 保存資料</button>
                </form>

                <div style="height: 20px;"></div>

                <div class="links">
                    <a href="{{ url('/') }}"><i class="fas fa-home"></i> 回到首頁</a>
                    <a href="{{ url('login') }}"><i class="fas fa-sign-in-alt"></i> 會員登入</a>
                </div>

                <div style="height: 50px;"></div>
            </div>
        </div>
    </body>
</html>
