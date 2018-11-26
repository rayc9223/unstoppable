<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>請選擇成員</title>

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
                padding-top: 70px;
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

            <div class="content">
                <img src="/images/final_blade_title.png" class="img-fluid" width="30%">
                <div class="title m-b-md">
                    請選擇成員
                </div>

                <div class="flex-center" style="width:700px;">
                    <form action="" method="post">
                      @csrf
                    
                    @if(Session::has('error_msg'))
                        <span class="text-danger" style="font-weight: bold; color: red;">{{ Session::get('error_msg') }}</span>
                    @endif
                    <div class="form-group col-lg-6 col-md-6 col-sm-8 col-xs-8 flex-center offset-lg-3 offset-md-3 offset-sm-2 offset-xs-2" style="width: 300px;">
                    <!-- <label for="gameid">遊戲ID</label> -->

                        <select name="uid" id="uid" class="form-control" style="width:260px;
                        @if(Session::has('error_msg'))
                            border-color: red;
                        @endif
                        ">
                            <option value="">請選擇需要編輯的成員</option>
                            @foreach($users as $user)
                                <option value="{{ $user->uid }}">{{ $user->gameid }}</option>
                            @endforeach
                        </select>
                    </div>         

                      <div style="height: 20px;"></div>
                      <button type="submit" class="btn btn-primary col-lg-8"> 下一步</button>
                </form>
                </div>

                <div style="height: 50px;"></div>

                <div class="links">
                    <a href="{{ url('index') }}"><i class="fas fa-home"></i> 回到首頁</a>
                    <a href="{{ url('logout') }}"><i class="fas fa-sign-out-alt"></i> 登出賬號</a>
                </div>
            </div>
        </div>
    </body>
</html>
