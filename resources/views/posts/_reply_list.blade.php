@php
    $maxLength = 5;
@endphp

<hr style="border: gray 1px solid;">
<div class="reply-list">
    @foreach ($replies as $reply)
        @if ($reply->getDepth() + 1 > $maxLength)
            <a href="{{ route('replies.show', $reply->id) }}" class="center-block">
                <span class="glyphicon glyphicon-zoom-in" aria-hidden="true"></span>
                查看楼层全部回复
            </a>
        @endif

        @foreach ($reply->ancestorsAndSelfFromTrunk($maxLength)->with('user')->get() as $clasp)
            <div class="media" style="margin-left: {{ $loop->index * 25 }}px;">
                @include('replies._reply', ['reply' => $clasp])
            </div>
            <hr>
        @endforeach
        <hr style="border: gray 1px solid;">
    @endforeach
</div>