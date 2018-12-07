<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', $notification->data['user_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['user_name'] }}" src="{{ $notification->data['user_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="{{ route('users.show', $notification->data['user_id']) }}">{{ $notification->data['user_name'] }}</a>
            赞了你的{{ $notification->data['likable_name'] }}
            <a href="{{ $notification->data['likable_url'] }}">{{ $notification->data['likable_title'] }}</a>

            <span class="meta pull-right" title="{{ $notification->created_at }}">
                <span class="glyphicon glyphicon-clock" aria-hidden="true"></span>
                {{ $notification->created_at->diffForHumans() }}
            </span>

            @if (!$notification->read_at)
                <span class="badge" style="background-color: red;">新的通知</span>
            @endif
        </div>
    </div>
</div>
<hr>