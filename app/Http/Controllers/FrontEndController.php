<?php

namespace App\Http\Controllers;

use App\Forum;
use App\Post;
use Illuminate\Http\Request;

class FrontEndController extends Controller
{
    /**
     * display posts in home page
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $posts = Post::latest()->paginate(8);
        return view('welcome', compact('posts'));
    }

    /**
     *
     * display single post for frontend with comment
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getSinglePost(Post $post)
    {
//        $post->load('comments', 'comments.user');
        $post->load('comments');
//        dd($post);
        return view('single-post', compact('post'));
    }

    public function getSingleForum(Forum $forum)
    {
//        $post->load('comments', 'comments.user');
        $forum->load('comments');
//        dd($post);
        return view('single-forum', compact('forum'));
    }

}
