<div class="panel panel-default">
    <div class="panel-body">
        <a href="{{ route('posts.create') }}" class="btn btn-success btn-block" aria-label="Left Align">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span> 新建帖子
        </a>
    </div>
</div>

@if (count($activists))
    <div class="panel panel-default">
        <div class="panel-body activists">

            <div class="text-center">活跃用户</div>
            <hr>
            @foreach ($activists as $activist)
                <a class="media" href="{{ route('users.show', $activist->id) }}">
                    <div class="media-left media-middle">
                        <img src="{{ $activist->avatar }}" width="24px" height="24px" class="img-circle media-object">
                    </div>

                    <div class="media-body">
                        <span class="media-heading">{{ $activist->name }}</span>
                    </div>
                </a>
            @endforeach

        </div>
    </div>
@endif