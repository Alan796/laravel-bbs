@if (count($posts))
    <ul class="media-list">
        @foreach ($posts as $post)
            <li class="media">
                <div class="media-left">
                    <a href="{{ route('users.show', $post->user_id) }}">
                        <img class="media-object img-thumbnail" style="width: 52px; height: 52px;" src="{{ $post->user->avatar }}" title="{{ $post->user->name }}">
                    </a>
                </div>

                <div class="media-body">

                    <div class="media-heading">
                        <a href="{{ route('categories.show', $post->category_id) }}">
                            <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                            {{ $post->category->name }}
                        </a>
                        <span> • </span>
                        <a href="{{ $post->link() }}" title="{{ $post->title }}">
                            {{ $post->title }}
                        </a>

                        @if ($post->is_good)
                            <span> • </span>
                            <span class="text-danger">精品</span>
                        @endif

                        <a class="pull-right" href="{{ $post->link() }}" >
                            <span class="badge"> {{ $post->reply_count }} </span>
                        </a>
                    </div>

                    <div class="media-body meta">
                        <a href="{{ route('users.show', $post->user_id) }}">
                            <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                            {{ $post->user->name }}
                        </a>
                        <span> • </span>
                        <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                        <span class="timeago" title="帖子发布于 {{ $post->created_at }}">
                            {{ $post->created_at->diffForHumans() }}
                        </span>

                        @if ($post->last_reply_user_id)
                            <span class="pull-right">
                                <a href="{{ route('users.show', $post->last_reply_user_id) }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    {{ $post->last_replier->name }}
                                </a>
                                <span> • </span>
                                <span class="glyphicon glyphicon-time" aria-hidden="true"></span>
                                <span class="timeago" title="最后回复于 {{ $post->last_replied_at }}">
                                    {{ $post->last_replied_at->diffForHumans() }}
                                </span>
                            </span>
                        @endif

                    </div>

                </div>
            </li>

            @if ( ! $loop->last)
                <hr>
            @endif

        @endforeach
    </ul>
@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif