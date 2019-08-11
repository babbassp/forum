@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h1>{{ $profileUser->name }}</h1>
                @forelse($activities as $date => $activitiesOnThisDate)
                    <h4>On {{ $date }}:</h4>
                    @foreach($activitiesOnThisDate as $activity)
                        @if(view()->exists("profiles.activities.{$activity->type}"))
                            @include("profiles.activities.{$activity->type}")
                        @endif
                    @endforeach
                @empty
                    <p>Nothing here...</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection