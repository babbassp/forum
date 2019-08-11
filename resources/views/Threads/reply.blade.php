<reply :attributes="{{$reply}}" inline-template v-cloak>
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
                @auth
                    <div class="p2">
                        <favorite :reply="{{ $reply }}"></favorite>
                    </div>
                @endauth
            </div>
        </div>
        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" name="textarea-reply" id="textarea-reply" v-model="body"></textarea>
                </div>
                <div class="d-flex">
                    <div class="form-group">
                        <div class="p2 mr-1">
                            <button class="btn btn-sm btn-link" type="submit" v-bind:disabled="!body" v-on:click="update()">Update</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="p2">
                            <button class="btn btn-sm" v-on:click="editing = false">Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else v-text="body"></div>
        </div>
        @can('delete', $reply)
            <div class="card-footer">
                <div class="d-flex">
                    <div class="p2 mr-1">
                        <button class="btn btn-sm btn-outline-primary" type="submit"
                                v-on:click="editing = true">Edit
                        </button>
                    </div>
                    <div class="p2">
                        <vue-form method="DELETE"
                                  action="{{ route('reply.destroy', $reply->id) }}"
                                  csrf="{{ csrf_token() }}">
                            <button class="btn btn-sm btn-outline-danger"
                                    type="submit">Delete
                            </button>
                        </vue-form>
                    </div>
                </div>
            </div>
        @endcan
    </div>
</reply>