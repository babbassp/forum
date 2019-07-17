@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="text-center mb-3">
            <h1 class="text-white">{{ $profileUser->name }}</h1>
        </div>
        @foreach($threads as $thread)
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card mb-3">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <a class="card-link"
                                   href="{{ route('threads.show', $thread->getUrlParams()) }}">
                                    {{ $thread->title }}
                                </a>
                                <span>{{$thread->created_at->diffForHumans()}}</span>
                            </div>
                            <hr>
                            <p class="card-text">
                                {{ $thread->body }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        {{ $threads->links() }}
    </div>
@endsection