@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>
                            <a href="#">{{ $thread->getCreatorName() }}</a> posted:
                            {{ $thread->title }}
                        </h4>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-10">
                @foreach ($thread->replies as $reply)
                    @include('threads.reply')
                @endforeach
            </div>
        </div>
        @if( auth()->check() )
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <form method="POST" action="{{ route('threads.reply.store', $thread->getUrlParams()) }}">
                        @csrf
                        <div class="form-group">
                                    <textarea class="form-control rounded"
                                              type="text"
                                              id="body" name="body"
                                              placeholder="Add a public reply..."
                                              rows="5"></textarea>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">REPLY</button>
                    </form>
                </div>
            </div>
        @else
            <p>Please <a href="{{ route('login') }}">sign in</a> to participate.</p>
        @endif
    </div>
@endsection
