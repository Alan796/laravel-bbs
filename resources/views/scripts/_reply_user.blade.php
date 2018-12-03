<script>
    $(function() {

        /*初始隐藏标签*/
        $('#repliee-label').hide();

        /*回复其他用户的回复*/
        $('.reply-user-btn').click(function() {
            var is_loged = {{ Auth::check() ? 'true' : 'false' }};

            if (!is_loged) {
                window.location.href = '{{ route("login") }}';
            } else {
                $('#repliee-label').show();  //显示标签
                $('#replies-store-form [name="reply_id"]').val($(this).attr('reply-id'));   //加上(替换)reply_id
                $('#repliee-name').text($(this).attr('user-name'));  //标签加上(替换)用户名
                $('#repliee-body').text($(this).attr('reply-body-abbr'));   //标签加上(替换)被回复缩略
                $('#replies-store-form [name="body"]').focus();
            }
        });

        /*取消回复其他用户的回复*/
        $('#hide-reply-user-label-btn').click(function() {
            $('#repliee-label').hide();  //隐藏标签
            $('#replies-store-form [name="reply_id"]').val(''); //清除reply_id
            $('#repliee-name').text(''); //清除标签上的用户名
            $('#repliee-body').text('');   //标签清除被回复缩略
        });
        
    })
</script>