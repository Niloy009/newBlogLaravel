@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        Posts
                        <a href="#" data-toggle="modal" data-target="#tagCreate"
                           class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="tags" class="table text-center">
                            <thead>
                            <tr>
                                <th style="width: 5%">#</th>
                                <th style="width: 20%">Name</th>
                                <th style="width: 50%">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($tags as $tag)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$tag->name}}</td>

                                    <td>
                                        {{--                                        <a href="{{route('posts.edit', $post->id)}}"--}}
                                        {{--                                           class="btn btn-primary btn-sm">Edit</a>--}}
                                        {{--                                        <a href="{{route('posts.show', $post->id)}}"--}}
                                        {{--                                           class="btn btn-info btn-sm">View</a>--}}
                                        <button type="button" onclick="openTagEditModal({{$tag->id}})"
                                                class="btn btn-primary btn-sm">Edit
                                        </button>

                                        <button type="button" onclick="openShowTagModal({{$tag->id}})"
                                                class="btn btn-info btn-sm">
                                            View
                                        </button>

                                        {{Form::open(['route' => ['tags.destroy', $tag->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
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

        <!-- Tag Create Modal -->
        <div class="modal fade" id="tagCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tag Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{Form::open(['route' => 'tags.store', 'method' => 'POST'])}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Tag Name</label>
                            <input type="text" name="name" class="form-control" id="name">
                            <span class="text-danger ">{{$errors->has('name') ? $errors->first('name') : ''}}</span>
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

        <!-- Tag Show Modal -->
        <div class="modal fade" id="tagShowModal" tabindex="-1" aria-labelledby="tagShowLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tagShowLabel">Tag Show</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <table class="table table-borderless">
                            <tbody>
                            <tr>
                                <th>Id:</th>
                                <td id="showTagId"></td>
                            </tr>
                            <tr>
                                <th>Tag Name:</th>
                                <td id="showTagName"></td>
                            </tr>
                            <tr>
                                <th>Created At:</th>
                                <td id="showTagCreatedAt"></td>
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
{{--        <div class="modal fade" id="postEditModal" tabindex="-1" aria-labelledby="postEditLabel"--}}
{{--             aria-hidden="true">--}}
{{--            <div class="modal-dialog">--}}
{{--                <div class="modal-content">--}}
{{--                    <div class="modal-header">--}}
{{--                        <h5 class="modal-title" id="postEditLabel">Post Edit</h5>--}}
{{--                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                            <span aria-hidden="true">&times;</span>--}}
{{--                        </button>--}}
{{--                    </div>--}}
{{--                    {{Form::open(['id' => 'postEditForm', 'method' => 'PUT' ])}}--}}
{{--                    --}}{{--                    {{Form::open(['route' => ['categories.update', $category->id], 'method' => 'PUT' ])}}--}}
{{--                    <div class="modal-body">--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Post title</label>--}}
{{--                            <input type="text" name="title"  class="form-control" id="editPostTitle">--}}
{{--                            <span class="text-danger ">{{$errors->has('title') ? $errors->first('title') : ''}}</span>--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="name">Post Body</label>--}}
{{--                            <input type="text" name="body"  class="form-control" id="editPostBody">--}}
{{--                        </div>--}}
{{--                        <div class="form-group custom-file">--}}
{{--                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>--}}
{{--                            <input type="file" name="image" value="{{$post->img}}" class="custom-file-input"--}}
{{--                                   id="inputGroupFile01"--}}
{{--                                   aria-describedby="inputGroupFileAddon01">--}}
{{--                        </div>--}}
{{--                        <div class="form-group">--}}
{{--                            <label for="category">Category Name</label>--}}
{{--                            <select class="custom-select" name="category_id">--}}
{{--                                @foreach($categories as $category)--}}
{{--                                    <option--}}
{{--                                        value="{{$category->id}}" {{$category->id == $post->category_id ? 'selected' : '' }}>{{$category->name}}</option>--}}
{{--                                @endforeach--}}
{{--                            </select>--}}
{{--                        </div>--}}
{{--                        <div class="form-group ">--}}

{{--                            <label class="d-block">Status</label>--}}

{{--                            <label for="editCategoryStatusActive" class="mr-4">--}}
{{--                                <input class="" type="radio" name="status"  id="editCategoryStatusActive" value="1" checked> Active--}}
{{--                            </label>--}}
{{--                            <label for="editCategoryStatusInactive">--}}
{{--                                <input class="" type="radio" name="status" id="editCategoryStatusInactive" value="0"> Inactive--}}
{{--                            </label>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <div class="modal-footer">--}}
{{--                        <button type="submit" class="btn btn-sm btn-primary">Update</button>--}}
{{--                        <button type="button" class="btn btn-sm btn-sm btn-secondary" data-dismiss="modal">Close</button>--}}
{{--                    </div>--}}
{{--                    {{Form::close()}}--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function () {
            $('#tags').DataTable({
                "columnDefs": [
                    {"orderable": false, "targets": [2]}
                ]
            });
        });
        let tags = @json($tags)
            // functions
            function openShowTagModal(id) {

                let tag = tags.find(tag => tag.id == id)
                $('#showTagId').html(tag.id);
                $('#showTagName').html(tag.name);
                $('#showTagCreatedAt').html(tag.created_at);
                // Open modal
                $('#tagShowModal').modal('show');
            }
    </script>
@endsection
