@extends('layouts.app')

@section('content')
    <thread-view :initial-replies-count="{{ $thread->replies_count }}" inline-template>
        <div class="container">
            {{-- The thread --}}
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex justify-content-between">
                                <div class="p-2">
                                    <h4>
                                        <a href="{{ route('profile', $thread->getCreatorName()) }}">
                                            {{ $thread->getCreatorName() }}
                                        </a> posted: {{ $thread->title }}
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
                    <replies :data="{{ $thread->replies }}" @remove="repliesCount--" @add="repliesCount++"></replies>
                </div>
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <p>This thread was published {{ $thread->created_at->diffForHumans() }} by
                                <a href="#">{{ $thread->creator->name }}</a>
                                and currently has <span v-text="repliesCount"></span> <span v-text="repliesString"></span>.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </thread-view>
@endsection
