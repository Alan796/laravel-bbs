<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', $notification->data['follower_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['follower_name'] }}" src="{{ $notification->data['follower_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            <a href="{{ route('users.show', $notification->data['follower_id']) }}">{{ $notification->data['follower_name'] }}</a>
            关注了你

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