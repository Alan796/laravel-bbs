@if (count($posts))
    <ul class="list-group">
        @foreach ($posts as $post)
            <li class="list-group-item">
                <a href="{{ route('categories.show', $post->category_id) }}" class="text-muted">
                    <span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                    {{ $post->category->name }}
                    <span> • </span>
                </a>
                <a href="{{ route('posts.show', $post->id) }}">
                    {{ $post->title }}
                </a>

                @if ($post->is_good)
                    <span> • </span>
                    <span class="text-danger">精品</span>
                @endif

                <span class="meta pull-right">
                    {{ $post->reply_count }} 回复
                    <span> ⋅ </span>
                        {{ $post->created_at->diffForHumans() }}
                </span>
            </li>
        @endforeach
    </ul>
@else
    <div class="empty-block">暂无数据 ~_~ </div>
@endif

{{-- 分页 --}}
{!! $posts->render() !!}