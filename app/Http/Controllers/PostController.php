<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $posts = Post::with('category')->orderBy('id', 'desc')->get();

//        $user = Auth::User();
//        $user = User::find(Auth::id());
//        $posts = auth()->user()->posts;  // n+1 problem
//        $posts = auth()->user()->load('posts');  // n+1 problem



//        $user = auth()->user();
//        $user->load('posts');
//        $posts = $user->posts;
        $categories = Category::all();
        return view('admin.post.index', compact('categories'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAllPost(Request $request)
    {
//        return $request->all();
        $columns = array(
            0 =>'id',
            1 =>'title',
            2 =>'category_name',
            3=> 'body',
            4=> 'created_at',
            5=> 'options',
        );
        $totalData = Post::count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir = $request->input('order.0.dir');




        if(empty($request->input('search.value')))
        {
            $posts = Post::offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        }
        else {
            $search = $request->input('search.value');

            $posts =  Post::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = Post::where('id','LIKE',"%{$search}%")
                ->orWhere('title', 'LIKE',"%{$search}%")
                ->count();
        }

        $data = array();
        if(!empty($posts))
        {
            foreach ($posts as $post)
            {
                $show =  route('posts.show',$post->id);
                $edit =  route('posts.edit',$post->id);

                $nestedData['id'] = $post->id;
                $nestedData['title'] = $post->title;
                $nestedData['category_name'] = $post->category->name;
                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
//                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' class='btn btn-primary btn-sm' >Show</a>
//                                          &emsp;<a href='{$edit}' title='EDIT'  class='btn btn-info btn-sm' >Edit</a>";
//                $nestedData['options'] = "&emsp;<a href='#' data-toggle='modal' data-toggle='modal' data-target='#postViewModal'  title='SHOW' class='btn btn-primary btn-sm' >Show</a>
                $nestedData['options'] = "&emsp;<button type='button' onclick='openPostViewModal($post)' title='SHOW' class='btn btn-primary btn-sm' >Show</button>
                                          &emsp;<a href='{$edit}' onclick='openPostEditModal($post)' title='EDIT'  class='btn btn-info btn-sm' >Edit</a>";
                $data[] = $nestedData;

            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $data
        );

        echo json_encode($json_data);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
         return $post;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //
    }
}
