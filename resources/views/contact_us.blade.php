<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>聯繫我們</title>

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
                padding-bottom: 70px;
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
                    聯繫無與倫比
                </div>

                @if(Session::has('error_msg')) 
                    <span id="error-msg" class="pull-right" style="color: red;"><i class="fa fa-exclamation-circle"></i> {{ Session::pull('error_msg')}}</span>
                @endif

                <form action="" method="post">
                  @csrf
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="email">電郵地址*</label>
                    <input type="email" class="form-control text-center" id="email" name="email" required="required">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="gameid">遊戲ID*</label>
                    <input type="text" class="form-control text-center" id="gameid" name="gameid" required="required">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="lineid">LINE名稱</label>
                    <input type="text" class="form-control text-center" id="lineid" name="lineid">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="capability">戰力*</label>
                    <input type="text" class="form-control text-center" id="capability" name="capability" required="required">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="area">請選擇所屬地區</label>
                    <!-- <input type="text" class="form-control text-center" id="area" name="area"> -->
                    <select name="area" id="area" class="form-control">
                        <option value="">請選擇所屬地區</option>
                        <option value="台灣">台灣</option>
                        <option value="香港">香港</option>
                        <option value="澳門">澳門</option>
                        <option value="其他國家或地區">其他國家或地區</option>
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="message">留言內容</label>
                    <textarea name="message" id="message" cols="30" rows="5" style="resize: none;" class="form-control"></textarea>
                  </div>

                  <div style="height: 20px;"></div>
                  @if(Session::has('contact_sent'))
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8 disabled" style="width: 300px;"><i class="fa fa-paper-plane"></i> 您的請求已送出</button>
                  @else
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;"><i class="fa fa-paper-plane"></i> 確認送出</button>
                  @endif
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
