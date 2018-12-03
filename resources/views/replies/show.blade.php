@extends('layouts.app')

@section('title', '楼层所有回复')

@section('content')
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="panel panel-default post-reply">
                <div class="panel-body">

                    <div class="reply-list">
                        @foreach ($replies as $reply)
                            <div class="media">
                                @include('replies._reply', ['reply' => $reply])
                            </div>
                            <hr>
                        @endforeach
                    </div>

                    @includeWhen(Auth::check(), 'posts._reply_box', ['post' => $post])

                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')

    @include('scripts.functions.like')

    @include('scripts._like_reply')

    @include('scripts._reply_user')

@endsection