@include('commons._error')
<div class="reply-box">
    <form id="replies-store-form" action="{{ route('replies.store') }}" method="POST" accept-charset="UTF-8">
        <div id="repliee-label" class="alert alert-info" aria-hidden="true">
            <span style="margin-right: 10px;">
                @
                <span id="repliee-name"></span>
                :
                <span id="repliee-body"></span>
            </span>
            <button type="button" class="close" aria-hidden="true" id="hide-reply-user-label-btn">×</button>
        </div>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="post_id" value="{{ $post->id }}">
        <input type="hidden" name="reply_id" value="">
        <div class="form-group">
            <textarea class="form-control" rows="3" placeholder="分享你的想法" name="body"></textarea>
        </div>
        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-share"></i>评论</button>
    </form>
</div>