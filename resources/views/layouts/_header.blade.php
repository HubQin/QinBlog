<nav class="navbar navbar-expand-lg navbar-light bg-light navbar-static-top">
    <div class="container">
        <!-- Branding Image -->
        <a class="navbar-brand " href="{{ url('/') }}">
            {{ config('site.site_name') }}{{--<i class="text-secondary" style="font-size: 10px;">&nbsp;&nbsp;&nbsp;{{ config('site.slogan') }}</i>--}}
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
                @foreach($columns ?? '' as $column)
                    <li class="nav-item @if(request()->is($column->link. '*')) active @endif"><a class="nav-link" href="{{ url($column->link) }}">{{ $column->name }}</a></li>
                @endforeach
            </ul>

            <ul class="navbar-nav mr-5">
                <li>
                    <form action="{{ route('posts.search') }}" method="GET" class="navbar-search" id="post-search">
                        <input type="text" name="query" class="form-control small post-search-input" aria-label="Search" placeholder="搜索" value="{{ request()->get('query') }}">
                        <button class="btn post-search-btn" type="submit">
                            <i class="fas fa-search fa-sm"></i>
                        </button>
                    </form>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav navbar-right">
                <!-- Authentication Links -->
                @guest
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">登录</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">注册</a></li>
                <li class="nav-item"><a class="nav-link" title="Github登录" href="{{ route('socials.authorizations.store', ['social_type' => 'github']) }}"><i class="fa fa-github fa-lg" aria-hidden="true"></i></a></li>
                @else
                    @if(Auth::id() === 1)
                    <li class="nav-item">
                        <a class="nav-link mt-1 mr-3 font-weight-bold" href="{{ route('posts.create') }}">
                            <i class="fa fa-plus"></i>
                        </a>
                    </li>
                    @endif
                <li class="nav-item notification-badge">
                    <a class="nav-link mr-3 badge badge-pill badge-{{ Auth::user()->notification_count > 0 ? 'hint' : 'secondary' }} text-white" href="{{ route('notifications.index') }}">
                        {{ Auth::user()->notification_count }}
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="{{ Auth::user()->avatar ?? config('site.default_avatar') }}" class="img-responsive img-circle" width="30px" height="30px" />
                        {{ Auth::user()->name }}
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        @if(Auth::id() === 1)
                        <a class="dropdown-item" href="{{ url('/admin') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i>
                            管理后台
                        </a>
                        @endif
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('users.show', Auth::id()) }}">
                            <i class="far fa-user mr-2"></i>
                            个人中心
                        </a>
                        <a class="dropdown-item" id="logout" href="#"
                           onclick="event.preventDefault();document.getElementById('logout-form').submit();">退出登录</a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </div>
                </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
