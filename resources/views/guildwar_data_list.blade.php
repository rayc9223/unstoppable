<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>門派爭奪數據統計</title>

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
                /*padding-top: 30px;*/
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
                margin-bottom: 24px;
            }

            .linear{
                width:100%;
                height:50px;
                background: -webkit-linear-gradient(transparent,black);
                background: -o-linear-gradient(transparent,black);
                background: -moz-linear-gradient(transparent,black);
                background: linear-gradient(transparent,black);
                position: relative;
                top:110px;
                border-radius: 0 0 20px 20px;
            }

            @media screen and (max-width: 500px) {
                #capability {
                    display: none;
                }

                #mb-capability {
                    display: block;
                }

               /* .links {
                    display: none;
                }*/

                .pc-table, .links {
                    display: none;
                }

                html, body {
                    padding-top: 10px;
                    padding-bottom: 20px;
                }
                .linear{
                    width:100%;
                    height:50px;
                    background: -webkit-linear-gradient(transparent,black);
                    background: -o-linear-gradient(transparent,black);
                    background: -moz-linear-gradient(transparent,black);
                    background: linear-gradient(transparent,black);
                    margin:0px;
                    position: relative;
                    top:110px;
                    bottom: 0px;
                    border-radius: 0px 0px 20px 20px;
                    padding-right: 10px;
                }
            }

            @media screen and (min-width: 812px) {
                #capability {
                    /*display: block;*/
                }

                html, body {
                    padding-top: 10px;
                    padding-bottom: 30px;
                }
            }

        </style>
    </head>
    <body>
        <div class="dropdown hidden-lg hidden-md hidden-sm" style="margin-left: 10px;">
            <button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
              <i class="fa fa-bars"></i>
            </button>
            <div class="dropdown-menu">
                <a href="{{ url('index') }}" class="dropdown-item"><i class="fas fa-home"></i> 回到首頁</a>
                    @if(Session::get('uid'))
                        <a href="{{ url('account', Session::get('uid')) }}" class="dropdown-item"><i class="fas fa-user-cog"></i> 個人設定</a>
                        
                        <div class="dropdown-divider"></div>

                        @if(Auth::user()->isAdmin())
                            <a href="{{ url('modify') }}" class="dropdown-item"><i class="fas fa-pen" class="dropdown-item"></i> 編輯成員資料</a>
                            <a href="{{ url('announcement/edit') }}" class="dropdown-item"><i class="fas fa-gopuram" class="dropdown-item"></i> 編輯門派公告</a>
                            <a href="{{ url('leave/list') }}" class="dropdown-item"><i class="fas fa-file-alt" class="dropdown-item"></i> 檢視請假記錄</a>
                            
                            <div class="dropdown-divider"></div>
                        @endif

                        <a href="{{ url('logout') }}" class="dropdown-item"><i class="fas fa-sign-out-alt" class="dropdown-item"></i> 登出賬號</a>
                    @else
                        <a href="{{ url('login') }}" class="dropdown-item"><i class="fas fa-sign-in-alt" class="dropdown-item"></i> 會員登入</a>
                        <a href="{{ url('register')}}" class="dropdown-item"><i class="fas fa-hands-helping" class="dropdown-item"></i> 加入我們</a>
                    @endif
            </div>
          </div>

        <div class="flex-center position-ref full-height">

            <div class="content" style="width: 90%">
                <div class="title m-b-md flex-center">
                    <div class="mb-title col-md-10" style="border-radius: 20px;background-image: url('/images/princess.png');background-position:40% 20%; width:90%;height:160px;padding: 0px;cursor: pointer;">
                        <div class="linear text-right">
                            <span style="color: white;font-size: 26px;font-weight: bold;"> 數據統計
                        </div>
                    </div>
                </div>

                <div class="row flex-center">
                    <div id="mb-capability" class="row flex-center" style="width: 100%;box-shadow: 0 0 20px 0px rgba(0, 0, 0, 0.15);padding:0px;margin-bottom: 10px;">
                    <table class="table" style="font-weight: 600;">
                        <thead>
                            <tr>
                                <th width="10%">排名</th>
                                <th width="15%">遊戲ID</th>
                                <th width="5%">參與次數</th>
                                <th width="20%">貢獻度</th>
                                <th width="15%">獎勵勾玉數</th>
                                <th width="20%">爭奪日期</th>
                                @if(Auth::user()->isAdmin())
                                <th width="5%">操作</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($records as $record)
                                <tr>
                                    <td>
                                        @if($record->rank == 0)
                                            未參與該次爭奪
                                        @else
                                            {{ $record->rank }}
                                        @endif
                                    </td>
                                    <td>{{ $record->gameid }}</td>
                                    <td>{{ $record->attack_times }}</td>
                                    <td>{{ $record->contribution }}</td>
                                    <td>{{ $record->reward }}</td>
                                    <td>{{ $record->guildwar_date }}</td>
                                    @if(Auth::user()->isAdmin())
                                    <td>
                                    <a name="toggleTag_{{ $record->id }}" data-id="{{ $record->id }}" data-link="{{ url('raise_delete_flag', ['record_id'=>$record->id])}}" data-gameid="{{ $record->gameid }}" class="btn btn-danger btn-sm text-white" data-toggle="modal" data-target="#raiseDeleteModal"><i class="fa fa-trash"></i>
                                    </td>
                                    @endif

                                        <!-- <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#raiseDeleteModal"><i class="fas fa-trash"></i></a> -->
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                    <div style="height: 30px;"></div>

        <div class="links">
            <a href="{{ url('index') }}">無與倫比 | 赤焰 | 夜雨花落 &copy; 2018</a>
        </div>

            </div>

            <!-- Reset Warning Here -->
                <div class="modal fade" id="raiseDeleteModal" style="margin-top: 200px;">
                  <div class="modal-dialog">
                    <div class="modal-content">
                 
                      <div class="modal-header">
                        <h4 class="modal-title"><i class="fa fa-exclamation-circle text-danger"></i> 數據删除警告</h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                      </div>
                 
                      <div id="delete-content" class="modal-body text-left">
                        
                      </div>
                 
                      <div class="modal-footer">
                        <button id="confirm-delete" type="button" class="btn btn-danger" data-dismiss="modal">確認删除</button>
                        <button type="button" class="btn btn-primary" data-dismiss="modal">取消</button>
                      </div>
                 
                    </div>
                  </div>
                </div>

        </div>
    </body>
    <script>
        $("a[name^=\'toggleTag_\']").on('click', function(e){
            var id = $(this).attr("data-id");
            var link = $(this).attr("data-link");
            var gameid = $(this).attr("data-gameid");
            $('#delete-content').html('以下數據將於確認後進行删除:<br><br><span class="text-danger" style="font-weight: 600">記錄編號: ' + id + '<br>遊戲ID為: ' + gameid + ' 的門派爭奪數據</span><br><br>確認要執行嗎?');

            $('#confirm-delete').on('click', function(){
                location.href = link;
            })
        })
    </script>
</html>
