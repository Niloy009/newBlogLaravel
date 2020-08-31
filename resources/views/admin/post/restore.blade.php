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
                            @foreach($trashposts as $post)
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
                                        {{Form::open(['route' => ['posts.restore', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
                                        <button type="submit"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to restore!!!')"
                                                class="btn btn-sm btn-outline-dark">Restore
                                        </button>
                                        {{Form::close()}}
                                        {{Form::open(['route' => ['posts.pdelete', $post->id], 'method'=>'DELETE', 'class' => 'd-inline'])}}
                                        <button type="submit"
                                                title="Delete"
                                                onclick="return confirm('Are you sure to restore!!!')"
                                                class="btn btn-sm btn-outline-danger">Permanent Delete
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
    </div>
@endsection
