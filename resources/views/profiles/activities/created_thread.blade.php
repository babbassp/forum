@component('profiles.activities.activity')
    @slot('title')
        {{ $profileUser->name }} published
        <a class="card-link"
           href="{{ route('threads.show', $activity->subject->getUrlParams()) }}">
            "{{ $activity->subject->title }}"
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent
