<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('users.show', $notification->data['confiner_id']) }}">
            <img class="media-object img-thumbnail" alt="{{ $notification->data['confiner_name'] }}" src="{{ $notification->data['confiner_avatar'] }}"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            你已被管理员
            <a href="{{ route('users.show', $notification->data['confiner_id']) }}">{{ $notification->data['confiner_name'] }}</a>
            禁言，禁言时间为
            @if($notification->data['is_permanent'])
                永久禁言
            @else
                {{ $notification->data['confined_at'] }} 至 {{ $notification->data['expired_at'] }}
            @endif

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