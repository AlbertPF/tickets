<!DOCTYPE html>
<html lang="en">
    
<head>
        <meta charset="utf-8" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Tickets | Asistencia Técnica - Gobierno Regional Apurímac</title>

        <link rel="shortcut icon" href="{{ url('Images/Gore/logoFile.png') }}">

        <script src="{{url('assets/js/vendor/jquery/jquery.min.js')}}"></script>
        
        <!-- App css -->
        <link href="{{url('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <link href="{{url('assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style"/>

        <!-- sweetalert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <link href="{{ url('assets/css/style.css') }}"  rel="stylesheet">
         
        @yield('css-styles-home')

    </head>

    <body class="loading" data-layout-color="light" data-leftbar-theme="dark" data-layout-mode="fluid" data-rightbar-onstart="true">
        <!-- Begin page -->
        <div class="wrapper" id="content-area">

            <!-- ========== Left Sidebar Start ========== -->
            @include('layout.sections.sidebarLeft')
            <!-- Left Sidebar End -->

            <!-- ============================================================== -->
            <!-- Start Page Content here -->
            <!-- ============================================================== -->

            <div class="content-page">
                <div class="content">
                    <!-- Topbar Start -->
                    @include('layout.sections.navbar')
                    <!-- end Topbar -->

                    <!-- Start Content-->
                    <div class="container-fluid">

                        @yield('contenido')

                    </div> <!-- container -->

                </div> <!-- content -->

                <!-- Footer Start -->
               @include('layout.sections.footer')
                <!-- end Footer -->

            </div>

            <!-- ============================================================== -->
            <!-- End Page content -->
            <!-- ============================================================== -->


        </div>
        <!-- END wrapper -->


        <!-- Right Sidebar -->
        @include('layout.sections.sidebarRight')
        <!-- /End-bar -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script>
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            });

            setInterval(function () {
                fetch("{{ url('/refresh-csrf') }}")
                    .then(response => {
                        if (!response.ok) throw new Error('Error al actualizar CSRF');
                        return response.json();
                    })
                    .then(data => {
                        document.querySelector('meta[name="csrf-token"]').setAttribute('content', data.token);
                    })
                    .catch(error => {
                        console.warn("⚠️ No se pudo refrescar el token CSRF (posible desconexión o sesión expirada):", error.message);
                    });
            }, 25 * 60 * 1000);

            let logoutTimer;
            function resetTimer() {
                clearTimeout(logoutTimer);
                logoutTimer = setTimeout(function () {
                    fetch("{{ route('logout') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute("content"),
                            "Content-Type": "application/json"
                        }
                    })
                    .then(response => {
                        if (!response.ok) throw new Error('Fallo al cerrar sesión');
                        window.location.replace("{{ route('login') }}");
                    })
                    .catch(error => {
                        console.warn("⚠️ Error al cerrar sesión automáticamente:", error.message);
                        window.location.reload();
                    });
                }, 30 * 60 * 1000); // 30 minutos
            }

            window.onload = resetTimer;
            document.onmousemove = resetTimer;
            document.onkeypress = resetTimer;
            document.onclick = resetTimer;
            document.onscroll = resetTimer;

        </script>

        <script src="{{url('assets/js/vendor.min.js')}}"></script>
        <script src="{{url('assets/js/app.min.js')}}"></script>

        <script src="{{url('assets/js/vendor/jquery-validation/jquery.validate.min.js')}}"></script>
        
        <script>
            document.addEventListener("DOMContentLoaded", function () {

                // 1. Restaurar configuración desde localStorage
                const savedSettings = JSON.parse(localStorage.getItem("userSettings")) || {};

                if (savedSettings.colorScheme) {
                    document.body.setAttribute("data-layout-color", savedSettings.colorScheme);
                    document.querySelector(`#${savedSettings.colorScheme}-mode-check`)?.setAttribute("checked", true);
                }

                if (savedSettings.sidebarTheme) {
                    document.body.setAttribute("data-leftbar-theme", savedSettings.sidebarTheme);
                    document.querySelector(`#${savedSettings.sidebarTheme}-check`)?.setAttribute("checked", true);
                }

                if (savedSettings.layoutWidth) {
                    document.body.setAttribute("data-layout-mode", savedSettings.layoutWidth);
                    document.querySelector(`#${savedSettings.layoutWidth}-check`)?.setAttribute("checked", true);
                }

                if (savedSettings.sidebarCompact) {
                    document.body.setAttribute("data-leftbar-compact-mode", savedSettings.sidebarCompact);
                    document.querySelector(`#${savedSettings.sidebarCompact}-check`)?.setAttribute("checked", true);
                }

                // 2. Guardar cambios cuando el usuario modifica una opción
                function saveSetting(key, value) {
                    savedSettings[key] = value;
                    localStorage.setItem("userSettings", JSON.stringify(savedSettings));
                }

                // 3. Detectar cambios y aplicar estilos en tiempo real
                // Esquema de color
                document.querySelectorAll('input[name="color-scheme-mode"]').forEach(input => {
                    input.addEventListener("change", function () {
                        document.body.setAttribute("data-layout-color", this.value);
                        saveSetting("colorScheme", this.value);
                    });
                });

                // Ancho
                document.querySelectorAll('input[name="width"]').forEach(input => {
                    input.addEventListener("change", function () {
                        document.body.setAttribute("data-layout-mode", this.value);
                        saveSetting("layoutWidth", this.value);
                    });
                });

                // Barra lateral izquierda (tema)
                document.querySelectorAll('input[name="theme"]').forEach(input => {
                    input.addEventListener("change", function () {
                        document.body.setAttribute("data-leftbar-theme", this.value);
                        saveSetting("sidebarTheme", this.value);
                    });
                });

                // Compactación de barra lateral
                document.querySelectorAll('input[name="compact"]').forEach(input => {
                    input.addEventListener("change", function () {
                        document.body.setAttribute("data-leftbar-compact-mode", this.value);
                        saveSetting("sidebarCompact", this.value);
                    });
                });

                // 4. Botón para restablecer
                document.getElementById("resetBtn").addEventListener("click", function () {
                    localStorage.removeItem("userSettings");
                    window.location.reload();
                });

            });
        </script>

        @yield('js-styles-home')
        
    </body>

</html>
