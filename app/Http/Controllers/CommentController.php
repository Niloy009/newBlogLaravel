<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Forum;
use App\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function postCommentStore(Request $request, Post $post)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
//        $client->name = 'name';
//        $client->executable_id = 1;
//        $client->executable_type = 'App\Admin';

//        $post->comments()

        Comment::create([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
            'commentable_id' => $post->id,
            'commentable_type' => 'App\Post'
        ]);

        return redirect()->back()->with('status', 'Created successful');


    }

    public function forumCommentStore(Request $request, Forum $forum)
    {
        $this->validate($request, [
            'body' => 'required'
        ]);
//        $client->name = 'name';
//        $client->executable_id = 1;
//        $client->executable_type = 'App\Admin';

//        $post->comments()

        Comment::create([
            'body' => $request->body,
            'user_id' => auth()->user()->id,
            'commentable_id' => $forum->id,
            'commentable_type' => 'App\Forum'
        ]);

        return redirect()->back()->with('status', 'Created successful');


    }


}
