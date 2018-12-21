<hr style="border: gray 1px solid;">
<div class="reply-list">
    @foreach ($replies as $reply)
        @include('replies._reply')
        <hr>
    @endforeach
</div>