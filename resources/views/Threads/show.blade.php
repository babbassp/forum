@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header"><h4>{{ $thread->title }}</h4></div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                @foreach ($thread->replies as $reply)
                    <div class="card mb-3">
                        <div class="card-header">
                            <h4>
                                <a href="#">{{ $reply->user->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
                            </h4>
                        </div>
                        <div class="card-body">
                            {{ $reply->body }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
