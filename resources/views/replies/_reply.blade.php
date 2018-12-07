<div class="media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', [$reply->user_id]) }}">
            <img class="media-object img-thumbnail" alt="{{ $reply->user->name }}" src="{{ $reply->user->avatar }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="{{ route('users.show', [$reply->user_id]) }}" title="{{ $reply->user->name }}">
                {{ $reply->user->name }}
            </a>
            <span> •  </span>
            <span class="meta" title="{{ $reply->created_at }}">{{ $reply->created_at->diffForHumans() }}</span>

            <span class="meta pull-right">
                <a href="javascript:;" class="like-reply-btn" likable-id="{{ $reply->id }}" likable-type="reply">
                    <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                    (<span class="reply-like-count" reply-id="{{ $reply->id }}">{{ $reply->like_count }}</span>)
                </a>

                <a href="javascript:;" class="reply-user-btn" title="回复TA" reply-id="{{ $reply->id }}" user-name="{{ $reply->user->name }}" reply-body-abbr="{{ str_limit($reply->body, 20) }}" style="margin-left: 10px;">
                    <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                </a>

                @can('destroy', $reply)
                    <a href="javascript:;" onclick="$('#destroy-reply-form').submit();" title="删除评论" style="margin-left: 10px;">
                        <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </a>
                    <form id="destroy-reply-form" action="{{ route('replies.destroy', $reply->id) }}" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('DELETE') }}
                    </form>
                @endcan

            </span>
        </div>

        <div class="reply-content">
            {!! $reply->body !!}
        </div>
    </div>
</div>