@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- The thread --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h4>
                            <a href="{{ route('profile', $thread->getCreatorName()) }}">{{ $thread->getCreatorName() }}</a> posted:
                            {{ $thread->title }}
                        </h4>
                    </div>
                    <div class="card-body">
                        {{ $thread->body }}
                    </div>
                </div>
                {{-- Replies to the thread --}}
                @foreach ($replies as $reply)
                    @include('threads.reply')
                @endforeach
                {{ $replies->links() }}
                {{-- Create a new thread --}}
                @if( auth()->check() )
                    <form method="POST" action="{{ route('threads.reply.store', $thread->getUrlParams()) }}">
                        @csrf
                        <div class="form-group">
                                    <textarea class="form-control rounded" type="text"
                                              id="body" name="body" placeholder="Add a public reply..."
                                              rows="5"></textarea>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">REPLY</button>
                    </form>
                @else
                    <p>Please <a href="{{ route('login') }}">sign in</a> to participate.</p>
                @endif
            </div>
            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-body">
                        <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                            <a href="#">{{ $thread->creator->name }}</a> and currently has {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
