<script>
    $(function() {

        /*给帖子点赞*/
        $('#like-post-btn').click(function() {
            likable = {'id': $(this).attr('likable-id'), 'type': $(this).attr('likable-type')};

            like(likable, function(response_body) {
                if (response_body.success) {
                    $('#like-count').text(response_body.data.count);
                } else {
                    alert(response_body.message);
                }
            });
        });

    })
</script>