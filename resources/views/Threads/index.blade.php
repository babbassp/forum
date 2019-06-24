@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="card-header">Forum Threads</div>
                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="card-title">
                                    <div class="d-flex justify-content-between">
                                        <div class="p-2">
                                            <h4><a href="{{ route('threads.show', $thread->getUrlParams()) }}">
                                                    {{ $thread->title }}</a></h4>
                                        </div>
                                        <div class="p-2">
                                            {{ $thread->replies_count }} {{ Str::plural('reply', $thread->replies_count) }}
                                        </div>
                                    </div>
                                </div>
                                {{ $thread->body }}
                            </article>
                            <hr>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
