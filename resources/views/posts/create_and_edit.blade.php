@extends('layouts.app')

@section('styles')
    <link href="{{ asset('css/simditor.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">

                <div class="panel-body">
                    <h2 class="text-center">
                        <i class="glyphicon glyphicon-edit"></i>

                        @if ($post->id)
                            编辑帖子
                        @else
                            发布帖子
                        @endif

                    </h2>

                    <hr>

                    @include('commons._error')

                    @if ($post->id)
                        <form action="{{ route('posts.update', $post->id) }}" method="POST" accept-charset="UTF-8">
                            {{ method_field('PUT') }}
                    @else
                        <form action="{{ route('posts.store') }}" method="POST" accept-charset="UTF-8">
                    @endif

                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <input class="form-control" type="text" name="title" value="{{ old('title', $post->title ) }}" placeholder="请填写标题" required/>
                        </div>

                        <div class="form-group">
                            <select class="form-control" name="category_id" required>
                                <option value="" hidden disabled {{ $post->id ? '' : 'selected' }}>请选择分类</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}" {{ $category->id === $post->category_id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <textarea name="body" class="form-control" id="editor" rows="3" placeholder="请填入至少三个字符的内容。" required>{{ old('body', $post->body ) }}</textarea>
                        </div>

                        <div class="well well-sm">
                            <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-ok" aria-hidden="true"></span> 保存</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{ asset('js/module.js') }}"></script>
    <script src="{{ asset('js/hotkeys.js') }}"></script>
    <script src="{{ asset('js/uploader.js') }}"></script>
    <script src="{{ asset('js/simditor.js') }}"></script>
    <script>
    $(function() {
        var editor = new Simditor({
            textarea: $('#editor'),
            upload: {
                url: '{{ route('posts.image_store') }}',
                params: { _token: '{{ csrf_token() }}' },
                fileKey: 'image',
                connectionCount: 3,
                leaveConfirm: '文件上传中，关闭此页面将取消上传。'
            },
            pasteImage: true
        });
    })
    </script>
@endsection