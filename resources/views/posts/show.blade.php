@extends('layouts.app')

@section('title', $post->title)

@section('description', $post->excerpt)

@section('content')

    <div class="row">

        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs author-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="text-center">
                        作者：{{ $post->user->name }}
                    </div>
                    <hr>
                    <div class="media">
                        <div align="center">
                            <a href="{{ route('users.show', $post->user->id) }}">
                                <img class="thumbnail img-responsive" src="{{ $post->user->avatar }}" width="300px" height="300px">
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12 post-content">
            <div class="panel panel-default">
                <div class="panel-body post-content">

                    @if ($post->is_good)
                        <div class="post-label-left post-good">
                            <span class="glyphicon glyphicon-bookmark" aria-hidden="true" title="该帖子于 {{ $post->set_good_at->diffForHumans() }} 由 {{ $post->set_good_by }} 设为精品贴"></span>
                        </div>
                    @endif

                    <div class="post-label-right link" id="like-post-btn" likable-id="{{ $post->id }}" likable-type="post">
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                    </div>

                    <h1 class="text-center">
                        {{ $post->title }}
                    </h1>

                    <div class="article-meta text-center">
                        {{ $post->created_at->diffForHumans() }}
                        <span> • </span>
                        <span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span>
                        {{ $post->view_count }}
                        <span> • </span>
                        <span class="glyphicon glyphicon-thumbs-up" aria-hidden="true"></span>
                        <span id="like-count">{{ $post->like_count }}</span>
                        <span> • </span>
                        <span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
                        {{ $post->reply_count }}
                    </div>

                    <div class="post-body">
                        {!! $post->body !!}
                    </div>

                    @can('dominate', $post)
                        <div class="operate">
                            <hr>
                            <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-default btn-xs" role="button">
                                <i class="glyphicon glyphicon-edit"></i> 编辑
                            </a>
                            <a href="#" class="btn btn-default btn-xs" role="button" onclick="event.preventDefault();document.getElementById('delete-post-form').submit();">
                                <i class="glyphicon glyphicon-trash"></i> 删除
                            </a>
                            <form id="delete-post-form" action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                            </form>
                        </div>
                    @endcan

                </div>

            </div>

            {{-- 用户评论列表 --}}
            <div class="panel panel-default post-reply">
                <div class="panel-body">
                    {{--评论框--}}
                    @includeWhen(Auth::check(), 'posts._reply_box', ['post' => $post])
                    {{--评论列表--}}
                    @include('posts._reply_list', ['replies' => $replies])
                </div>
            </div>

        </div>

    </div>
@stop

@section('scripts')

    @include('scripts.functions._like')

    @include('scripts._like_post')

    @include('scripts._like_reply')

    @include('scripts._reply_user')

@endsection