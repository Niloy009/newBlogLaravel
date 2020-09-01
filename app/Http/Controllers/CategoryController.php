<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        $categories = Category::orderBy('id', 'desc')->get();
//        $categories = Category::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        Category::create($request->all());

        return redirect('/categories')->with('status', 'Created successful');

    }

    /**
     * Display the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return view('admin.category.show', compact('category'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Category $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        //Validation
        $this->validate($request, [
            'name' => 'required|max:255'
        ]);

        $category->update($request->all());
        return redirect('/categories')->with('status', 'Updated successful');
    }

    /**
     * @param Category $category
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws \Exception
     */
    public function destroy(Category $category)
    {
        if ($category->posts->count() == 0) {
            $category->delete();
            return redirect('/categories')->with('status', 'Deleted successful');
        } else {
            return redirect('/categories')->with('status', 'Deleted unsuccessful. This category belongs to a Post');

        }


    }

    /**
     * @param Category $category
     */
    public function statusUpdate(Category $category)
    {
        $category->update([
            'status' => !$category->status
        ]);

        return redirect('/categories')->with('status', 'Updated successful');

    }
}
