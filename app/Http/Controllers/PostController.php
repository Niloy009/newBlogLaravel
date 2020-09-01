<?php

namespace App\Http\Controllers;

use App\Category;
use App\Post;
use App\Tag;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {

        $posts = Post::with('category:id,name', 'tags')->where('user_id', Auth::id())
            ->latest()
            ->get();

//        $user = Auth::User();
//        $user = User::find(Auth::id());
//        $posts = auth()->user()->posts;  // n+1 problem
//        $posts = auth()->user()->load('posts');  // n+1 problem


//        $user = auth()->user();
//        $user->load('posts');
//        $posts = $user->posts;
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.post.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
//    public function getAllPost(Request $request)
//    {
////        return $request->all();
//        $columns = array(
//            0 =>'id',
//            1 =>'title',
//            2 =>'category_name',
//            3=> 'body',
//            4=> 'created_at',
//            5=> 'options',
//        );
//        $totalData = Post::count();
//
//        $totalFiltered = $totalData;
//
//        $limit = $request->input('length');
//        $start = $request->input('start');
//        $order = $columns[$request->input('order.0.column')];
//        $dir = $request->input('order.0.dir');
//
//
//
//
//        if(empty($request->input('search.value')))
//        {
//            $posts = Post::offset($start)
//                ->limit($limit)
//                ->orderBy($order,$dir)
//                ->get();
//        }
//        else {
//            $search = $request->input('search.value');
//
//            $posts =  Post::where('id','LIKE',"%{$search}%")
//                ->orWhere('title', 'LIKE',"%{$search}%")
//                ->offset($start)
//                ->limit($limit)
//                ->orderBy($order,$dir)
//                ->get();
//
//            $totalFiltered = Post::where('id','LIKE',"%{$search}%")
//                ->orWhere('title', 'LIKE',"%{$search}%")
//                ->count();
//        }
//
//        $data = array();
//        if(!empty($posts))
//        {
//            foreach ($posts as $post)
//            {
//                $show =  route('posts.show',$post->id);
//                $edit =  route('posts.edit',$post->id);
//
//                $nestedData['id'] = $post->id;
//                $nestedData['title'] = $post->title;
//                $nestedData['category_name'] = $post->category->name;
//                $nestedData['body'] = substr(strip_tags($post->body),0,50)."...";
//                $nestedData['created_at'] = date('j M Y h:i a',strtotime($post->created_at));
////                $nestedData['options'] = "&emsp;<a href='{$show}' title='SHOW' class='btn btn-primary btn-sm' >Show</a>
////                                          &emsp;<a href='{$edit}' title='EDIT'  class='btn btn-info btn-sm' >Edit</a>";
////                $nestedData['options'] = "&emsp;<a href='#' data-toggle='modal' data-toggle='modal' data-target='#postViewModal'  title='SHOW' class='btn btn-primary btn-sm' >Show</a>
//                $nestedData['options'] = "&emsp;<button type='button' onclick='openPostViewModal($post)' title='SHOW' class='btn btn-primary btn-sm' >Show</button>
//                                          &emsp;<a href='{$edit}' onclick='openPostEditModal($post)' title='EDIT'  class='btn btn-info btn-sm' >Edit</a>";
//                $data[] = $nestedData;
//
//            }
//        }
//
//        $json_data = array(
//            "draw"            => intval($request->input('draw')),
//            "recordsTotal"    => intval($totalData),
//            "recordsFiltered" => intval($totalFiltered),
//            "data"            => $data
//        );
//
//        echo json_encode($json_data);
//
//    }

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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
//        //Validation
//        $this->validate($request, [
//            'name' => 'required|max:255'
//        ]);

//        Post::create($request->all());


        $data = $request->all();
        $data['user_id'] = Auth::id();
        if ($request->has('image')) {
            $file = $request->file('image');

            $extension = $file->getClientOriginalExtension();//getting file extension
//            dd($extension);
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);
            $data['image'] = $filename;

        }
        // dd($data);
        $post = Post::create($data);
        if (!empty($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }
        return redirect('/posts')->with('status', 'Created successful');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return $post;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Post $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return $post;
    }

    /**
     * update a post with image
     *
     * @param Request $request
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->all();

        if ($request->has('image')) {

            $file_path = public_path('/uploads/' . $post->image);
            //dd($post->image);
            if (file_exists($file_path) && !empty($post->image)) {
                unlink($file_path);
            }

            $file = $request->file('image');
            $extension = $file->getClientOriginalExtension(); //getting file extension
            $filename = time() . '.' . $extension;
            $file->move('uploads/', $filename);
            $data['image'] = $filename;

        }


        $post->update($data);

        if (!empty($request->tag_id)) {
            $post->tags()->sync($request->tag_id);
        }

        return redirect('/posts')->with('status', "Updated Successfully");
    }

    /**
     * @param Post $post
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Post $post)
    {


//        $file_path = public_path('uploads/' . $post->image);
//
//        unlink($file_path);
        $post->delete();
        return redirect('/posts')->with('status', "Deleted Successfully");
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getTrashPosts()
    {

        $trashposts = Post::onlyTrashed()->get();
        return view('admin.post.restore', compact('trashposts'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */

    public function restorePosts($id)
    {

        $post = Post::onlyTrashed()->findOrFail($id);

        $post->restore();
        return redirect('posts/trash')->with('status', "Restored Successfully");
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function permanentDelete($id)
    {

        $post = Post::onlyTrashed()->findOrFail($id);
        $post->forceDelete();
        return redirect('posts/trash')->with('status', "Deleted Successfully");
    }


}
