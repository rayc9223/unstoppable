<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>門派爭奪數據錄入</title>

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
                padding-top: 10px;
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
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <img src="/images/final_blade_title.png" class="img-fluid" width="50%">
                <div class="title m-b-md">
                    門派爭奪 | 數據錄入
                </div>

                @if(Session::has('error_msg')) 
                    <span id="error-msg" class="pull-right" style="color: red;"><i class="fa fa-exclamation-circle"></i> {{ Session::pull('error_msg')}}</span>
                @endif

                <form action="" method="post">
                  @csrf
                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <!-- <label for="gameid">遊戲ID</label> -->
                    <select name="uid" id="uid" class="form-control">
                        <option value="">請選擇要錄入的遊戲ID</option>
                        @foreach($users as $user)
                            <option value="{{ $user->uid }}">{{ $user->gameid }}</option>
                        @endforeach
                    </select>
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="rank">排名</label>
                    <input type="text" class="form-control text-center" id="rank" name="rank">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="attack_times">參與次數</label>
                    <input type="text" class="form-control text-center" id="attack_times" name="attack_times">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="contribution">貢獻度</label>
                    <input type="text" class="form-control text-center" id="contribution" name="contribution">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="reward">獎勵勾玉</label>
                    <input type="text" class="form-control text-center" id="reward" name="reward">
                  </div>

                  <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2">
                    <label for="guildwar_date">爭奪日期</label>
                    <input type="text" class="form-control text-center" id="guildwar_date" name="guildwar_date" value="{{ date('Y-m-d', time()) }}" readonly>
                  </div>

                  <div style="height: 20px;"></div>
                  <button type="submit" class="btn btn-primary col-lg-4 col-md-4 col-sm-6 col-xs-8" style="width: 300px;">保存數據</button>

                </form>

                <div style="height: 20px;"></div>

                <div class="links">
                    <a href="{{ url('account', Session::get('uid')) }}"><i class="fas fa-user-cog"></i> 個人設定</a>
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                </div>

                <div style="height: 50px;"></div>
            </div>
        </div>
    </body>
</html>
