<!-- Main Header -->
<header class="main-header">

    <!-- Logo -->
    <a href="{{ url('/home') }}" class="logo">
        <!-- mini logo for sidebar mini 50x50 pixels -->
        <span class="logo-mini"><b>G</b>C</span>
        <!-- logo for regular state and mobile devices -->
        <span class="logo-lg"><b>Gestión</b> Condominio </span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
            <span class="sr-only">{{ trans('adminlte_lang::message.togglenav') }}</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">

                <!-- Tasks Menu -->
                @if (Auth::guest())
                    <li><a href="{{ url('/register') }}">{{ trans('adminlte_lang::message.register') }}</a></li>
                    <li><a href="{{ url('/login') }}">{{ trans('adminlte_lang::message.login') }}</a></li>
                @else
                    <!-- Notifications Menu -->
                <li class="dropdown notifications-menu">
                    <!-- Menu toggle button -->
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="fa fa-bell-o"></i>
                        @if($count = Auth::user()->unreadNotifications->count())
                            <span class="label label-warning">{{ $count }}</span>
                        @endif
                    </a>
                    <ul class="dropdown-menu">
                            <!-- Inner Menu: contains the notifications -->
                            <ul class="list-group">
                                    @foreach(auth()->user()->unreadNotifications as $unreadNotification)
                                    <li class="list-group-item"><!-- start notification -->
                                        <a href="{{ $unreadNotification->data['link'] }}">
                                                {{ $unreadNotification->data['text'] }}
                                        </a>
                                        <form method="POST" action="{{ route('notifications.read', $unreadNotification->id) }}" class="pull-right">
                                            {{ method_field('PATCH') }}
                                            {{ csrf_field() }}
                                            <button class="btn btn-danger btn-xs">X</button>
                                        </form>
                                    </li><!-- end notification -->
                                    @endforeach
                            </ul>
                        </li>
                    </ul>
                </li>
                    <!-- User Account Menu -->
                    <li class="dropdown user user-menu">
                        <!-- Menu Toggle Button -->
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <!-- The user image in the navbar-->
                            <img src="{{ Gravatar::get($user->email) }}" class="user-image" alt="User Image"/>
                            <!-- hidden-xs hides the username on small devices so only the image appears. -->
                            <span class="hidden-xs">{{ Auth::user()->name }}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- The user image in the menu -->
                            <li class="user-header">
                                <img src="{{ Gravatar::get($user->email) }}" class="img-circle" alt="User Image" />
                                <p>
                                    {{ Auth::user()->name }}
                                    {{-- <small>{{ trans('adminlte_lang::message.login') }} Nov. 2012</small> --}}
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-left">
                                    {{-- <a href="{{ url('/settings') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a> --}}
                                </div>
                                <div class="pull-right">
                                    <a href="{{ url('/logout') }}" class="btn btn-default btn-flat"
                                       onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                        {{ trans('adminlte_lang::message.signout') }}
                                    </a>

                                    <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                        <input type="submit" value="logout" style="display: none;">
                                    </form>

                                </div>
                            </li>
                        </ul>
                    </li>
                @endif
            </ul>
        </div>
    </nav>
</header>
