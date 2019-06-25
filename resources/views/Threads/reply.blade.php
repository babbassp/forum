<div class="card mb-3">
    <div class="card-header">
        <div class="d-flex justify-content-between">
            <div class="p2">
                <h4><a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...</h4>
            </div>
            <div class="p2">
                <form method="POST" action="{{ route('replies.favorites', $reply->id) }}">
                    @csrf
                    <button class="btn btn-outline-primary" type="submit" {{ $reply->isFavorited() ? 'disabled' : '' }}>Favorite</button>
                    {{ $reply->favorites()->count() }} {{ Str::plural('Favorite', $reply->favorites()->count()) }}
                </form>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>