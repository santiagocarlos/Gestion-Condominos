 <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="" class="navbar-brand"><b>Gestión</b> Condominios</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="{{ route('owners.owners.home') }}">Inicio</a></li>
            <li><a href="{{ route('owners.billboard.index') }}">Cartelera Digital <span class="sr-only">(current)</span></a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Recibos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('owners.billing-notices.list') }}">Ver Recibos</a></li>
              </ul>
            </li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Pagos <span class="caret"></span></a>
              <ul class="dropdown-menu" role="menu">
                <li><a href="{{ route('owners.payments.index') }}">Reportar Pago</a></li>
                <li><a href="{{ route('owners.payments.history') }}">Ver Historial de Pagos</a></li>
              </ul>
            </li>
          </ul>

        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        @if (Auth::guest())

        @else
        <div class="navbar-custom-menu">
          <ul class="nav navbar-nav">
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
                <li class="footer"><a href="#">Ver todo</a></li>
              </ul>
            </li>
            <!-- User Account Menu -->

            <li class="dropdown user user-menu">
              <!-- Menu Toggle Button -->
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <!-- The user image in the navbar-->
                {{-- <img src="" class="user-image" alt="User Image"> --}}
                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                <span class="hidden-xs">{{ Auth::user()->email }}</span>
              </a>
              <ul class="dropdown-menu">
                <!-- The user image in the menu -->
                <li class="user-header">
                  {{-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> --}}

                  <p>
                    {{ Auth::user()->email }}
                    {{-- <small>Miembro desde....</small> --}}
                  </p>
                </li>
                 <li class="user-footer">
                  {{-- <div class="pull-left">
                      <a href="{{ url('/settings') }}" class="btn btn-default btn-flat">{{ trans('adminlte_lang::message.profile') }}</a>
                  </div> --}}
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
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>