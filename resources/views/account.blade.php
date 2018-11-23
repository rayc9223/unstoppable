<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>個人設定</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link href="/css/bootstrap.min.css" rel="stylesheet" type="text/css">
        <script defer src="/js/brands.js"></script>
        <script defer src="/js/solid.js"></script>
        <script defer src="/js/fontawesome.js"></script>
        <!-- <link href="/css/fontawesome.css" rel="stylesheet" type="text/css"> -->
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous"> -->



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
                /*height: 120vh;*/
                margin: 0;
                padding-bottom: 30px;
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
                font-size: 2.5em;
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

/*            .linear{
                width:100%;
                height:150px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                margin-top: 450px;
                border-radius: 20px;
            }*/

        </style>
    </head>
    <body>
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
                <img src="/images/final_blade_title.png" class="img-fluid" width="30%">
                <div class="title m-b-md">
                    個人設定
                </div>

                <div class="flex-center" style="width:700px;">
                    <form action="" method="post">
                      @csrf
                      <div class="form-group" style="width: 300px;">
                        <label for="capability">戰力</label>
                        <input type="text" class="form-control text-center" id="capability" name="capability" value="{{ $user->capability }}">
                      </div>

                      <div class="form-group">
                        <label for="email">電郵地址</label>
                        <input type="email" class="form-control text-center" id="email" name="email" readonly value="{{ $user->email }}">
                      </div>

                      <div class="form-group">
                        <label for="pwd">密碼(如無需修改請留空)</label>
                        <input type="password" class="form-control text-center" id="pwd" name="pwd">
                      </div>

                      <div class="form-group">
                        <label for="confirm_pwd">確認密碼</label>
                        <input type="password" class="form-control text-center" id="confirm_pwd" name="confirm_pwd">
                      </div>

                      <div class="form-group">
                        <label for="gameid">遊戲ID</label>
                        <input type="text" class="form-control text-center" id="gameid" name="gameid" value="{{ $user->gameid }}">
                      </div>

                      <div class="form-group">
                        <label for="lineid">LINE名稱</label>
                        <input type="text" class="form-control text-center" id="lineid" name="lineid" value="{{ $user->lineid }}">
                      </div>

                      <div class="form-group">
                        <label for="level">等級</label>
                        <input type="text" class="form-control text-center" id="level" name="level" value="{{ $user->level }}">
                      </div>

                      <div class="form-group">
                        <label for="roll_qty">可用爭奪卷數</label>
                        <input type="text" class="form-control text-center" id="roll_qty" name="roll_qty" value="{{ $user->roll_qty }}">
                      </div>

                      <!-- <div class="form-group">
                        <label for="invitation_code">邀請碼(新會員請透過以下連結申請邀請碼)</label>
                        <input type="text" class="form-control text-center" id="invitation_code" name="invitation_code">
                      </div> -->

                      <div class="form-group">
                        <label for="title">職務</label>
                        <select name="title" id="title" class="form-control">
                            <option value="請選擇職務">請選擇職務</option>
                            @foreach($titles as $title)
                                @if($title==$user->title)
                                    <option value="{{ $title }}" selected="selected">{{ $title }}</option>
                                @else
                                    <option value="{{ $title }}">{{ $title }}</option>
                                @endif
                            @endforeach
                        </select>                    
                      </div>

                      <div class="form-group">
                        <label for="reason">門派爭奪</label>
                        <select name="reason" id="reason" class="form-control">
                            <option value="請選擇爭奪進場時間">請選擇爭奪進場時間</option>
                            @foreach($reasons as $reason)
                                @if($reason==$user->approx_entry_time)
                                    <option value="{{ $reason }}" selected="selected">{{ $reason }}</option>
                                @else
                                    <option value="{{ $reason }}">{{ $reason }}</option>
                                @endif
                            @endforeach
                        </select>                    
                      </div>

                      <div style="height: 20px;"></div>
                      <button type="submit" class="btn btn-primary col-lg-8">保存資料</button>
                </form>
                </div>

                <div style="height: 50px;"></div>

                <div class="links">
                    <a href="{{ url('index') }}"><i class="fas fa-home"></i> 回到首頁</a>
                    <a href="{{ url('inbox') }}"><i class="fas fa-inbox"></i> 收件匣</a>
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                </div>
            </div>
        </div>
    </body>
</html>
