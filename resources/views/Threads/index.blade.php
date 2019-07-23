@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                @forelse($threads as $thread)
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="p-2">
                                    <h4><a href="{{ route('threads.show', $thread->getUrlParams()) }}">
                                            {{ $thread->title }}
                                        </a></h4>
                                </div>
                                <div class="p-2">
                                    {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            {{ $thread->body }}
                        </div>
                    </div>
                @empty
                    <p>No results...</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection