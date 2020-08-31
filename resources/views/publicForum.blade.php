@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row ">
            @foreach($forums as $forum)
                <div class="col-sm-4 mb-3">
                    <div class="jumbotron jumbotron-fluid">
                        <img src="{{$forum->image}}" class="img-fluid w-100 h-75" alt="Responsive image">
                        <h1 class="display-4">{{$forum->title}}</h1>
                        <p class="lead"></p>
                        <hr class="my-4">
                        <p>{{substr(strip_tags($forum->body),0,50)}} ...</p>
                        <a class="btn btn-primary btn-sm stretched-link" href="{{route('get.single.forums', $forum->id)}}" role="button">Details</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
