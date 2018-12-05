<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Session;
use App\Node;
use App\Post;
use App\User;
use App\Comment;


class PostController extends Controller
{
    public function index()
    {
        $pnodes = Node::where('parent_id', 0)->get();
        $nodes = Node::where('parent_id', '<>', 0)->get();
        $posts = Post::leftJoin('nodes', 'posts.nid', '=', 'nodes.nid')
                    ->leftJoin('users', 'posts.uid', '=', 'users.uid')
                    ->select('posts.*', 'nodes.node_name', 'users.lineid')
                    ->orderBy('pubtime', 'DESC')->get();
        return view('post_list', ['pnodes'=>$pnodes, 
                                  'nodes'=>$nodes,
                                  'posts'=>$posts
                              ]);
    }

    public function showCreatePost()
    {
        if(!Auth::user()) {
            return redirect()->intended('login');
        }
        $nodes = Node::where('parent_id', '<>', 0)->get();
        return view('post_add', ['nodes'=>$nodes]);
    }

    public function createPost(Request $request)
    {
        // dd($request->all());
        $post = new Post();
        $user = Auth::user();   
        if (!$request->filled('title')) {
            Session::flash('error_message','請輸入標題');
            return back()->withInput($request->input());
        } elseif (!$request->filled('node')) {
            Session::flash('error_node','請選擇所屬話題');
            return back()->withInput($request->input());
        } else {
            $post->nid = $request->node;
            $post->uid = $user->uid;
            $post->title = $request->title;
            $post->content = "\r\n".$request->content;
            $post->pubtime = time();
            $post->last_update = time();
            $result = $post->save();
            Node::find($request->node)->increment('posts');
            if($result){
                // $this->addRewards();
                return redirect('post_list');
            }
        }
    }

    public function articleAdd(Request $req){
        $article = new Article();
        $node = new Node();
        $user = Auth::user();   
        if (!$req->filled('title')) {
            Session::flash('error_message','请输入标题');
            return back()->withInput($request->input());
        }else{
            $article->nid = $req->node;
            $article->uid = $user->uid;
            $article->title = $req->title;
            $article->content = "\r\n".$req->content;
            $article->pubtime = time() ;
            $art = $article->save();
            $node->find($req->node)->increment('arts');
            if($art){
                $this->addRewards();
                return redirect('/');
            }
        }
    }   

    public function detail($postId)
    {
        $post = Post::find($postId);
        $author = User::find($post->uid)->lineid;
        $nodeName = Node::find($post->nid)->node_name;
        $comments = Comment::where('postid', $postId)->orderBy('created_at', 'DESC')->get();
        return view('post', ['post'=>$post, 'author'=>$author, 'node_name'=>$nodeName, 'comments'=>$comments]);
    }

    public function article($aid){
        $art = DB::table('articles')->where('aid', $aid)->firstOrFail();
        DB::table('articles')->where('aid', $aid)->increment('views');
        $uid = $art->uid;
        $nid = $art->nid;
        $name = DB::table('users')->where('uid', $uid)->value('name');
        $node_name = DB::table('nodes')->where('nid', $nid)->value('node_name');
        $comments = DB::table('comments')
        ->where('comm_aid', $aid)->orderBy('comm_time', 'DESC')->get();
        return view('article',['art'=>$art, 'name'=>$name, 'node_name'=>$node_name, 'comms'=>$comments]);
    }
}
