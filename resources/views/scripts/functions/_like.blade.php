<script>
    /**
     * 点赞
     *
     * @param likable 点赞对象，包含id和type属性
     * @param success_callback 执行成功的回调函数
     * @param error_callback 执行失败的回调函数
     */
    var like = function(likable, success_callback, error_callback)
    {
        $.ajax({
            type: 'POST',
            url: '{{ route("likes.storeOrDestroy") }}',
            dataType: 'json',
            data: {'likable_id': likable.id, 'likable_type': likable.type, '_token': '{{ csrf_token() }}'},
            success: success_callback ? success_callback : function(response_body) {
                if (response_body.message !== 'undefined') {
                    alert(response_body.message);
                }
            },
            error: error_callback ? error_callback : function(xhr) {
                if (xhr.status === 401) {
                    window.location.href = '{{ route("login") }}';
                }
            }
        });
    }
</script>