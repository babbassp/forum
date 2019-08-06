<div id="reply-{{ $reply->id }}" class="card mb-3">
    <div class="card-header">
        <div class="d-flex">
            <div class="p2 mr-auto">
                <h4>
                    <a href="{{ route('profile', $reply->owner->name) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h4>
            </div>
            @if(auth()->id() == $reply->user_id)
                <div class="p2 mr-1">
                    <vue-form method="DELETE"
                              action="{{ route('reply.destroy', $reply->id) }}"
                              csrf="{{ csrf_token() }}">
                        <button class="btn btn-primary"
                                type="submit">Delete
                        </button>
                    </vue-form>
                </div>
            @endif
            <div class="p2">
                <vue-form method="POST"
                          action="{{ route('replies.favorites', $reply->id) }}"
                          csrf="{{ csrf_token() }}">
                    <button class="btn btn-outline-primary"
                            type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>
                        {{ $reply->favorites_count }} {{ Str::plural('Favorite', $reply->favorites_count) }}
                    </button>
                </vue-form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>