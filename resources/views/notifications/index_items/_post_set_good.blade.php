<div class="media">
    <div class="avatar pull-left">
        <a href="{{ route('root') }}">
            <img class="media-object img-thumbnail" src="{{ config('app.url') }}/images/icons/bbs.jpg"  style="width:48px;height:48px;"/>
        </a>
    </div>

    <div class="infos">
        <div class="media-heading">
            你的帖子
            <a href="{{ $notification->data['post_url'] }}">{{ $notification->data['post_title'] }}</a>
            被{{ $notification->data['set_good_by'] }}设为精品贴

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