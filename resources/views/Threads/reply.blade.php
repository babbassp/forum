<div id="reply-{{ $reply->id }}" class="card mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="p2">
                <h4>
                    <a href="{{ route('profile', $reply->owner->name) }}">
                        {{ $reply->owner->name }}
                    </a> said {{ $reply->created_at->diffForHumans() }}...
                </h4>
            </div>
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