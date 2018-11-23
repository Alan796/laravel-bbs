@extends('layouts.app')

@section('title', if_route('categories.show') ? $category->name : '帖子列表')

@section('content')
    <div class="row">
        <div class="col-lg-9 col-md-9 post-list">

            @if (if_route('categories.show'))
                <div class="alert alert-info" role="alert">
                    {{ $category->name }} ：{{ $category->description }}
                </div>
            @endif

            <div class="panel panel-default">

                <div class="panel-heading">
                    <ul class="nav nav-pills">
                        <li role="presentation" class="{{ active_class(!if_query('order', 'recent_publish')) }}">
                            <a href="{{ Request::url() }}?order=recent_replied">最后回复</a>
                        </li>
                        <li role="presentation" class="{{ active_class(if_query('order', 'recent_publish')) }}">
                            <a href="{{ Request::url() }}?order=recent_publish">最新发布</a>
                        </li>
                    </ul>
                </div>

                <div class="panel-body">
                    {{-- 话题列表 --}}
                    @include('posts._post_list', ['posts' => $posts])
                    {{-- 分页 --}}
                    {!! $posts->appends(Request::except('page'))->render() !!}
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-3 sidebar">
            @include('posts._sidebar')
        </div>
    </div>
@endsection