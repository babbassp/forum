@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Create a New Thread</div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('threads.store') }}">
                            @csrf
                            <div class="form-group">
                                @error('channel_id')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="channel">Channel: </label>
                                <select class="form-control" name="channel_id" id="channel" required>
                                    <option value="">Choose one...</option>
                                    @foreach ($channels as $channel)
                                        <option value="{{ $channel->id }}"
                                                {{$channel->id == old('channel_id') ? 'selected' : ''}}>
                                            {{ $channel->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                @error('title')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="title">Title:</label>
                                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}"
                                       type="text" id="title"
                                       name="title" value="{{ old('title') }}" required>
                            </div>
                            <div class="form-group">
                                @error('body')
                                <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                                <label for="body">Body:</label>
                                <textarea class="form-control" type="text" id="body"
                                          name="body" rows="8" required>{{ old('body') }}</textarea>
                            </div>
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

