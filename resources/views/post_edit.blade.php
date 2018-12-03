@extends('layouts.app')

@section('content')

@guest
    @include('require_login')
@else
<div id="artadd" class="col-md-12">
    <div id="main" class="col-md-9 col-sm-9 col-xs-12 box table-responsive">
        <form action="{{ url('artupdate', $artrow->aid) }}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        <table width="100%">
            <tr>
                <td>
                    <a href="{{ url('/') }}">ZIXUE</a> > 编辑主题
                </td>
            </tr>

            <tr>
                <td id="error-border" 
                @if(Session::has('error_message'))
                style="border-bottom: 1px solid red;"@endif
                >

                    <span class="pull-left">主题标题 <i class="fa fa-chevron-down"></i></span>
                    <span id="limit" class="pull-right" style="color:#BBB;">80</span>
                </td>
            </tr>

            <tr>
                <td @if(Session::has('error_message'))
                style="border-bottom: 1px solid red;"
                @endif>
                    <input id="title" name="title" type="text" maxlength="80" placeholder="请在此行输入主题标题, 如果标题能够表达完整内容, 则正文可以为空" value="{{ $artrow->title }}">
                    @if(Session::has('error_message')) 
                    <span id="error-msg" class="pull-right" style="color: red;"><i class="fa fa-exclamation-circle"></i> 请输入标题</span>
                @endif
                </td>
            </tr>

            <tr>
                <td>
                    正文 <i class="fa fa-chevron-down"></i>
                </td>
            </tr>

            <tr>
                <td style="padding: 0px;">
                    <div id="mdeditor" style="border-right: none;border-left: none;border-top: none;">
                        <textarea name="content" id="content" cols="30" rows="10">{{ $artrow->content }}</textarea>
                    </div>
                </td>
            </tr>

            <tr>
                <td>
                    <select name="node" id="" style="width:200px;">

                    <!-- 节点值循环开始 -->
                    @foreach($nodes as $node)
                        <option value="{{ $node->nid }}">{{ $node->node_name }}</option>
                    @endforeach
                    <!-- 节点值循环结束 -->

                    </select>
                </td>
            </tr>
            <tr>
                <td>
                    <span style="float:left;padding-right:20px;"> 最热节点 </span>
                    <a href="">

                <!-- 节点循环开始 -->

                    <div style="margin-right: 8px; float: left; border-radius: 3px;background-color: #F5F5F5;color: #999;padding: 1px 5px;font-size: 12px;position:relative;top:1px;">
                        节点
                    </div>

                <!-- 节点循环结束 -->

                    </a>
                </td>
            </tr>
            <tr>
                <td style="border:none">
                    <!-- <span class="pull-left">
                        <button id="preview-art">
                            <i class="fa fa-eye"></i> 预览主题
                        </button>
                    </span> -->

                    <span class="pull-right">
                        <button id="pub-art" class="super normal button">
                            <i class="fa fa-save"></i> 保存修改
                        </button>
                        <input type="submit" class="hidden" id="art-submit" value="">
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

    <!-- 统计标题剩余可用字数 -->
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

    <aside id="right" class="col-md-3 col-sm-3 hidden-xs" style="float: left;margin-left: 10px;">
        <div class="box">
            <div style="line-height: 30px;border-bottom: 1px solid #EEE;padding: 10px;">
                发帖提示
            </div>
            <div style="line-height: 20px;padding: 10px;">
                <div style="padding: 0px 10px;">
                    <li>主题标题</li>
                    <div class="sep10"></div>
                    请在标题中描述内容要点。如果一件事情在标题的长度内就已经可以说清楚，那就没有必要写正文了。
                    <div class="sep20"></div>
                    <li>正文</li>
                    <div class="sep10"></div>
                        可以在正文中为你要发布的主题添加更多细节。ZIXUE 支持 <a href="https://help.github.com/categories/writing-on-github/" target="_blank" title="GitHub Flavored Markdown"> GitHub Flavored Markdown</a>文本标记语法。
                        在正式提交之前，你可以点击本页面左下角的“预览主题”来查看 Markdown 正文的实际渲染效果。
                    <div class="sep20"></div>
                    <li>选择节点</li>
                    <div class="sep10"></div>
                    在最后，请为你的主题选择一个节点。恰当的归类会让你发布的信息更加有用。 
                </div> 
            </div>

        </div>
        <div class="sep20"></div>
        <div class="box">
        <div style="line-height: 30px;border-bottom: 1px solid #EEE;padding: 10px;">
                社区指导原则
            </div>
        <div style="line-height: 20px;padding: 10px;">
            <div style="padding: 0px 10px;">
                <li>尊重原创</li>
                <div class="sep10"></div>
                请不要在 ZIXUE 发布任何盗版下载链接，包括软件、音乐、电影等等。ZIXUE 是创意工作者的社区，我们尊重原创。
                <div class="sep20"></div>
                <li>友好互助</li>
                <div class="sep10"></div>
                保持对陌生人的友善。用知识去帮助别人。
            </div>
        </div>
    </aside>

<div style="clear: both;"></div>
</div>
{!! editor_js() !!}
<!-- markdown 编辑器脚本 -->
<script type="text/javascript">
var _mdeditor;
$(function() {
    //修正emoji图片错误
    editormd.emoji     = {
        path  : "//staticfile.qnssl.com/emoji-cheat-sheet/1.0.0/",
        ext   : ".png"
    };
    _mdeditor = editormd({
            id : "mdeditor",
            width : "100%",
            height : 400,
            // markdown:markdown,
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
            imageUploadURL : "/laravel-editor-md/upload/picture?_token=6AP4VRMPPOEBLMvtN5n0zMBPfjdaWHrIkn4EI6wF&from=laravel-editor-md"
    });
});
</script>

@endguest
@endsection