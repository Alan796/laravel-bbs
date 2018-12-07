<script>
    /**
     * 刷新导航栏头部消息下拉框页脚
     */
    var refresh_notification_menu = function()
    {
        notification_menu = $('#notification_menu');

        if (notification_menu.children().length === 0) {
            menu_foot = `<li id="notification_menu_foot"><a class="text-center" href="#">~没有新的通知~</a></li>`;
        } else {
            menu_foot = `<li id="notification_menu_foot" class="bg-success"><a class="text-center" href="{{ route('notifications.index') }}">查看更多</a></li>`;
        }

        notification_menu.find('#notification_menu_foot').remove();
        notification_menu.append(menu_foot);
    }
</script>