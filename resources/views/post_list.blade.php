@extends('layouts.app')

@section('content')

<div style="float:right;position:absolute;top: -50px;right: 16px;z-index: 99">
    <a href="{{ url('post_add') }}" class="btn btn-primary" style="border-radius:30px;color: white;"><i class="fa fa-pen"></i> 發布貼文</a>
</div>
<div id="index" class="col-md-12">
    <div id="main" class="box" style="padding: 0px;">
    <div id="nodes">
        <div style="padding: 10px;background-color: white;border-radius: 3px 3px 0 0;">
        <!-- Parent Nodes Start -->
        @if(isset($pnodes))
            @foreach($pnodes as $pnode)
                @if($pnode->nid == 1)
                    <a href="{{ url('childnode', $pnode->nid )}}" class="badge badge-default" style="margin-right: 10px; color:white;font-size: 14px;background-color: #334;">{{ $pnode->node_name }}</a>
                @else
                    <a href="{{ url('childnode', $pnode->nid )}}" class="badge badge-default" style="margin-right: 10px; color:#334;font-size: 14px;background-color: white;">{{ $pnode->node_name }}</a>
                @endif
            @endforeach
        @endif

        <!-- Parent Nodes End -->
        </div>
        <div style="padding: 10px;background-color: #F4F4F4;border-bottom: 1px solid #CCC;">
        <!-- Childnodes Start -->
        @if(isset($nodes))
            @foreach($nodes as $node)
                <a href="{{ url('childnode', $node->nid )}}">{{ $node->node_name }}</a>&nbsp;&nbsp;&nbsp;&nbsp;
            @endforeach
        @endif
        <!-- Childnodes End -->
        </div>
    </div>

    <!-- Post Loop Start -->
    @if(isset($posts))
    @foreach($posts as $post)
    <div id="single" style="padding: 2px;">
    <table cellpadding="0" cellspacing="0" border="0" width="100%">
        <tr>
            
            <td width="48" align="center">
                <div style="border-radius: 4px;">
                <a href=""><img src="{{ '/images/'. mt_rand(1,5) .'.png' }}" alt="" align="center" style="border-radius: 4px; margin:10px 0px 10px 10px;"></a>
                </div>
            </td>
            <td width="10"></td>
            
            <td width="auto"><span style="font-size: 16px;"><a href="{{ url('post', $post->pid) }}">
                @if($post->status == -1)
                <i class="fa fa-lock"></i> 
                @endif
                {{ $post->title }}</a></span>
            <div class="sep5"></div>
            <span style="font-size: 12px;">
                @if($post->likes == 0)
                @else
                <div class="votes" style="display: inline-block;color: #BBB;">
                    <i class="fa fa-chevron-up"></i> {{ $post->likes }}
                </div>&nbsp;&nbsp;
                @endif
            </span>
            <span style="font-size:12px;">
                <a href="{{ url('childnode', $post->nid) }}" class="node" >{{ $post->node_name }}</a><span style="color:#AAA;"> &nbsp;•&nbsp; </span><strong><a href="">{{ $post->lineid }}</a></strong> 
                <span style="color:#AAA;">&nbsp;•&nbsp;
                    @if((time() - $post->pubtime) > 86400)
                        {{ floor((time()-$post->pubtime)/86400) }} 天前
                    @elseif(floor((time()-$post->pubtime)/3600) > 0)
                        {{ floor((time()-$post->pubtime)/3600) }} 小时 {{ floor(((time()-$post->pubtime)-floor((time()-$post->pubtime)/3600)*3600)/60) }} 分钟前
                    @else
                        {{ floor(((time()-$post->pubtime)-floor((time()-$post->pubtime)/3600)*3600)/60) }} 分钟前
                    @endif
                     
                </span>
                
                 <span style="color:#AAA;">
                    @if($post->last_comment)&nbsp;•&nbsp; 最後回應來自</span> <strong><a href="">{{ $post->last_comment }}
                    @endif</a></strong>
            </span>
            </td>
            <td width="70" align="right" style="padding-right: 20px;">
                
                <a href="" class="label label-default" style="color:white;font-size: 14px;padding: 1px 10px; border-radius: 10px;background-color: #AAB0C6;">{{ $post->comments }}</a>
                
            </td>
        </tr>
    </table>
    </div>
    @endforeach
    @endif
    <!-- Post Loop End -->
    <div style="padding: 0px 10px;background-color: white;border-radius: 0 0 3px 3px">
        @if(isset($posts))
            
        @endif
    </div>
</div>
    
</div>

@endsection