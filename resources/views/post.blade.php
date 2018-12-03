@extends('layouts.app')

@section('content')

<div id="post" class="col-12">
    <div id="main">
        <div id="detail" class="box">
        <div style="padding: 0px 10px;background-color: white; border-radius: 3px 3px 0 0;">
            <table width="100%">
                <tr>
                    <td>
                        <a href="{{ url('post_list') }}">無與倫比</a> > <a href="">{{ $node_name }}</a>
                    </td>
                    <td rowspan="2">
                        @if(0>1)
                        <img src="" alt="">
                        @else
                        <img src="{{ '/images/'. mt_rand(1,5) .'.png' }}" alt="" width="73px" height="73px" style="border-radius: 4px;">
                        @endif
                    </td>
                </tr>
                <tr>
                    <td width="90%">
                        <h4>{{ $post->title }}</h4>
                    </td>
                </tr>
            </table>    
        </div>
        <div style="padding: 0px 10px 10px;background-color: white;">
            <table width="100%">
                <tr style="border-bottom: 1px solid #CCC;">
                    <td width="30%">
                        <div class="row" style="width: 130px;">
                            <div class="col-5" style="margin-right: 5px;">
                                <button style="width: 50px;" class="super normal button"><i class="fa fa-chevron-up"></i> 
                                @if($post->likes > 0)
                                {{ $post->likes }}
                                @endif</button>
                            </div>
                            <div class="col-5">
                                <button style="width: 50px;" class="super normal button"><i class="fa fa-chevron-down"></i></button>
                            </div>
                        </div>
                    </td>
                    <td class="text-left">
                        <div style="font-size: 12px;color: #999;">
                            {{ $author }}&nbsp;•&nbsp;
                            @if((time() - $post->pubtime) > 86400)
                                {{ floor((time()-$post->pubtime)/86400) }} 天前
                            @elseif(floor((time()-$post->pubtime)/3600) > 0)
                                {{ floor((time()-$post->pubtime)/3600) }} 小时 {{ floor(((time()-$post->pubtime)-floor((time()-$post->pubtime)/3600)*3600)/60) }} 分钟前
                            @else
                                {{ floor(((time()-$post->pubtime)-floor((time()-$post->pubtime)/3600)*3600)/60) }} 分钟前
                            @endif
                            &nbsp;•&nbsp;{{ $post->views }}次點閱
                            &nbsp;&nbsp;
                            @if($post->lastupdate !== null)
                                <span class="pull-right" style="font-size: 12px; color:#AAA;"> 主題最近一次編輯時間: {{ date('Y-m-d H:i:s', $post->lastupdate) }}</span>
                            @endif

                            @guest
                            @else
                                @if((Auth::user()->uid == $post->uid) && ((time()-$post->pubtime) < 86400))
                            <span id="label-edit"><a href="{{ url('artedit', $post->aid) }}"><label class="badge badge-default" style="font-size: 12px;font-weight: 500; background-color:orange;color: white;cursor: pointer;"><i class="fa fa-pencil"></i> 編輯主題</label></a></span>
                                @endif
                            @endguest
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div id="wordsView" style="padding: 0px 10px 10px;background-color: white;font-size: 16px;">
            <textarea name="editormd-markdown-doc" cols="30" rows="10" style="border:none; resize: none;">
                {{ $post->content }}
            </textarea>
        </div>
        
        @guest

        @else
        <div id="collect" style="height: 30px;line-height: 30px;color: #333;text-shadow: 0px 1px 0px #FFF;">
            <div style="float: left;margin: 0px 20px;">
                <a href="" id="add-collect"> 加入收藏</a>
            </div>
            <div style="float: left;margin-right: 20px;">
                <a href=""> 分享至xx</a>
            </div>
            <div class="pull-right" style="float: left;margin-right: 20px;">點閱次數 {{ $post->views }}</div>
            <div style="float: left;margin-right: 20px;"> 4人收藏</div>
        </div>
        @endguest
        </div>


        @if($post->comments > 0)
        <div id="comments" class="box" style="float:left;">
            <table width="100%" cellpadding="0" cellspacing="0">
                <tr style="border-bottom: 1px solid #CCC;">
                    <td width="8%" style="padding: 0px 10px;border-radius: 3px 0 0 0;">{{ count($comments) }} 回應</td>
                    <td colspan="2" style="border-radius: 0 3px 0 0;">直到 {{ date('Y-m-d H:i:s', time()) }}</td> 
                </tr>
            
            @php
                $comment_num = count($comments);
            @endphp
            
            <!-- Comment Loop Start -->
            @foreach($comments as $comment)
                <tr>
                    <td rowspan="2" style="padding: 0px;"><img src="{{ '/images/'. mt_rand(1,5) .'.png' }}" width="48px" height="48px" style="border-radius: 5px;margin:10px;" alt="Thumb here"></td>
                    <td style="padding: 10px 10px 0px 0px;">
                        <a href="">{{ $comment->lineid }}</a>&nbsp;&nbsp;
                        <span style="color:#BBB;font-size: 12px;">
                        @if(time() - $comment->created_at > 86400)
                            {{ floor((time() - $comment->created_at)/86400) }} 天前
                        @else
                            {{ floor((time() - $comment->created_at)/3600) }} 小時 
                            {{ floor(((time() - $comment->created_at) - floor((time() - (($comment->created_at)/3600)*3600)/60))) }} 分鐘前
                        @endif
                        </span>
                        <span class="pull-right">
                            <a id="thank{{ $comment->comm_id }}" name="{{ $comment->lineid }}" title="{{ $comment->comm_id }}" style="cursor: pointer;">感謝回應者</a>&nbsp;&nbsp;
                            <a id="jump{{ $comment->comm_id }}" style="cursor: pointer;" name="{{ $comment->lineid }}"><i class="fa fa-reply"></i> 回應</a>&nbsp;&nbsp;
                            <label class="badge badge-default" style="border-radius: 8px;background-color: #EEE;color:#999;">{{ $comment_num }}</label>
                        </span>
                    </td>
                </tr>
                @php
                    $comment_num -= 1;
                @endphp

                <tr style="border-bottom: 1px solid #DDD;">
                    <td style="padding: 0px 0px 10px 0px;">{{ $comment->comment }}</td>
                </tr>
            @endforeach
            <!-- Comment Loop End -->

            </table>
        </div>
        @else

        <div class="col-12" style="height: 50px;line-height: 40px; border:3px dashed #CCC;border-radius: 5px;float:left;color:#999;width: 910px;text-align: center;margin:10px 0;">
        目前尚無回應
        </div>
        @endif
    {{-- <div class="sep10"></div> --}}
    @guest

    @else
        <!-- uncommentable while post was locked -->
        @if($post->status == 1)
    <div id="reply" class="col-12 box" style="float: left;">
        <table width="100%">
            <tr>
                <td style="border-bottom: 1px solid #DDD;border-radius: 3px 3px 0 0;">
                    <span>撰寫一則新回應</span>
                    <span class="pull-right"><a href="#top"><i class="fa fa-arrow-up"></i> 回到頂部</a></span>
                </td>
            </tr>

            <form action="{{ url('comment_add') }}" method="post">
            {{ csrf_field() }}
            <tr>
                <td>
                    <input type="hidden" name="aid" value="{{ $post->aid }}">
                    <textarea id="content" name="comment" cols="30" rows="4" style="border-radius: 3px; resize: none;width: 100%;padding: 10px;">{{ old('comment') }}</textarea>
                </td>
            </tr>

            <tr>
                <td style="border-bottom: 1px solid #DDD;">
                    <span>
                        <input type="submit" value="回應" class="super normal button pull-right" style="width:100px;">
                    </span>
                </td>
            </tr>
            </form>

            <tr>
                <td style="text-align:left;border-radius: 0 0 3px 3px;"><a href="{{ url('post_list') }}"><i class="fa fa-arrow-left"> 貼文列表</a></td>
            </tr>
        </table>
    </div>
        @endif
    @endguest
    </div>

</div>
<div style="clear: both;"></div>
{!! editor_js() !!}
<script type="text/javascript">
    $('a[id^=jump]').on('click', function(ev){
        $('#content').append(`@${ev.target.name}`);
        $('#content').focus();
    });

    $('a[id^=thank]').on('click', function(ev){
        if(confirm(`確認花費 10 個銅幣向 @${ev.target.name} 的這則回應送出感謝嗎?`)){
            var comm_id = ev.target.title;
            $.get(`{{ url('thank') }}/${comm_id}`, function(res){
                alert(res);
            });
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var wordsView;
        wordsView = editormd.markdownToHTML("wordsView", {
            htmlDecode      : "style,script,iframe",  // you can filter tags decode
            emoji           : true,
            taskList        : false,
            tex             : false,  
            flowChart       : false,  
            sequenceDiagram : false,
            imageUploadURL : "/laravel-editor-md/upload/picture?_token=6AP4VRMPPOEBLMvtN5n0zMBPfjdaWHrIkn4EI6wF&from=laravel-editor-md" 
        });

    })
</script>


@endsection