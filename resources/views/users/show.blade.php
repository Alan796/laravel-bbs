@extends('layouts.app')

@section('title', $user->name . ' 个人中心')

@section('content')

    @include('commons._error')

    <div class="row">
        <div class="col-lg-3 col-md-3 hidden-sm hidden-xs user-info">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="media">
                        <div align="center">
                            <img class="thumbnail img-responsive" src="{{ $user->avatar }}" width="300px" height="300px">
                        </div>

                        <div class="media-body">
                            <hr>

                            @includeWhen(!Auth::check() || Auth::id() !== $user->id, 'users._follow_form')

                            @include('users._confinement_status')

                            @can('manage users')
                                @include('users._confinement_form')
                            @endcan

                            <div class="center-block">
                                <ul class="nav nav-pills">
                                    <li>
                                        <a href="{{ route('users.followers', $user->id) }}">{{ $user->follower_count }} 个粉丝</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('users.followees', $user->id) }}">{{ $user->followee_count }} 个关注</a>
                                    </li>
                                </ul>
                            </div>
                            <hr>
                            <h4><strong>个人简介</strong></h4>
                            <p>{{ $user->introduction }}</p>
                            <hr>
                            <h4><strong>注册于</strong></h4>
                            <p>{{$user->created_at->diffForHumans()}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-9 col-md-9 col-sm-12 col-xs-12">
            <div class="panel panel-default">
                <div class="panel-body">
                <span>
                    <h1 class="panel-title pull-left" style="font-size:30px;">{{ $user->name }}
                        <small>{{ $user->email }}</small>
                    </h1>
                </span>
                </div>
            </div>
            <hr>

            {{-- 用户发布的内容 --}}
            <div class="panel panel-default">
                <div class="panel-body">
                    <ul class="nav nav-tabs">
                        <li class="{{ active_class(!if_query('tab', 'replies')) }}">
                            <a href="{{ Request::url() }}">Ta 的帖子</a>
                        </li>
                        <li class="{{ active_class(if_query('tab', 'replies')) }}">
                            <a href="{{ Request::url() }}?tab=replies">Ta 的评论</a>
                        </li>
                    </ul>

                    @if (!if_query('tab', 'replies'))
                        @include('users._posts', ['posts' => $user->posts()->recent()->paginate(5)])
                    @else
                        @include('users._replies', ['replies' => $user->replies()->with('post')->recent()->paginate(5)])
                    @endif
                </div>
            </div>

        </div>
    </div>
@stop