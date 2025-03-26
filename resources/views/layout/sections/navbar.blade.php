<!-- Topbar Start -->
<div class="navbar-custom">
    <ul class="list-unstyled topbar-menu float-end mb-0">

        <li class="notification-list">
            <a class="nav-link end-bar-toggle" href="javascript: void(0);">
                <i class="dripicons-gear noti-icon"></i>
            </a>
        </li>

        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle nav-user arrow-none me-0" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false"
                aria-expanded="false">
                <span class="account-user-avatar"> 
                    {{-- <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-image" class="rounded-circle"> --}}
                    <div class="avatar-letter">
                        {{
                            Session::has('usuario') ?
                                strtoupper(substr(Session::get('usuario')->nombre, 0, 1)) :
                                '?'
                        }}
                    </div>
                </span>
                <span>
                    <span class="account-user-name">
                        {{
                            Session::has('usuario') ?
                                Session::get('usuario')->usuario :
                                'Usuario Desconocido'
                        }}
                    </span>
                    <span class="account-position">
                        {{-- {{
                            Session::has('usuario') ?
                                Session::get('usuario')->nombre . ' ' . Session::get('usuario')->apellidoPaterno . ' ' . Session::get('usuario')->apellidoMaterno :
                                'Usuario Desconocido'
                        }} --}}

                        {{
                            Session::has('usuario') ?
                                Session::get('usuario')->tipo :
                                'Usuario Desconocido'
                        }}
                    </span>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated topbar-dropdown-menu profile-dropdown">
                <!-- item-->
                <div class=" dropdown-header noti-title">
                    <h6 class="text-overflow m-0">Bienvenido !</h6>
                </div>

                <!-- item-->
                <a href="{{url('usuario/perfil')}}" class="dropdown-item notify-item">
                    <i class="mdi mdi-account-circle me-1"></i>
                    <span>Mi cuenta</span>
                </a>

                <!-- item-->
                <a href="{{ route('logout') }}" class="dropdown-item notify-item">
                    <i class="mdi mdi-logout me-1"></i>
                    <span>Cerrar sesión</span>
                </a>
            </div>
        </li>

    </ul>
    <button class="button-menu-mobile open-left">
        <i class="mdi mdi-menu"></i>
    </button>

    <ul class="list-unstyled topbar-menu float-left mb-0">
        <li class="dropdown notification-list">
            <a class="nav-link dropdown-toggle arrow-none" href="{{ route('index.tickets') }}" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-ticket-confirmation noti-icon"></i> 
                <samp>Tickets </samp>
            </a>
        </li>
        @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')
            <li class="dropdown notification-list">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('index.oficina') }}" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-office-building noti-icon"></i> 
                    <samp>Oficina </samp>
                </a>
            </li>
        @endif

        <li class="dropdown notification-list d-none d-sm-inline-block">
            <a class="nav-link dropdown-toggle arrow-none" href="{{ route('incidencia.index') }}" role="button" aria-haspopup="false" aria-expanded="false">
                <i class="mdi mdi-cpu-64-bit noti-icon"></i> 
                <span>Incidencia </span>
            </a>
        </li>

        @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')
            <li class="dropdown notification-list d-none d-sm-inline-block">
                <a class="nav-link dropdown-toggle arrow-none" href="{{ route('index.personal') }}" role="button" aria-haspopup="false" aria-expanded="false">
                    <i class="mdi mdi-account-group noti-icon"></i> 
                    <span>Personal  </span>
                </a>
            </li>
        @endif
    </ul>

</div>
<!-- end Topbar -->