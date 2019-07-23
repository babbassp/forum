@extends('layouts.app')

@section('content')
    <div class="container">
        {{-- The thread --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <div class="p-2">
                                <h4>
                                    <a href="{{ route('profile', $thread->getCreatorName()) }}">{{ $thread->getCreatorName() }}</a> posted: {{ $thread->title }}
                                </h4>
                            </div>
                            @can('delete', $thread)
                                <div class="p2">
                                    <vue-form method="DELETE"
                                              action="{{ route('threads.destroy', $thread->getUrlParams()) }}"
                                              csrf="{{ csrf_token() }}">
                                        <button type="submit" class="btn btn-primary">Delete</button>
                                    </vue-form>
                                </div>
                            @endcan
                        </div>
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
                    <vue-form method="POST"
                              action="{{ route('threads.reply.store', $thread->getUrlParams()) }}"
                              csrf="{{ csrf_token() }}">
                        <div class="form-group">
                            <textarea class="form-control rounded"
                                      type="text" id="body" name="body"
                                      placeholder="Add a public reply..."
                                      rows="5">
                            </textarea>
                        </div>
                        <button class="btn btn-outline-primary" type="submit">REPLY</button>
                    </vue-form>
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
