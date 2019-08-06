@component('profiles.activities.activity')
    @slot('title')
        <a class="card-link"
           href="{{ route('threads.show', $activity->subject->favorited->thread->getUrlParams()) }}#reply-{{ $activity->subject->favorited->id }}">
            {{ $profileUser->name }} favorited a reply
        </a>
    @endslot

    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent