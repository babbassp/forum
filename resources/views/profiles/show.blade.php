@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="text-center mb-3">
                    <h1 class="text-white">{{ $profileUser->name }}</h1>
                </div>
                @foreach($activities as $date => $activitiesOnThisDate)
                    <h4 class="text-white">On {{ $date }}:</h4>
                    @foreach($activitiesOnThisDate as $activity)
                        @include("profiles.activities.{$activity->type}")
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection