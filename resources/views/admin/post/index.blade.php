@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <a href="{{route('categories.create')}}" class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="posts" class="table text-center">
                            <thead>
                            <th style="width: 5%">Id</th>
                            <th style="width: 20%">Title</th>
                            <th style="width: 10%">Category</th>
                            <th style="width: 35%">Body</th>
                            <th style="width: 15%">Created At</th>
                            <th style="width: 15%">Options</th>
                            </thead>
                        </table>


                        {{--                        <table id="example2" class="table text-center">--}}
                        {{--                            <thead>--}}
                        {{--                            <tr>--}}
                        {{--                                <th style="width: 5%">#</th>--}}
                        {{--                                <th style="width: 20%">Title</th>--}}
                        {{--                                <th style="width: 10%">Category</th>--}}
                        {{--                                <th style="width: 35%">Body</th>--}}
                        {{--                                <th style="width: 10%">Status</th>--}}
                        {{--                                <th style="width: 20%">Action</th>--}}
                        {{--                            </tr>--}}
                        {{--                            </thead>--}}
                        {{--                            <tbody>--}}
                        {{--                            @php($i = 1)--}}
                        {{--                            @foreach($posts as $post)--}}
                        {{--                                <tr>--}}
                        {{--                                    <th scope="row">{{$i++}}</th>--}}
                        {{--                                    <td>{{$post->title}}</td>--}}
                        {{--                                    <td>{{$post->category->name}}</td>--}}
                        {{--                                    <td>{{$post->body}}</td>--}}
                        {{--                                    <td>--}}
                        {{--                                        <a href="#" class="text-dark"  onclick="return confirm('Are you sure to change!!!')">--}}
                        {{--                                            {{$post->status == 1 ? 'Active' : 'Inactive'}}--}}
                        {{--                                        </a>--}}
                        {{--                                    </td>--}}
                        {{--                                    <td>--}}
                        {{--                                        <a href="{{route('posts.edit', $post->id)}}"--}}
                        {{--                                           class="btn btn-primary btn-sm">Edit</a>--}}
                        {{--                                        <a href="{{route('posts.show', $post->id)}}"--}}
                        {{--                                           class="btn btn-info btn-sm">View</a>--}}

                        {{--                                        {{Form::open(['route' => ['posts.destroy', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}--}}
                        {{--                                        <button type="submit"--}}
                        {{--                                                title="Delete"--}}
                        {{--                                                onclick="return confirm('Are you sure to delete!!!')"--}}
                        {{--                                                class="btn btn-sm btn-danger">Delete--}}
                        {{--                                        </button>--}}
                        {{--                                        {{Form::close()}}--}}
                        {{--                                    </td>--}}
                        {{--                                </tr>--}}
                        {{--                            @endforeach--}}
                        {{--                            </tbody>--}}
                        {{--                        </table>--}}


                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="postViewModal" tabindex="-1" role="dialog" aria-labelledby="post-view-1"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post View</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Id:</th>
                                <td id="postViewId"></td>
                            </tr>
                            <tr>
                                <th>Title:</th>
                                <td id="postViewTitle"></td>
                            </tr>
                            <tr>
                                <th>Body:</th>
                                <td id="postViewBody"></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td id="postViewStatus"></td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td id="postViewCreatedAt"></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal fade" id="postEditModal" tabindex="-1" role="dialog" aria-labelledby="post-view-1"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Post Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
{{--                        {{Form::open(['route' => ['posts.update', $id], 'method' => 'PUT', 'enctype'=>"multipart/form-data" ])}}--}}
{{--                        {{Form::open(['method' => 'PUT', 'enctype'=>"multipart/form-data" ])}}--}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" for="title" class="form-control" id="title">
                            <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Body</label>
                            <input type="textarea" name="body" for="body" class="form-control" id="body">
                            <span class="text-danger">{{$errors->has('body') ? $errors->first('body') : ''}}</span>
                        </div>

                        <div class="form-group">
                            <select class="custom-select mb-3" name="category_id">
                                <option selected>Select Category</option>
                                @foreach($categories as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    <span
                                        class="text-danger ">{{$errors->has('category_id') ? $errors->first('category_id') : ''}}
                                    </span>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload Image</label>
                            <input type="file" name="image" class="form-control-file" id="exampleFormControlFile1" accept='image/png'>
                        </div>


                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary btn-sm">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>

{{--                    {{Form::close()}}--}}
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>

        $(document).ready(function () {
            $('#posts').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('allposts') }}",
                    "dataType": "json",
                    "type": "POST",
                    "data": {_token: "{{csrf_token()}}"}
                },
                "columns": [
                    {"data": "id"},
                    {"data": "title"},
                    {"data": "category_name", "orderable": false},
                    {"data": "body"},
                    {"data": "created_at"},
                    {"data": "options", "orderable": false}
                ],
                // "columnDefs": [
                //     { "orderable": false, "targets": 5 }
                // ]

            });

        });


        /* Methods/Functions Start*/
        function openPostViewModal(post) {
            // sending value to modal
            $('#postViewId').html(post.id);
            $('#postViewTitle').html(post.title);
            $('#postViewBody').html(post.body);
            $('#postViewStatus').html(post.status == 1 ? 'Active' : 'Inactive');
            $('#postViewCreatedAt').html(post.created_at);

            // Open modal
            $('#postViewModal').modal('show');

        }

        function openPostEditModal(post) {
            // sending value to modal
            $('#postEditId').html(post.id);
            $('#postEditTitle').html(post.title);
            $('#postEditBody').html(post.body);
            $('#postEditStatus').html(post.status == 1 ? 'Active' : 'Inactive');
            $('#postEditCreatedAt').html(post.created_at);

            // Open modal
            $('#postEditModal').modal('show');

        }

        /* Methods/Functions End*/
    </script>
@endsection
