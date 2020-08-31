@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Forum
                        <a href="{{route('forums.create')}}" class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

{{--                        <table id="forums" class="table text-center">--}}
{{--                            <thead>--}}
{{--                            <th style="width: 5%">Id</th>--}}
{{--                            <th style="width: 20%">Title</th>--}}
{{--                            <th style="width: 10%">Category</th>--}}
{{--                            <th style="width: 35%">Body</th>--}}
{{--                            <th style="width: 15%">Created At</th>--}}
{{--                            <th style="width: 15%">Options</th>--}}
{{--                            </thead>--}}
{{--                        </table>--}}


                                                <table id="example2" class="table text-center">
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
                                                    @foreach($forums as $forum)
                                                        <tr>
                                                            <th scope="row">{{$i++}}</th>
                                                            <td>{{$forum->title}}</td>
                                                            <td>{{$forum->category->name}}</td>
                                                            <td>{{$forum->body}}</td>
                                                            <td>
                                                                <a href="#" class="text-dark"  onclick="return confirm('Are you sure to change!!!')">
                                                                    {{$forum->status == 1 ? 'Active' : 'Inactive'}}
                                                                </a>
                                                            </td>
                                                            <td>
                                                                <a href="{{route('forums.edit', $forum->id)}}"
                                                                   class="btn btn-primary btn-sm">Edit</a>
                                                                <a href="{{route('forums.show', $forum->id)}}"
                                                                   class="btn btn-info btn-sm">View</a>

                                                                {{Form::open(['route' => ['forums.destroy', $forum->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
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

                        {{$forums->links()}}


                    </div>
                </div>
            </div>
        </div>


        <!-- Modal -->
        <div class="modal fade" id="forumViewModal" tabindex="-1" role="dialog" aria-labelledby="forum-view-1"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">forum View</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Id:</th>
                                <td id="forumViewId"></td>
                            </tr>
                            <tr>
                                <th>Title:</th>
                                <td id="forumViewTitle"></td>
                            </tr>
                            <tr>
                                <th>Body:</th>
                                <td id="forumViewBody"></td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td id="forumViewStatus"></td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td id="forumViewCreatedAt"></td>
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
        <div class="modal fade" id="forumEditModal" tabindex="-1" role="dialog" aria-labelledby="forum-view-1"
             aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">forum Edit</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
{{--                        {{Form::open(['route' => ['forums.update', $id], 'method' => 'PUT', 'enctype'=>"multipart/form-data" ])}}--}}
{{--                        {{Form::open(['method' => 'PUT', 'enctype'=>"multipart/form-data" ])}}--}}
                        <div class="form-group">
                            <label for="exampleInputEmail1">Title</label>
                            <input type="text" name="title" for="title" class="form-control" id="title">
                            <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Body</label>
                            <input type="textarea" name="body" for="body" class="form-control" id="body">
                            <span class="text-danger ">{{$errors->has('body') ? $errors->first('body') : ''}}</span>
                        </div>

                        <div class="form-group">
                            <select class="custom-select mb-3" name="category_id">
                                <option selected>Select Category</option>
                                @foreach($forums as $category)
                                    <option value="{{$category->id}}">{{$category->name}}</option>
                                    <span
                                        class="text-danger ">{{$errors->has('category_id') ? $errors->first('category_id') : ''}}</span>
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
            $('#forums').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "{{ url('allforums') }}",
                    "dataType": "json",
                    "type": "forum",
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
        function openforumViewModal(forum) {
            // sending value to modal
            $('#forumViewId').html(forum.id);
            $('#forumViewTitle').html(forum.title);
            $('#forumViewBody').html(forum.body);
            $('#forumViewStatus').html(forum.status == 1 ? 'Active' : 'Inactive');
            $('#forumViewCreatedAt').html(forum.created_at);

            // Open modal
            $('#forumViewModal').modal('show');

        }

        function openforumEditModal(forum) {
            // sending value to modal
            $('#forumEditId').html(forum.id);
            $('#forumEditTitle').html(forum.title);
            $('#forumEditBody').html(forum.body);
            $('#forumEditStatus').html(forum.status == 1 ? 'Active' : 'Inactive');
            $('#forumEditCreatedAt').html(forum.created_at);

            // Open modal
            $('#forumEditModal').modal('show');

        }

        /* Methods/Functions End*/
    </script>
@endsection
