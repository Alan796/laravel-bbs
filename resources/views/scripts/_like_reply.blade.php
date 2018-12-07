<script>
    $(function() {

        /*给评论点赞*/
        $('.like-reply-btn').click(function() {
            likable = {'id': $(this).attr('likable-id'), 'type': $(this).attr('likable-type')};

            like(likable, function(response_body) {
                if (response_body.success) {
                    $('.reply-like-count[reply-id="' + likable.id + '"]').text(response_body.data.count);
                } else {
                    alert(response_body.message);
                }
            });
        });

    })
</script>