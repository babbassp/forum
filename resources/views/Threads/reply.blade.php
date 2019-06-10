<div class="card mb-3">
    <div class="card-header">
        <h4>
            <a href="#">{{ $reply->owner->name }}</a> said {{ $reply->created_at->diffForHumans() }}...
        </h4>
    </div>
    <div class="card-body">
        {{ $reply->body }}
    </div>
</div>