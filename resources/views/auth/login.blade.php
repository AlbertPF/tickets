<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Iniciar Sección | Tickets (Asistencia Técnica) - Gobierno Regional Apurímac</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ url('Images/Gore/logoFile.png') }}">

    <script src="{{ url('assets/js/vendor/jquery/jquery.min.js') }}"></script>


    <!-- third party css -->
    {{-- <link href="{{asset('assets/css/vendor/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" /> --}}
    <!-- third party css end -->

    <!-- App css -->
    <link href="{{ url('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.js"></script>
    <style>
        #spinner-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Fondo oscuro */
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }
    </style>
</head>

<body class="authentication-bg pb-0" data-layout-config='{"darkMode":false}'>

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="align-items-center d-flex h-100">
                <div class="card-body">

                    <!-- Logo -->
                    <div class="auth-brand text-center text-lg-start">
                        <a href="{{ url('/') }}" class="logo-dark">
                            <span><img src="{{ url('images/Gore/PNG - GOREAPU  (Horizontal).png') }}" alt=""height="60"></span>
                        </a>
                        <a href="{{ url('/') }}" class="logo-light">
                            <span><img src="{{ url('images/Gore/PNG - GOREAPU  (Horizontal B).png') }}" alt="" height="60"></span>
                        </a>
                    </div>

                    <!-- title-->
                    <h4 class="mt-0">Iniciar Sección</h4>
                    <p class="text-muted mb-4">Ingrese su usuario y contraseña para acceder al panel de administración.
                    </p>

                    <!-- form -->
                    <form class="needs-validation" method="POST" id="fvlogin" novalidate>
                        @csrf
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Usuario</label>
                            <input class="form-control" type="text" name="usuario" id="usuario" required="" placeholder="Introduce tu usuario">
                            <div class="valid-feedback">
                                Correcto!
                            </div>
                            <div class="invalid-feedback">
                                Introduce tu Usuario.
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña</label>
                            <div class="input-group input-group-merge">
                                <input type="password" name="password" id="password" class="form-control" placeholder="Introduce tu contraseña" required>
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                                <div class="valid-feedback">
                                    Correcto!
                                </div>
                                <div class="invalid-feedback">
                                    Introduce tu Contraseña.
                                </div>
                            </div>

                        </div>

                        <div id="spinner-container" style="display: none;">
                            <div class="spinner-border avatar-lg text-primary" role="status"></div>
                        </div>

                        <div class="d-grid mb-0 text-center">
                            <button class="btn btn-primary sig-in" type="submit"><i class="mdi mdi-login"></i> Iniciar</button>
                        </div>
                        <!-- social-->
                        <div class="text-center mt-4">
                            <p class="text-muted font-16">Visite a Nuestras Plataformas Sociales</p>
                            <ul class="social-list list-inline mt-3">
                                <li class="list-inline-item">
                                    <a href="https://www.facebook.com/regionapurimac.oficial/" target="_blank" class="social-list-item border-primary text-primary">
                                        <i class="mdi mdi-facebook"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.instagram.com/gobiernoapurimac/" target="_blank" class="social-list-item border-danger text-danger">
                                        <i class="mdi mdi-instagram"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.tiktok.com/@gore.apurimac" target="_blank" class="social-list-item border-secondary text-secondary">
                                        <i class="mdi mdi-music-note"></i>
                                    </a>
                                </li>
                                <li class="list-inline-item">
                                    <a href="https://www.youtube.com/GobiernoRegionaldeApurimac" target="_blank" class="social-list-item border-danger text-danger">
                                        <i class="mdi mdi-youtube"></i>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </form>
                    <!-- end form-->

                    <!-- Footer-->
                    <footer class="footer footer-alt">
                        2024 -
                        <script>
                            document.write(new Date().getFullYear())
                        </script> © Tickets (Asistencia Técnica) - Gobierno Regional Apurímac
                    </footer>

                </div> <!-- end .card-body -->
            </div> <!-- end .align-items-center.d-flex.h-100-->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <h2 class="mb-3">Tickets | Asistencia Técnica</h2>
                <p class="lead"><i class="mdi mdi-format-quote-open"></i>Gobierno
                    Regional Apurímac<i class="mdi mdi-format-quote-close"></i>
                </p>
                <p>
                    - Usuario Administrador
                </p>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->


    <!-- bundle -->
    <script src="{{ url('assets/js/vendor.min.js') }}"></script>
    <script src="{{ url('assets/js/app.min.js') }}"></script>

    {{-- <script src="{{ asset('assets/js/helper.js') }}"></script> --}}

    <script src="{{ url('assets/js/vendor/jquery-validation/jquery.validate.min.js') }}"></script>

    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $(document).ready( function () {
            initValidate();
        } );

        $('.sig-in').on('click', function(event) {
            if($('#fvlogin').valid()==false)
            {return;}
            event.preventDefault(); // Evitar el comportamiento predeterminado
            var formData = new FormData($("#fvlogin")[0]);
            var $button = $(this);
            var $spinnerContainer = $('#spinner-container');

            $button.prop('disabled', true);
            $spinnerContainer.show(); // Mostrar el spinner centrado

            $.ajax({
                type: 'POST',
                url: "{{ url('login/sigin') }}",
                data: formData,
                dataType: 'json',
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': "{{ csrf_token() }}"
                },
                success: function(data) {
                    $spinnerContainer.hide(); // Ocultar el spinner
                    if (data.code === 200) {
                        Swal.fire({
                            title: "Inicio de sesión exitoso!",
                            text: "Redirigiendo...",
                            icon: "success",
                            showConfirmButton: false,
                            timer: 1500 
                        })
                        
                        setTimeout(function() {
                            //window.location.href = "{{ url('homeAdmin') }}";
                            window.location.href = data.redirect;
                        }, 100);
                    } else {
                        $button.prop('disabled', false);
                        msjRee(data);
                    }
                },
                error: function(data) {
                    $spinnerContainer.hide(); // Ocultar el spinner
                    $button.prop('disabled', false);
                    let errorJson = JSON.parse(data.responseText);

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: errorJson.message,
                    });
                }
            });
        });

        function rules()
        {
            return {
                usuario: {required: true,},
                password: {required: true,},
            };
        }
        
        function initValidate() {
            $('#fvlogin').validate({
                rules: rules(),
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
            });
        }
        
    </script>

</body>

</html>
