<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', $notification->data['replier_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['replier_name'] }}" src="{{ $notification->data['replier_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="{{ route('users.show', $notification->data['replier_id']) }}">{{ $notification->data['replier_name'] }}</a>
            回复了你在
            <a href="{{ $notification->data['post_url'] }}">{{ $notification->data['post_title'] }}</a>
            下的评论

            <span class="meta pull-right" title="{{ $notification->created_at }}">
                <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                {{ $notification->created_at->diffForHumans() }}
            </span>

            @if (!$notification->read_at)
                <span class="badge" style="background-color: red;">新的通知</span>
            @endif
        </div>
        <div class="reply-content">
            {!! $notification->data['reply_body'] !!}
        </div>
    </div>
</div>
<hr>