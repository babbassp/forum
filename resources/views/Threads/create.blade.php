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
                                <label for="title">Title:</label>
                                <input class="form-control" type="text" id="title" name="title">
                            </div>
                            <div class="form-group">
                                <label for="body">Body:</label>
                                <textarea class="form-control" type="text" id="body" name="body" rows="8"></textarea>
                            </div>
                            <button class="btn btn-outline-primary" type="submit">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

