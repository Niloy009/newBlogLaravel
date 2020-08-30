@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <a href="#" data-toggle="modal" data-target="#postCreate"
                           class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="posts" class="table text-center">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 20%">Title</th>
                                <th style="width: 10%">Category</th>
                                <th style="width: 35%">Body</th>
                                <th style="width: 10%">Status</th>
                                <th style="width: 20%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($posts as $post)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$post->title}}</td>
                                    <td>{{$post->category->name}}</td>
                                    <td>{{$post->body}}</td>
                                    <td>
                                        <a href="#" class="text-dark"
                                           onclick="return confirm('Are you sure to change!!!')">
                                            {{$post->status == 1 ? 'Active' : 'Inactive'}}
                                        </a>
                                    </td>
                                    <td>
                                        {{--                                        <a href="{{route('posts.edit', $post->id)}}"--}}
                                        {{--                                           class="btn btn-primary btn-sm">Edit</a>--}}
                                        {{--                                        <a href="{{route('posts.show', $post->id)}}"--}}
                                        {{--                                           class="btn btn-info btn-sm">View</a>--}}
                                        <button type="button" onclick="openPostEditModal({{$post->id}})"
                                                class="btn btn-primary btn-sm">Edit
                                        </button>

                                        <button type="button" onclick="openShowPostModal({{$post->id}})"
                                                class="btn btn-info btn-sm">
                                            View
                                        </button>

                                        {{Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
                                        <button type="submit"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to delete!!!')"
                                                class="btn btn-sm btn-danger">Delete
                                        </button>
                                        {{Form::close()}}
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Post Create Modal -->
        <div class="modal fade" id="postCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{Form::open(['route' => 'posts.store', 'method' => 'POST','enctype' => 'multipart/form-data' ])}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="title">Post Title</label>
                            <input type="text" name="title" class="form-control" id="name">
                            <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                        </div>
                        <div class="form-group">
                            <label for="body">Post Body</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="10"></textarea>
                            <span class="text-danger ">{{$errors->has('body') ? $errors->first('body') : ''}}</span>
                        </div>
                        <div class="form-group custom-file">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            <input type="file" name="image" class="custom-file-input" id="inputGroupFile01"
                                   aria-describedby="inputGroupFileAddon01" accept="image/x-png">
                            <span class="text-danger ">{{$errors->has('image') ? $errors->first('image') : ''}}</span>

                        </div>

                        <div class="form-group">
                            <label for="category">Category Name</label>
                            <select class="custom-select" name="category_id">
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Create</button>
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>

        <!-- Category Show Modal -->
        <div class="modal fade" id="postShowModal" tabindex="-1" aria-labelledby="postShowLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postShowLabel">Post Show</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <th>Id:</th>
                                <td id="showPostId"></td>
                            </tr>
                            <tr>
                                <th>Post Title:</th>
                                <td id="showPostTitle"></td>
                            </tr>
                            <tr>
                                <th>Post Body:</th>
                                <td id="showPostBody"></td>
                            </tr>
                            <tr>
                                <th>Post Category:</th>
                                <td id="showPostCategory"></td>
                            </tr>
                            <tr>
                                <th>Post Status:</th>
                                <td id="showPostStatus"></td>
                            </tr>
                            <tr>
                                <th>Post Image:</th>
                                <td id="showPostImage">
                                    {{--                                    <img src="{{asset('uploads/'. $post->image)}}" class="card-img-top" alt="image">--}}
                                    <img id="image" src="" class="card-img-top" alt="image">
                                </td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td id="showPostCreatedAt"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>


        <!-- Post Edit Modal -->
        <div class="modal fade" id="postEditModal" tabindex="-1" aria-labelledby="postEditLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="postEditLabel">Post Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{Form::open(['id' => 'postEditForm', 'method' => 'PUT' ])}}
                    {{--                    {{Form::open(['route' => ['categories.update', $category->id], 'method' => 'PUT' ])}}--}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Post title</label>
                            <input type="text" name="title"  class="form-control" id="editPostTitle">
                            <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                        </div>
                        <div class="form-group">
                            <label for="name">Post Body</label>
                            <input type="text" name="body"  class="form-control" id="editPostBody">
                        </div>
                        <div class="form-group custom-file">
                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            <input type="file" name="image" value="{{$post->img}}" class="custom-file-input"
                                   id="inputGroupFile01"
                                   aria-describedby="inputGroupFileAddon01">
                        </div>
                        <div class="form-group">
                            <label for="category">Category Name</label>
                            <select class="custom-select" name="category_id">
                                @foreach($categories as $category)
                                    <option
                                        value="{{$category->id}}" {{$category->id == $post->category_id ? 'selected' : '' }}>{{$category->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group ">

                            <label class="d-block">Status</label>

                            <label for="editCategoryStatusActive" class="mr-4">
                                <input class="" type="radio" name="status"  id="editCategoryStatusActive" value="1" checked> Active
                            </label>
                            <label for="editCategoryStatusInactive">
                                <input class="" type="radio" name="status" id="editCategoryStatusInactive" value="0"> Inactive
                            </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        <button type="button" class="btn btn-sm btn-sm btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                    {{Form::close()}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#posts').DataTable({
                "columnDefs": [
                    {"orderable": false, "targets": [4, 5]}
                ]
            });
        });
        let posts = @json($posts)
            // functions
            function openShowPostModal(id) {
                //console.log(posts);
                let post = posts.find(post => post.id == id)
                $('#showPostId').html(post.id);
                $('#showPostTitle').html(post.title);
                $('#showPostBody').html(post.body);
                $('#showPostCategory').html(post.category.name);
                $('#image').attr('src', 'uploads/' + post.image);
                $('#showPostStatus').html(post.status == 1 ? 'Active' : 'Inactive');
                $('#showPostCreatedAt').html(post.created_at);
                // Open modal
                $('#postShowModal').modal('show');
            }
    </script>
@endsection
