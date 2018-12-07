<nav class="navbar navbar-default navbar-static-top">
    <div class="container">
        <div class="navbar-header">

            <!-- Collapsed Hamburger -->
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                <span class="sr-only">Toggle Navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <!-- Branding Image -->
            <a class="navbar-brand" href="{{ url('/') }}">
                laravel-bbs
            </a>
        </div>

        <div class="collapse navbar-collapse" id="app-navbar-collapse">
            <!-- Left Side Of Navbar -->
            <ul class="nav navbar-nav">
                <li class="{{ active_class(if_route('posts.index')) }}">
                    <a href="{{ route('posts.index') }}">所有帖子</a>
                </li>

                @foreach ($categories as $category)
                    <li class="{{ active_class(if_route('categories.show') && if_route_param('category', $category->id)) }}">
                        <a href="{{ route('categories.show', $category->id) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                @endforeach

            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="nav navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                    <li><a href="{{ route('login') }}">登录</a></li>
                    <li><a href="{{ route('register') }}">注册</a></li>
                @else
                    <li>
                        <a href="{{ route('posts.create') }}">
                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="glyphicon glyphicon-bell" aria-hidden="true">
                                <span class="badge badge-tip" id="notification_count">
                                    {{ Auth::user()->notification_count }}
                                </span>
                            </span>
                        </a>

                        <ul class="dropdown-menu" role="menu" id="notification_menu">

                            @foreach (Auth::user()->unreadNotifications()->limit(10)->get() as $notification)
                                @include('notifications.menu_items._'.snake_case(class_basename($notification->type)))
                            @endforeach

                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <span class="user-avatar pull-left" style="margin-right:8px; margin-top:-5px;">
                                <img src="{{ Auth::user()->avatar }}" class="img-responsive img-circle" width="30px" height="30px">
                            </span>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <ul class="dropdown-menu" role="menu">
                            <li>
                                <a href="{{ route('users.show', Auth::id()) }}">
                                    <span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                                    个人中心
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('users.edit', Auth::id()) }}">
                                    编辑资料
                                </a>
                            </li>

                            <li>
                                <a href="javascript:;" onclick="$('#logout-form').submit();">
                                    退出登录
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

@section('scripts')

    @include('scripts.functions._refresh_notification_menu')

    <script>
        $(function() {
            refresh_notification_menu();

            Echo.private('User.{{ Auth::id() }}').listen('DatabaseNotificationCreated', (e) => {
                var notification_count = e.notification_count;
                var text = e.data.text
                var html_string = `<li><div class="text-center center-block">${text}</div></li>`;
                $('#notification_menu').prepend(html_string);
                $('#notification_count').text(notification_count);

                refresh_notification_menu();
            });
        })
    </script>
@append