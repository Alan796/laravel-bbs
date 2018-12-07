<div id="follow_form" class="center-block">
    @if (!Auth::check() || !Auth::user()->isFollowing($user->id))
        <form action="{{ route('follows.store', $user->id) }}" method="POST">
            {{ csrf_field() }}
            <button type="submit" class="btn btn-primary">关注</button>
        </form>
    @else
        <form action="{{ route('follows.destroy', $user->id) }}" method="POST">
            {{ csrf_field() }}
            {{ method_field('DELETE') }}
            <button type="submit" class="btn">取消关注</button>
        </form>
    @endif
</div>
<hr>