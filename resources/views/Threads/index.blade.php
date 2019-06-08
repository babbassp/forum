@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Forum Threads</div>
                    <div class="card-body">
                        @foreach($threads as $thread)
                            <article>
                                <div class="card-title">
                                    <h4><a href="{{ route('threads.show', $thread) }}">{{ $thread->title }}</a></h4>
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
