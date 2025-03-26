<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu">

    <!-- Obtener la URL de redirección según el tipo de usuario -->
    @php
    $redirectUrl = session('usuario') && session('usuario')->tipo === 'Personal' 
        ? route('index.actividades') 
        : url('homeAdmin');
    @endphp
    
    <!-- LOGO -->
    <a href="{{ $redirectUrl }}" class="logo text-center logo-light">
        <span class="logo-lg">
            <img src="{{ url('Images/Gore/PNG - GOREAPU  (Horizontal B).png') }}" alt="" height="50">
        </span>
        <span class="logo-sm">
            <img src="{{ url('Images/Gore/PNG - GOREAPU  (Vertical B).png') }}" alt="" height="50">
        </span>
    </a>

    <!-- LOGO -->
    <a href="{{ $redirectUrl }}" class="logo text-center logo-dark">
        <span class="logo-lg">
            <img src="{{ url('Images/Gore/PNG - GOREAPU  (Horizontal).png') }}" alt="" height="50">
        </span>
        <span class="logo-sm">
            <img src="{{ url('Images/Gore/PNG - GOREAPU  (Vertical).png') }}" alt="" height="50">
        </span>
    </a>

    <div class="h-100" id="leftside-menu-container" data-simplebar>

        <!--- Sidemenu -->
        <ul class="side-nav">

            @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador' || Session::get('usuario')->tipo === 'Agente Informático')
                <li class="side-nav-title side-nav-item">Navegación</li>

                <li class="side-nav-item">
                    <a href="{{ url('homeAdmin') }}" class="side-nav-link">
                        <i class="uil-home-alt"></i>
                        <span> Panel </span>
                    </a>
                </li>

                <li class="side-nav-title side-nav-item">Aplicaciones</li>

                <li class="side-nav-item">
                    <a href="{{ route('index.tickets') }}" class="side-nav-link">
                        <i class="mdi mdi-ticket-confirmation"></i>
                        <span> Tickets </span>
                    </a>
                </li>
            @endif

            @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')

                <li class="side-nav-item">
                    <a href="{{ route('index.ticketsAsig') }}" class="side-nav-link">
                        <i class="mdi mdi-sticker-text"></i>
                        <span> Asignaciones </span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('index.oficina') }}" class="side-nav-link">
                        <i class="mdi mdi-office-building"></i>
                        <span> Oficinas </span>
                    </a>
                </li>

                {{-- <li class="side-nav-item">
                    <a href="apps-chat.html" class="side-nav-link">
                        <i class="mdi mdi-account-group"></i>
                        <span> Personal </span>
                    </a>
                </li> --}}

                <li class="side-nav-item">
                    <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="false" aria-controls="sidebarIcons" class="side-nav-link">
                        <i class="mdi mdi-account-group"></i>
                        <span> Personal </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="sidebarIcons">
                        <ul class="side-nav-second-level">
                            <li>
                                <a href="{{ route('index.personal') }}">Lista de Personal</a>
                            </li>
                            <li>
                                <a href="{{ route('index.ofiPersonal') }}">Lista de Asignación</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('index.usuario') }}" class="side-nav-link">
                        <i class="mdi mdi-account-multiple"></i>
                        <span> Usuarios Informática </span>
                    </a>
                </li>

            
                <li class="side-nav-item">
                    <a href="{{ route('rlaboral.index') }}" class="side-nav-link">
                        <i class="mdi mdi-notebook"></i>
                        <span> Regimen Laboral </span>
                    </a>
                </li>
            @endif

            @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador' || Session::get('usuario')->tipo === 'Agente Informático')
                <li class="side-nav-item">
                    <a href="{{ route('incidencia.index') }}" class="side-nav-link">
                        <i class="mdi mdi-cpu-64-bit"></i>
                        <span> Incidencias </span>
                    </a>
                </li>
            @endif
            <li class="side-nav-title side-nav-item">Actividades</li>

            @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')
                <li class="side-nav-item">
                    <a href="{{ route('index.listActividades') }}" class="side-nav-link">
                        <i class="uil-box"></i>
                        <span> Panel Bitácora</span>
                    </a>
                </li>

                <li class="side-nav-item">
                    <a href="{{ route('actividad.index') }}" class="side-nav-link">
                        <i class="mdi mdi-book-open"></i>
                        <span> Actividad </span>
                    </a>
                </li>
            @endif

            <li class="side-nav-item">
                <a href="{{ route('index.actividades') }}" class="side-nav-link">
                    <i class="mdi mdi-clipboard-list"></i>
                    <span> Bitácora de Trabajo </span>
                </a>
            </li>

            @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')
                <li class="side-nav-item">
                    <a href="{{ route('resumen.index') }}" class="side-nav-link">
                        <i class="mdi mdi-archive-eye"></i>
                        <span> Resumen General </span>
                    </a>
                </li>
            @endif

        </ul>

        <!-- Help Box -->
        <div class="help-box text-white text-center">
            {{-- <a href="javascript: void(0);" class="float-end close-btn text-white">
                <i class="mdi mdi-close"></i>
            </a> --}}
            <img src="{{ url('Images/Gore/PNG - GOREAPU  (Vertical B).png') }}" height="90" alt="Helper Icon Image" />
            <h5 class="mt-3">Sistema de Tickets</h5>
            <p class="mb-3">Soporte Técnico - Gobierno Regional Apurímac</p>
            <a href="{{ url('/')}}" class="btn btn-secondary btn-sm">Inicio</a>
        </div>
        <!-- end Help Box -->
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>
<!-- Left Sidebar End -->