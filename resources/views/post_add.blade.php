@extends('layouts.app')

@section('content')

<div id="postadd" class="col-md-12">
    <div id="main" class="col-xs-12 box table-responsive">
        <form action="" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        {{ Session::put('csrf_token', csrf_token())}}
        <table width="100%">
            <tr>
                <td style="padding: 10px;">
                    <a href="{{ url('post_list') }}">無與倫比</a> > 發布貼文
                </td>
            </tr>

            <tr>
                <td id="error-border" style="padding: 10px; 
                @if(Session::has('error_message'))
                border-bottom: 1px solid red;"
                @endif
                >

                    <span class="pull-left">貼文主題 <i class="fa fa-chevron-down"></i></span>
                    <span id="limit" class="pull-right" style="color:#BBB;">80</span>
                    @if(Session::has('error_message')) 
                    <span id="error-msg" class="pull-center" style="color: red;"><i class="fa fa-exclamation-circle"></i> 請輸入標題</span>
                    @endif
                </td>
            </tr>

            <tr>
                <td style="padding: 10px;
                @if(Session::has('error_message'))
                border-bottom: 1px solid red;@endif">
                    <input id="title" name="title" type="text" maxlength="80" placeholder="請輸入標題，若標題能表達完整內容，則正文可以留空">
                </td>
            </tr>

            <tr>
                <td style="padding: 10px;">
                    正文 <i class="fa fa-chevron-down"></i>
                </td>
            </tr>

            <tr>
                <td style="padding: 0px;">
                    <div id="mdeditor" style="border-right: none;border-left: none;border-top: none;">
                        <textarea name="content" id="content" cols="30" rows="10" style="padding: 10px;"></textarea>
                    </div>
                </td>
            </tr>

            <tr>
                <td style="padding: 10px;">
                    <select name="node" id="" style="width:200px;
                    @if(Session::has('error_node'))
                    border:1px solid red;
                    @endif">
                        <option value="">請選擇貼文所屬話題</option>
                        <option value="1">電影</option>
                    <!-- Nodes Loop Start -->
                    @if(isset($nodes))
                        @foreach($nodes as $node)
                            <option value="{{ $node->nid }}">{{ $node->node_name }}</option>
                        @endforeach
                    @endif
                    <!-- Nodes Loop End -->

                    </select>
                </td>
            </tr>
            <tr>
                <td style="padding: 10px;">
                    <span style="float:left;padding-right:20px;"> 最熱話題 </span>
                    <a href="">

                <!-- Nodes Loop Start -->

                    <div style="margin-right: 8px; float: left; border-radius: 3px;background-color: #F5F5F5;color: #999;padding: 1px 5px;font-size: 12px;position:relative;top:1px;">
                        話題
                    </div>

                <!-- Nodes Loop End -->

                    </a>
                </td>
            </tr>
            <tr>
                <td style="border:none;padding: 10px;"">
                    <!-- <span class="pull-left">
                        <button id="preview-art">
                            <i class="fa fa-eye"></i> 預覧主題
                        </button>
                    </span> -->

                    <span class="pull-right">
                        <button id="pub-art" class="super normal button">
                            <i class="fa fa-paper-plane"></i> 發佈貼文
                        </button>
                        <input type="submit" id="art-submit" value="" style="display: none;">
                    </span>
                </td>
            </tr>
        </table>
        </form>
    </div>
    <script type="text/javascript">
        $('#pub-art').on('click', function(){
            $('#art-submit').trigger('click');
        });
    </script>

    <!-- Title chars limit count -->
    <script type="text/javascript">
        var max = 80;
        var t_length;
        var rs;
        $('#title').on('keyup', function(){
            t_length = $('#title').val().length;
            rs = max - t_length;
            $('#limit').html(rs);
            $('#title').trigger('change');
            if(rs<0){
                $('#limit').css('color','red');
            }else{
                $('#limit').css('color','#BBB');
            }
        });
    </script>

    <!-- <aside id="right" class="col-md-3 col-sm-3 hidden-xs" style="float: left;">
        <div class="box">
            <div style="line-height: 30px;border-bottom: 1px solid #EEE;padding: 10px;">
                貼文發佈提示
            </div>
            <div style="line-height: 20px;padding: 10px;">
                <div style="padding: 0px 10px;">
                    <li>主題標題</li>
                    <div class="sep10"></div>
                    請在標題中描述內容要點。如果一件事情在標題的長度內就已經可以說清楚，那就沒有必要寫正文了。
                    <div class="sep20"></div>
                    <li>正文</li>
                    <div class="sep10"></div>
                        可以在正文中為你要發佈的主題添加更多細節。ZIXUE 支持 <a href="https://help.github.com/categories/writing-on-github/" target="_blank" title="GitHub Flavored Markdown"> GitHub Flavored Markdown</a>文本標記語法。
                        在正式提交之前，你可以點擊本頁面左下角的「預覽主題」來查看 Markdown 正文的實際渲染效果。
                    <div class="sep20"></div>
                    <li>選擇節點</li>
                    <div class="sep10"></div>
                    在最後，請為你的主題選擇一個節點。恰當的歸類會讓你發佈的信息更加有用。 
                </div> 
            </div>

        </div>
        <div class="sep20"></div>
        <div class="box">
        <div style="line-height: 30px;border-bottom: 1px solid #EEE;padding: 10px;">
                社區指導原則
            </div>
        <div style="line-height: 20px;padding: 10px;">
            <div style="padding: 0px 10px;">
                <li>尊重原創</li>
                <div class="sep10"></div>
                請不要在 無與倫比 發佈任何盜版下載連結，包括軟件、音樂、電影等等，請尊重原創。
                <div class="sep20"></div>
                <li>友好互助</li>
                <div class="sep10"></div>
                保持對陌生人的友善。用知識去幫助別人。
            </div>
        </div>
    </aside> -->

<div style="clear: both;"></div>
</div>
{!! editor_js() !!}
<!-- markdown editor script -->
<script type="text/javascript">
var _mdeditor;
$(function() {
    // fix emoji error
    editormd.emoji     = {
        path  : "//staticfile.qnssl.com/emoji-cheat-sheet/1.0.0/",
        ext   : ".png"
    };
    _mdeditor = editormd({
            id : "mdeditor",
            width : "100%",
            height : 400,
            markdown:markdown,
            toolbar : true,
            saveHTMLToTextarea : true,
            emoji : true,
            taskList : true,
            tex : false,
            toc : true,
            tocm : false,
            codeFold : true,
            flowChart: false,
            sequenceDiagram: false,
            path : "/vendor/editor.md/lib/",
            imageUpload : true,
            imageFormats : ["jpg", "gif", "png"],
            imageUploadURL : "/laravel-editor-md/upload/picture?_token=UbfKp23dYAzQ19HtXbMGdsQBLZlPoWeVxWqaZETgvVcJuNbXaKP&from=laravel-editor-md"
    });
});
</script>
@endsection
