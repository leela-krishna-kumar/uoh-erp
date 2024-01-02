<?php

namespace App\Http\Controllers\Common;
use App\Http\Controllers\Controller;

use App\Models\Chat;
use Illuminate\Http\Request;
use App\User;
use App\Models\Post;
use App\Models\PostLike;
use App\Models\PostComment;
use Toastr;
use Auth;
use App\Traits\FileUploader;

class NewsFeedController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct () 
    {
        // Module Data
        $this->title     = trans_choice('news_feed', 1);
        $this->route     = 'news-feed';
        $this->view      = 'common.news-feed';
        $this->path      = 'user';
    }
    public function index()
    {
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['path']      = $this->path;
        $data['row'] = User::where('id', Auth::guard('web')->user()->id)->first();
        $posts = Post::query();
        $data['posts'] = $posts->where('status',Post::STATUSES_APPROVED)->limit(5)->latest()->get();
        $data['mediaTypes'] = Post::TYPES;
        $myPost = Post::where('user_id',auth()->id())->pluck('id')->toArray();
        $data['latestLike'] = PostLike::whereIn('post_id',$myPost)->where('user_id','!=',auth()->id())->get();
        $data['latestComment'] = PostComment::whereIn('post_id',$myPost)->where('user_id','!=',auth()->id())->get();
        $data['latestUpdates'] = $data['latestLike']->concat($data['latestComment']);
        return view($this->view.'.index',$data);
    }


    //Get Likes of Post
    public function getPostLikes(Request $request)
    {
        $post = Post::where('id',$request->post_id)->first();
        $likes = PostLike::where('type',Post::class)->where('type_id',$request->post_id)->where('post_id',$request->post_id)->groupBy('user_id')->get();
        $userIds = PostLike::where('post_id',$request->post_id)->where('role_id','!=',0)->pluck('user_id')->toArray();
        $studentIds = PostLike::where('post_id',$request->post_id)->where('role_id',0)->pluck('user_id')->toArray();
        $users = User::whereIn('id',$userIds)->select('id','first_name','last_name')->get();
        $view = view($this->view.'.modal.likes', compact('users','post','likes'));
        return $view;
    }

    //Get Comments of Post
    public function getPostComments(Request $request)
    {
        $post = Post::where('id',$request->post_id)->first();
        $comments = PostComment::where('post_id',$request->post_id)->latest()->get();
        $userIds = PostComment::where('post_id',$request->post_id)->where('role_id','!=',0)->pluck('user_id')->toArray();
        $studentIds = PostComment::where('post_id',$request->post_id)->where('role_id',0)->pluck('user_id')->toArray();
        $users = User::whereIn('id',$userIds)->select('id','first_name','last_name')->get();
        $view = view($this->view.'.modal.comments', compact('comments','users','post'));
        return $view;
    }

    //Store Likes of Post
    public function storePostLikes(Request $request)
    {
        $like = PostLike::where('type',Post::class)->where('type_id',$request->post_id)->where('post_id',$request->post_id)->where('user_id',auth()->id())->first();
        if($like){
            $like->delete();
        }else{
            // Insert Data
            $postLike = new PostLike;
            $postLike->type = Post::class;
            $postLike->type_id = $request->post_id;
            $postLike->role_id = auth()->user()->roles[0]->id;
            $postLike->user_id = auth()->id();
            $postLike->post_id = $request->post_id;
            $postLike->save();
        }
        $likesCount = PostLike::where('type',Post::class)->where('type_id',$request->post_id)->latest()->count();
        return $likesCount;
    }


    //store Comments of Post
    public function storePostComments(Request $request)
    {
        $postComment = new postComment;
        $postComment->role_id = auth()->user()->roles[0]->id;
        $postComment->user_id = auth()->id();
        $postComment->post_id = $request->post_id;
        $postComment->comment = $request->comment;
        $postComment->save();

        $post = Post::where('id',$request->post_id)->first();
        $comments = PostComment::where('post_id',$request->post_id)->latest()->get();
        $count = $comments->count();
        $view = view($this->view.'.modal.comments', compact('comments','post','count'));
        return $view;
    }

    //Store Post
    public function storePost(Request $request)
    {
        $request->validate([
            'content' => 'required',
            // 'media_type' => 'required',
            // 'media' => 'required',
        ]);
        if(auth()->user()->roles[0]->id == 1){
            $status = Post::STATUSES_APPROVED;
        }else{
            $status = Post::STATUSES_IN_REVIEW;
        }
        // Insert Data
        $post = new Post;
        $post->content = $request->content;
        // $post->media_type = $request->media_type;
        $post->role_id = auth()->user()->roles[0]->id;
        $post->status = Post::STATUSES_IN_REVIEW;
        $post->media = $this->uploadImage($request, 'media', 'post', 300, 300);
        $post->user_id = auth()->id();
        $post->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back();
    }

    //Store Likes of Post Comment
    public function storePostCommentLikes(Request $request)
    {
        $like = PostLike::where('type',PostComment::class)->where('type_id',$request->id)->where('post_id',$request->post_id)->where('user_id',auth()->id())->groupBy('user_id')->first();
        if($like){
            $like->delete();
        }else{
            // Insert Data
            $postLike = new PostLike;
            $postLike->type = PostComment::class;
            $postLike->type_id = $request->id;
            $postLike->role_id = auth()->user()->roles[0]->id;
            $postLike->user_id = auth()->id();
            $postLike->post_id = $request->post_id;
            $postLike->save();
        }
        $likesCount = PostLike::where('type',PostComment::class)->where('type_id',$request->id)->where('post_id',$request->post_id)->latest()->count();
        return $likesCount;
    }

    //Get Likes of Post Comment
    public function getPostCommentLikes(Request $request)
    {
        $post = Post::where('id',$request->post_id)->first();
        $likes = PostLike::where('type',PostComment::class)->where('type_id',$request->id)->where('post_id',$request->post_id)->get();
        $view = view($this->view.'.modal.likes', compact('post','likes'));
        return $view;
    }


}
