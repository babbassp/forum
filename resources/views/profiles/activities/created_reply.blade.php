@component('profiles.activities.activity')
    @slot('title')
        {{ $profileUser->name }} replied to
        <a class="card-link"
           href="{{ route('threads.show', $activity->subject->thread->getUrlParams()) }}">
            "{{ $activity->subject->thread->title }}"
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->body }}
    @endslot
@endcomponent