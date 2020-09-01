@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        Document
                        {{--                        <a href="{{route('documents.create')}}" class="btn btn-success btn-sm float-right">Add New</a>--}}
                        <a href="#" data-toggle="modal" data-target="#documentCreate"
                           class="btn btn-success btn-sm float-right">Add New</a>
                    </div>

                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <table id="documents" class="table text-center">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Name</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($documents as $document)
                                <tr>
                                    <th scope="row">{{$i++}}</th>
                                    <td>{{$document->file}}</td>

                                    <td>
                                        {{--                                        <a href="{{route('documents.edit', $document->id)}}"--}}
                                        {{--                                           class="btn btn-primary btn-sm">Edit</a>--}}
                                        <a href="{{route('documents.show', $document->id)}}"
                                           class="btn btn-info btn-sm">View</a>

                                        {{Form::open(['route' => ['documents.destroy', $document->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
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


                        {{--                        {{$documents->links()}}--}}
                    </div>
                </div>
            </div>
        </div>

        <!-- document Create Modal -->
        <div class="modal fade" id="documentCreate" tabindex="-1" aria-labelledby="exampleModalLabel"
             aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Document Create</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    {{Form::open(['route' => 'documents.store', 'method' => 'POST','enctype' => 'multipart/form-data' ])}}
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="exampleFormControlFile1">Upload File</label>
                            <input type="file" name="file" for="file" class="form-control-file" id="file">
                            <span class="text-danger ">{{$errors->has('file') ? $errors->first('file') : ''}}</span>
                        </div>

                    </div>
                    <div class="modal-footer">

                        <button type="submit" class="btn btn-primary">Create</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
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
            $('#documents').DataTable({
                "columnDefs": [
                    {"orderable": false, "targets": [2]}
                ]
            });
        });
    </script>
@endsection
