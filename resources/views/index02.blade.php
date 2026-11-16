<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tickets | Asistencia Técnica - Gobierno Regional Apurímac</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ url('Images/Gore/PNG - GOREAPU  (Vertical).png') }}">
    {{-- <link href="{{ url('portal/assets/img/Gore/logoFile.png') }}" rel="icon"> --}}

    <script src="{{ url('assets/js/vendor/jquery/jquery.min.js') }}"></script>


    <!-- Vendor CSS Files -->
    <link href="{{ url('portal/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ url('portal/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
    <link href="{{ url('portal/assets/vendor/aos/aos.css') }}" rel="stylesheet">
    <link href="{{ url('portal/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
    <link href="{{ url('portal/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">

    <link href="{{ url('portal/dataTables/datatables.min.css') }}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ url('portal/assets/css/main.css') }}" rel="stylesheet">

    <!-- Incluir Select2 CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Incluir jQuery y Select2 JS -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> --}}

    <!-- sweetalert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <!-- Styles -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}


    <!-- Tailwind CSS desde CDN (si no tienes Vite configurado) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Driverr js -->
    <script src="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.js.iife.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/driver.js@latest/dist/driver.css" />

    <style>
        .dni-input {
            padding-right: 2.5rem;
            position: relative;
        }

        .input-group-text {
            position: absolute;
            right: 0;
            top: 0;
            height: 100%;
            width: 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: white;
            border-left: 0;
        }

        .input-group .form-control {
            /* border-right: 0; */
        }

        .input-group .input-group-text i {
            color: #bdbaba;
        }
    </style>

</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center fixed-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">

            <a href="{{ url('/') }}" class="logo d-flex align-items-center me-auto">
                <img src="{{ url('portal/assets/img/Gore/PNG - GOREAPU  (Horizontal).png') }}" alt="">
                {{-- <h1 class="sitename">QuickStart</h1> --}}
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#inicio" class="active">Inicio</a></li>
                    <li><a href="#incidencias">Incidencia</a></li>
                    <li><a href="#seguimiento">Seguimiento</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>

            <a class="btn-getstarted" href="{{ route('login') }}">Acceder</a>

        </div>
    </header>

    <main class="main">

        <!-- Hero Section -->
        <section id="inicio" class="hero section">
            <div class="hero-bg">
                <img src="{{ url('portal/assets/img/hero-bg-light.webp') }}" alt="">
            </div>
            <div class="container text-center">
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <h1 data-aos="fade-up">Bienvenidos a <span>Asistencia Técnica</span></h1>
                    <p data-aos="fade-up" data-aos-delay="100">Soluciones rápidas y efectivas para sus requerimientos
                        técnicos en el GORE Apurímac<br></p>
                    <div class="d-flex" data-aos="fade-up" data-aos-delay="200">
                        <a href="#incidencias" class="btn-get-started">Reportar Incidencia</a>
                        <a href="../Manuales/Manual del Personal.pdf" target="_blank"
                            class="glightbox btn-watch-video d-flex align-items-center">
                            <i class="bi bi-file-earmark-text"></i><span>Ver Manual</span>
                        </a>
                        {{-- <a href="https://www.youtube.com/watch?v=t7bQwwqW-Hc&list=RDt7bQwwqW-Hc&start_radio=1"
                            class="glightbox btn-watch-video d-flex align-items-center"><i
                                class="bi bi-play-circle"></i><span>Ver Tutorial</span></a> --}}
                    </div>
                    <img src="{{ url('portal/assets/img/hero-services-img.webp') }}" class="img-fluid hero-img"
                        alt="" data-aos="zoom-out" data-aos-delay="300">
                </div>
            </div>

        </section><!-- /Hero Section -->

        <section id="featured-services" class="featured-services section light-background">
            <div class="container">
                <div class="row gy-4">

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="300">
                        <div class="service-item d-flex">
                            <a href="#inicio">
                                <div class="icon flex-shrink-0"><i class="bi bi-headset"></i></div>
                            </a>
                            <div>
                                <h4 class="title"><a href="#inicio" class="stretched-link">Soporte Técnico
                                        Especializado</a></h4>
                                <p class="description">Soluciones rápidas y efectivas a sus problemas tecnológicos,
                                    desde fallos de software hasta consultas sobre equipos, asegurando un soporte
                                    completo para los sistemas administrativos en uso.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="100">
                        <div class="service-item d-flex">
                            <a href="#incidencias">
                                <div class="icon flex-shrink-0"><i class="bi bi-pencil-square"></i></div>
                            </a>
                            <div>
                                <h4 class="title"><a href="#incidencias" class="stretched-link">Registro de
                                        Incidencias</a></h4>
                                <p class="description">Facilite el registro de incidencias técnicas de manera rápida y
                                    sencilla a través de nuestro sistema centralizado, cubriendo problemas en los
                                    sistemas administrativos utilizados en el GORE Apurímac, como SIGA y SIAF.</p>
                            </div>
                        </div>
                    </div>

                    <div class="col-xl-4 col-lg-6" data-aos="fade-up" data-aos-delay="400">
                        <div class="service-item d-flex">
                            <a href="#seguimiento">
                                <div class="icon flex-shrink-0"><i class="bi bi-eye-fill"></i></div>
                            </a>

                            <div>
                                <h4 class="title"><a href="#seguimiento" class="stretched-link">Seguimiento de
                                        Incidencias</a></h4>
                                <p class="description">Monitorea fácilmente el progreso de tus tickets y mantente
                                    informado en cada etapa
                                    del proceso de atención.</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="incidencias" class="contact section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Registrar Incidencias</h2>
                <p>Registre sus incidencias de manera fácil y rápida a través de nuestro sistema, asegurando que cada
                    problema sea atendido por nuestro equipo de soporte técnico para una solución efectiva.</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade-up" data-aos-delay="100">


                <div class="row gy-4 mt-1">

                    <div class="col-lg-6">
                        <form id="guardarTicket" class="php-form" style="border-radius: 15px"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row gy-4">

                                <!-- DNI input -->
                                <div class="col-md-6">
                                    <div class="input-group">
                                        <input type="text" id="dni" name="dni"
                                            class="form-control dni-input" placeholder="DNI">
                                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                                    </div>
                                    <input type="hidden" id="id_OfiPer" name="id_OfiPer" class="form-control"
                                        readonly>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="nombre" name="nombre" class="form-control"
                                        placeholder="Nombre" style="background-color: #ebeff3;" readonly>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="apellidoPaterno" name="apellidoPaterno"
                                        class="form-control" placeholder="Apellido Paterno"
                                        style="background-color: #ebeff3;" readonly>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="apellidoMaterno" name="apellidoMaterno"
                                        class="form-control" placeholder="Apellido Materno"
                                        style="background-color: #ebeff3;" readonly>
                                </div>

                                <div class="col-md-6">
                                    <input type="text" id="nombre_oficina" name="nombre_oficina"
                                        class="form-control" placeholder="Oficina Asignada"
                                        style="background-color: #ebeff3;" readonly>
                                    {{-- <input type="hidden" id="id_oficina" name="id_oficina" class="form-control" readonly> --}}
                                </div>

                                <!-- Select con buscador -->
                                {{-- <div class="col-md-6">
                                    <select id="select_oficina" class="form-control" name="id_oficina">
                                        <option value="" disabled selected>Seleccionar Oficina</option>
                                        <!-- Las opciones serán llenadas dinámicamente -->
                                    </select>
                                </div> --}}

                                <div class="col-md-6">
                                    <select id="select_incidencia" class="form-control" name="id_soporte">
                                        <option value="" disabled selected>Seleccionar Incidencia</option>
                                        <!-- Las opciones serán llenadas dinámicamente -->
                                    </select>
                                </div>

                                <!-- Descripción -->
                                <div class="col-md-12">
                                    <textarea class="form-control" id="descripcion" name="descripcion" rows="4" placeholder="Descripción"></textarea>
                                </div>

                                <!-- Archivo o img -->
                                <div class="col-md-12" id="fileContainer" style="display:none;">
                                    <div class="input-group">
                                        <input type="file" class="form-control" id="archivo" name="archivo">
                                        <span class="input-group-text">
                                            <i class="fas fa-paperclip"></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="col-md-12 text-center">
                                    <button type="submit">Registrar Incidencia</button>
                                </div>

                            </div>
                        </form>
                    </div>

                    <div class="col-lg-6 d-flex align-items-center" data-aos="fade-up" data-aos-delay="300">
                        <div class="tab-content" data-aos="fade-up" data-aos-delay="200">

                            <div class="tab-pane fade active show" id="features-tab-1">
                                <img src="{{ url('portal/assets/img/Soporte-Tecnico.jpg') }}" alt=""
                                    class="img-fluid" style="border-radius: 15px;">
                            </div>

                        </div>
                    </div>

                </div>

            </div>

        </section><!-- /Contact Section -->

        <!-- Pricing Section -->
        <section id="seguimiento" class="pricing section">

            <!-- Section Title -->
            <div class="container section-title" data-aos="fade-up">
                <h2>Seguimiento de Tickets</h2>
                <p>Ingresa tu DNI para consultar el estado de tus tickets generados.</p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-12">
                    <div class="col-lg-12" data-aos="zoom-in" data-aos-delay="200">
                        <div class="pricing-item featured">
                            <div class="tracking-item featured">
                                <h3>Consultar estado de ticket</h3>
                                {{-- <p class="description">Ingresa tu número de DNI para consultar el estado de tus tickets.</p> --}}

                                <!-- Formulario para seguimiento de tickets -->
                                <form id="ConsultarTicket">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-9">
                                            <input type="text" name="buscar_cons" id="buscar_cons"
                                                class="form-control" placeholder="Ingrese DNI o Código de Ticket">
                                        </div>
                                        <div class="col-md-3">
                                            <button type="submit" class="cta-btn w-100"
                                                style="padding: 5px 35px; margin-top: 0px;">Consultar</button>
                                            {{-- <button type="submit" class="cta-btn">Consultar</button> --}}
                                        </div>
                                    </div>
                                </form>

                                <!-- Tabla para mostrar los tickets -->
                                <div class="table-responsive mt-4" id="contenedorRegistros">
                                    <table class="table table-striped" id="tablaIndex">
                                        <thead>
                                            <tr>
                                                <th>Cod.</th>
                                                <th>Personal</th>
                                                <th>Oficina</th>
                                                <th>Incidencia</th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th>Fecha Envío</th>
                                                <th>Asignaciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Aquí se inyectarán los datos de los tickets -->
                                        </tbody>
                                    </table>
                                </div>
                                <!-- Fin de la tabla -->

                            </div>
                        </div>
                    </div><!-- End Pricing Item -->
                </div>
            </div>

        </section><!-- /Pricing Section -->

    </main>

    <footer id="footer" class="footer position-relative light-background">

        <div class="container footer-top">
            <div class="row gy-4">
                <div class="col-lg-4 col-md-6 footer-about">
                    <a href="{{ url('/') }}" class="logo d-flex align-items-center">
                        <img src="{{ url('portal/assets/img/Gore/PNG - GOREAPU  (Horizontal).png') }}"
                            alt="">
                    </a>
                    <div class="footer-contact pt-3">
                        <p>Jr. Puno N° 107</p>
                        <p>Abancay - Apurímac - Perú - 03001</p>
                        <p class="mt-3"><strong>Central Telefónica:</strong> <span>083-322170</span></p>
                        <p><strong>Horario de Atención:</strong> <span>Lunes a Viernes 08:45am a 4:45pm</span></p>
                    </div>
                    <div class="social-links d-flex mt-4">
                        <a href="https://www.facebook.com/regionapurimac.oficial/" target="_blank"
                            rel="noopener noreferrer"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/gobiernoapurimac/" target="_blank"
                            rel="noopener noreferrer"><i class="bi bi-instagram"></i></a>
                        <a href="https://www.tiktok.com/@gore.apurimac" target="_blank" rel="noopener noreferrer"><i
                                class="bi bi-tiktok"></i></a>
                        <a href="https://www.youtube.com/GobiernoRegionaldeApurimac" target="_blank"
                            rel="noopener noreferrer"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>

                <div class="col-lg-2 col-md-3 footer-links">

                </div>

                <div class="col-lg-2 col-md-3 footer-newsletter">

                </div>

                <div class="col-lg-4 col-md-12 footer-links">
                    <h4>Enlaces de interés</h4>
                    <ul>
                        <li><a href="#inicio">inicio</a></li>
                        <li><a href="#incidencias">incidencias</a></li>
                        <li><a href="#seguimiento">Seguimiento</a></li>
                    </ul>
                </div>

            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>
                <script>
                    document.write(new Date().getFullYear())
                </script> © <span>Derechos de autor.</span> <strong class="px-1 sitename">Gobierno
                    Regional de Apurímac.</strong><span>Todos los derechos reservados</span>
            </p>
            {{-- <div class="credits">
                Diseñado por <a href="#">Albert</a>
            </div> --}}
        </div>

    </footer>

    <!-- Scripts -->


    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i
            class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ url('portal/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ url('portal/assets/vendor/php-email-form/validate.js') }}"></script>
    <script src="{{ url('portal/assets/vendor/aos/aos.js') }}"></script>
    <script src="{{ url('portal/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
    <script src="{{ url('portal/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
    <script src="{{ url('portal/dataTables/datatables.min.js') }}"></script>

    <!-- Main JS File -->
    <script src="{{ url('portal/assets/js/main.js') }}"></script>

    <script src="{{ url('assets/js/vendor/jquery-validation/jquery.validate.min.js') }}"></script>


    <script>
        document.getElementById('dni').addEventListener('keypress', function(e) {
            // Solo permitir números (0-9)
            if (e.charCode < 48 || e.charCode > 57) {
                e.preventDefault(); // Evitar que se escriba el carácter no permitido
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#select_oficina').select2({
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                },
                placeholder: 'Seleccionar Oficina',
                //allowClear: true 
            });

            $(window).resize(function() {
                $('#select_oficina').select2('close').select2();
            });

            $('#select_incidencia').select2({
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                },
                //placeholder: 'Seleccionar Incidencia', 
                //allowClear: true 
            });

            $(window).resize(function() {
                $('#select_incidencia').select2('close').select2();
            });

            // Búsqueda al presionar Enter
            $('#dni').on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault(); // Evitar que se envíe el formulario
                    buscarPorDni(); // Llamar a la función de búsqueda
                }
            });

            // Búsqueda al hacer clic fuera del campo (evento blur)
            $('#dni').on('blur', function() {
                buscarPorDni(); // Llamar a la función de búsqueda
            });

            $('#select_incidencia').on('change', function() {
                var selected = $(this).val();

                if (selected === 'spt0001' || selected === 'spt0004' || selected === 'spt0007') {
                    $('#fileContainer').slideDown();
                } else {
                    $('#fileContainer').slideUp();
                    $('#archivo').val('');
                }
            });

            $('#select_incidencia').on('change', function() {
                var selectedValue = $(this).val();
                if (['spt0001', 'spt0004', 'spt0007'].includes(selectedValue)) {
                    Swal.fire({
                        icon: 'info',
                        title: 'Información Importante',
                        html: `
                            <p style="font-size:16px; line-height:1.5;">
                                Para la <b>creación de usuarios</b>, el trámite debe realizarse mediante <b>documento</b>, 
                                siguiendo el <b>conducto regular</b> establecido.
                            </p>
                        `,
                        confirmButtonText: 'Entendido',
                        confirmButtonColor: '#3085d6',
                        showClass: {
                            popup: 'animate__animated animate__fadeInDown'
                        },
                        hideClass: {
                            popup: 'animate__animated animate__fadeOutUp'
                        }
                    });
                }
            });

            $('#guardarTicket').validate({
                ignore: ":hidden:not(#archivo)",
                rules: {
                    dni: {
                        required: true,
                        minlength: 8,
                        maxlength: 8,
                        digits: true
                    },
                    /*nombre: {
                        required: true,
                        minlength: 3
                    },
                    apellidoPaterno: {
                        required: true,
                        minlength: 3
                    },
                    apellidoMaterno: {
                        required: true,
                        minlength: 3
                    },
                    id_oficina: {
                        required: true,
                    },*/
                    id_soporte: {
                        required: true,
                    },
                    descripcion: {
                        required: true,
                    }
                },
                messages: {
                    dni: {
                        required: "El DNI es obligatorio.",
                        minlength: "El DNI debe tener 8 caracteres.",
                        maxlength: "El DNI debe tener 8 caracteres.",
                        digits: "El DNI solo debe contener números."
                    },
                    /*nombre: {
                        required: "El nombre es obligatorio.",
                        minlength: "El nombre debe tener al menos 3 caracteres."
                    },
                    apellidoPaterno: {
                        required: "El apellido paterno es obligatorio.",
                        minlength: "El apellido paterno debe tener al menos 3 caracteres."
                    },
                    apellidoMaterno: {
                        required: "El apellido materno es obligatorio.",
                        minlength: "El apellido materno debe tener al menos 3 caracteres."
                    },
                    id_oficina: {
                        required: "La oficina es obligatorio.",
                    },*/
                    id_soporte: {
                        required: "La incidencia es obligatorio.",
                    },
                    descripcion: {
                        required: "La descripción de la incidencia es obligatorio, para un mayor entendimiento",
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.closest('.input-group').length) {
                        element.closest('.input-group').append(error);
                    } else {
                        element.after(error);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    var archivo = $('#archivo')[0].files[0];
                    var selectedValue = $('#select_incidencia').val();

                    if ((selectedValue === 'spt0001' || selectedValue === 'spt0004' || selectedValue ===
                            'spt0007') && archivo) {
                        var validExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                        var fileExtension = archivo.name.split('.').pop().toLowerCase();

                        if ($.inArray(fileExtension, validExtensions) === -1) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Archivo inválido',
                                text: 'El archivo debe ser JPG, PNG o PDF.',
                                timer: 3000,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            return false;
                        }

                        var maxSize = 3 * 1024 * 1024;
                        if (archivo.size > maxSize) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Archivo demasiado grande',
                                text: 'El archivo no puede superar los 3 MB.',
                                timer: 3000,
                                showConfirmButton: false,
                                timerProgressBar: true
                            });
                            return false;
                        }
                    }

                    registrar_tickets();
                }
            });


            listar_oficina();
            listar_incidencia();

            InicializacionTabla();

            $('#ConsultarTicket').validate({
                rules: {
                    buscar_cons: {
                        required: true,
                        minlength: 7,
                        maxlength: 8,
                        //digits: true
                    },
                },
                messages: {
                    buscar_cons: {
                        required: "El DNI es obligatorio.",
                        minlength: "El DNI debe tener 7 caracteres.",
                        maxlength: "El DNI debe tener 8 caracteres.",
                        //digits: "El DNI solo debe contener números."
                    },
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    if (element.closest('.input-group').length) {
                        element.closest('.input-group').append(error);
                    } else {
                        element.after(error);
                    }
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid').removeClass('is-valid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid').addClass('is-valid');
                },
                submitHandler: function(form) {
                    Consulta_Tickets();
                }
            });

        });

        function buscarPorDni() {
            var dni = $('#dni').val();
            if (dni) {
                $.ajax({
                    url: '{{ route('buscar.personal') }}',
                    method: 'GET',
                    data: {
                        dni: dni
                    },
                    success: function(response) {
                        $('#id_OfiPer').val(response.id_OfiPer);
                        $('#nombre').val(response.nombre);
                        $('#apellidoPaterno').val(response.apellidoPaterno);
                        $('#apellidoMaterno').val(response.apellidoMaterno);
                        $('#nombre_oficina').val(response.nombre_oficina);
                        // $('#id_oficina').val(response.id_oficina);
                    },
                    error: function(xhr) {

                        let errorJson = JSON.parse(xhr.responseText);

                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: errorJson.message,
                            timer: 3000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });

                        // Colorear el campo de DNI en rojo
                        $('#dni').addClass('is-invalid').removeClass('is-valid');

                    }
                });
            }
        }

        function listar_oficina() {
            $.ajax({
                type: 'POST',
                url: '{{ route('HomeSelect.listaOficinas') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    //console.log('Oficinas:', data);
                    if (data.code === 200) {
                        let oficinas = data.oficinas;
                        let select = $('#select_oficina'); // Seleccionar el <select>
                        select.empty(); // Limpiar opciones anteriores

                        // Agregar nuevamente la opción predeterminada
                        select.append(
                            '<option value="" disabled selected>Seleccionar Oficina</option>');

                        // Iterar sobre las categorías jerárquicas para agregarlas al select
                        oficinas.forEach(function(oficina) {
                            // Añadir opción al select con un formato visual basado en el nivel
                            let optionText = oficina.nombre;
                            select.append(
                                $('<option></option>')
                                .val(oficina.id_oficina)
                                .text(optionText)
                            );
                        });

                    }
                },
                error: function(data) {
                    console.error('Error en listar Personal:', data);
                }
            });
        }

        function listar_incidencia() {
            $.ajax({
                type: 'POST',
                url: '{{ route('incSelect.listarIncidencia') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    //console.log('Oficinas:', data);
                    if (data.code === 200) {
                        let incidencias = data.incidencias;
                        let select = $('#select_incidencia'); // Seleccionar el <select>
                        select.empty(); // Limpiar opciones anteriores

                        // Agregar nuevamente la opción predeterminada
                        select.append('<option value="" disabled selected>Seleccionar Incidencia</option>');

                        // Iterar sobre las categorías jerárquicas para agregarlas al select
                        incidencias.forEach(function(incidencia) {
                            // Añadir opción al select con un formato visual basado en el nivel
                            let optionText = incidencia.nombre;
                            select.append(
                                $('<option></option>')
                                .val(incidencia.id_soporte)
                                .text(optionText)
                            );
                        });
                    }
                },
                error: function(data) {
                    console.error('Error en listar Incidencia:', data);
                }
            });
        }

        async function registrar_tickets() {
            const formElement = document.getElementById("guardarTicket");

            if (!formElement) {
                console.error('No se encontró el formulario con ID "guardarTicket".');

                Swal.fire({
                    icon: "error",
                    title: "Error",
                    text: "No se encontró el formulario de registro."
                });

                return;
            }

            /*
            |--------------------------------------------------------------------------
            | 1. Confirmar y registrar el ticket
            |--------------------------------------------------------------------------
            */
            const resultadoRegistro = await Swal.fire({
                title: "¿Está seguro?",
                icon: "warning",
                text: "Verifique los datos antes de enviar.",
                showCancelButton: true,
                confirmButtonText: "Sí, estoy seguro",
                cancelButtonText: "Cancelar",
                showLoaderOnConfirm: true,
                allowOutsideClick: () => !Swal.isLoading(),

                preConfirm: async () => {
                    try {
                        const formData = new FormData(formElement);

                        const response = await fetch(
                            "{{ route('registrar.tickets') }}", {
                                method: "POST",
                                body: formData,
                                headers: {
                                    "X-Requested-With": "XMLHttpRequest",
                                    "Accept": "application/json"
                                }
                            }
                        );

                        const contentType =
                            response.headers.get("content-type") || "";

                        let data;

                        if (contentType.includes("application/json")) {
                            data = await response.json();
                        } else {
                            data = {
                                message: await response.text()
                            };
                        }

                        if (!response.ok) {
                            throw new Error(
                                data.message ||
                                `Error HTTP ${response.status}`
                            );
                        }

                        if (!data.id_ticket) {
                            throw new Error(
                                "El servidor registró la solicitud, pero no devolvió el ID del ticket."
                            );
                        }

                        return data;

                    } catch (error) {
                        console.error("Error al registrar el ticket:", error);

                        Swal.showValidationMessage(
                            error.message ||
                            "No se pudo registrar el ticket."
                        );

                        return false;
                    }
                }
            });

            /*
            |--------------------------------------------------------------------------
            | 2. Verificar que el ticket haya sido registrado
            |--------------------------------------------------------------------------
            */
            if (
                !resultadoRegistro.isConfirmed ||
                !resultadoRegistro.value
            ) {
                return;
            }

            const respuesta = resultadoRegistro.value;
            const idTicket = String(respuesta.id_ticket);

            /*
            |--------------------------------------------------------------------------
            | 3. Mostrar el ID y copiarlo antes de cerrar
            |--------------------------------------------------------------------------
            */
            const resultadoCopia = await Swal.fire({
                title: "Ticket registrado",
                icon: "success",

                html: `
            <p style="margin-bottom: 12px;">
                ${respuesta.message || "Ticket registrado exitosamente."}
            </p>

            <p style="margin-bottom: 8px;">
                Su código de seguimiento es:
            </p>

            <input
                type="text"
                id="ticket-id-registrado"
                value="${idTicket}"
                readonly
                aria-label="ID del ticket registrado"
                style="
                    width: 100%;
                    box-sizing: border-box;
                    padding: 12px;
                    font-size: 28px;
                    font-weight: bold;
                    text-align: center;
                    border: 1px solid #d9d9d9;
                    border-radius: 8px;
                    background-color: #f5f5f5;
                    cursor: text;
                "
            >

            <small
                id="mensaje-copia-ticket"
                style="
                    display: block;
                    margin-top: 12px;
                "
            >
                Presione “Copiar y cerrar” para guardar el código.
            </small>
        `,

                confirmButtonText: "Copiar y cerrar",
                showCancelButton: false,
                showCloseButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                returnFocus: false,

                didOpen: () => {
                    const campoTicket =
                        document.getElementById("ticket-id-registrado");

                    if (campoTicket) {
                        campoTicket.addEventListener("click", () => {
                            campoTicket.select();
                        });
                    }
                },

                preConfirm: async () => {
                    const campoTicket =
                        document.getElementById("ticket-id-registrado");

                    if (!campoTicket) {
                        Swal.showValidationMessage(
                            "No se encontró el código del ticket."
                        );

                        return false;
                    }

                    const textoACopiar = campoTicket.value;

                    /*
                    |--------------------------------------------------------------------------
                    | Método principal: Clipboard API
                    |--------------------------------------------------------------------------
                    */
                    if (
                        window.isSecureContext &&
                        navigator.clipboard &&
                        typeof navigator.clipboard.writeText === "function"
                    ) {
                        try {
                            await navigator.clipboard.writeText(textoACopiar);

                            return {
                                copiado: true,
                                metodo: "clipboard"
                            };

                        } catch (errorClipboard) {
                            console.warn(
                                "Falló navigator.clipboard.writeText:",
                                errorClipboard
                            );
                        }
                    }

                    /*
                    |--------------------------------------------------------------------------
                    | Método alternativo: document.execCommand
                    |--------------------------------------------------------------------------
                    */
                    try {
                        campoTicket.focus();
                        campoTicket.select();

                        campoTicket.setSelectionRange(
                            0,
                            campoTicket.value.length
                        );

                        const copiado =
                            document.execCommand("copy");

                        if (copiado) {
                            return {
                                copiado: true,
                                metodo: "execCommand"
                            };
                        }

                        throw new Error(
                            "document.execCommand devolvió false."
                        );

                    } catch (errorAlternativo) {
                        console.error(
                            "No se pudo copiar el ID del ticket:",
                            errorAlternativo
                        );

                        /*
                         * Se vuelve a seleccionar para permitir Ctrl + C.
                         */
                        campoTicket.focus();
                        campoTicket.select();

                        campoTicket.setSelectionRange(
                            0,
                            campoTicket.value.length
                        );

                        Swal.showValidationMessage(
                            "El navegador bloqueó la copia automática. " +
                            "El código quedó seleccionado. Presione Ctrl + C " +
                            "y luego vuelva a pulsar “Copiar y cerrar”."
                        );

                        return false;
                    }
                }
            });

            /*
            |--------------------------------------------------------------------------
            | 4. Limpiar el formulario después de copiar y cerrar
            |--------------------------------------------------------------------------
            */
            if (
                resultadoCopia.isConfirmed &&
                resultadoCopia.value?.copiado
            ) {
                formElement.reset();

                if (typeof listar_incidencia === "function") {
                    listar_incidencia();
                }

                Swal.fire({
                    icon: "success",
                    title: "Código copiado",
                    text: `El ID del ticket ${idTicket} fue copiado al portapapeles.`,
                    timer: 1600,
                    timerProgressBar: true,
                    showConfirmButton: false
                });
            }
        }

        function InicializacionTabla() {

            $("#tablaIndex").DataTable({
                pagingType: "full_numbers",
                pageLength: 10,
                lengthMenu: [
                    [10, 25, 50, -1],
                    [5, 10, 15, "Todos"]
                ],
                language: {
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        previous: "<i class='fas fa-chevron-left'>",
                        next: "<i class='fas fa-chevron-right'>"
                    },
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    zeroRecords: "No se encontraron registros coincidentes",
                    loadingRecords: "Cargando...",
                    emptyTable: "No hay datos disponibles en la tabla",
                    processing: "Procesando...",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    infoEmpty: "Mostrando 0 a 0 de 0 registros",
                    infoFiltered: "(filtrado de _MAX_ registros en total)"
                },
                order: [
                    [6, 'desc']
                ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
                responsive: true,
                destroy: true, // Permite la reinicialización del DataTable
                scrollX: true
            });
        }

        /*function Consulta_Tickets() {
            var dni = $('input[name="dni_cons"]').val(); 

            $.ajax({
                type: 'POST',
                url: '{{ route('mostrarConsul.tabla') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    dni: dni 
                },
                beforeSend: function() {
                    var spinner = `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#tablaIndex tbody").html('<tr><td colspan="6">' + spinner + '</td></tr>'); // Mostrar spinner en la tabla
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorJson.message,
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                },
                success: function(data) {
                    if ($.fn.DataTable.isDataTable('#tablaIndex')) {
                        $('#tablaIndex').DataTable().destroy();
                    }

                    $("#tablaIndex tbody").html(data.html); // Inyectar nuevos datos

                    // Reinicializar la tabla después de actualizar los datos
                    InicializacionTabla();
                }
            });
        }*/

        function Consulta_Tickets() {

            var buscar = $('#buscar_cons').val();

            $.ajax({
                type: 'POST',
                url: '{{ route('mostrarConsul.tabla') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    buscar: buscar
                },
                beforeSend: function() {
                    var spinner =
                        `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#tablaIndex tbody").html('<tr><td colspan="8">' + spinner + '</td></tr>');
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorJson.message,
                        timer: 2000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                    $("#tablaIndex tbody").html('<tr><td colspan="8">' + errorJson.html + '</td></tr>');
                },
                success: function(data) {
                    if ($.fn.DataTable.isDataTable('#tablaIndex')) {
                        $('#tablaIndex').DataTable().destroy();
                    }

                    $("#tablaIndex tbody").html(data.html); // Inyectar nuevos datos

                    // Reinicializar la tabla después de actualizar los datos
                    //InicializacionTabla();
                    // Reinicializar DataTable solo si hay registros
                    if (data.html.includes("No se encontraron tickets registrados")) {
                        Swal.fire({
                            icon: "info",
                            title: "Información",
                            text: "No se encontraron tickets registrados",
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                    }
                    if ($("#tablaIndex tbody tr").length > 1 || !$("#tablaIndex tbody tr td").attr('colspan')) {
                        InicializacionTabla();
                    }

                    /*if ($("#tablaIndex tbody tr td[colspan]").length === 0) {
                        InicializacionTabla();
                    }*/
                }
            });
        }
    </script>

    <!-- ChatBot -->
    @include('chatbot')

    <script>
        // Verificar si el tour ya se mostró
        if (!localStorage.getItem('chatbot-tour-shown')) {
            const driver = window.driver.js.driver;
            const driverObj = driver();

            driverObj.highlight({
                element: "#chat-toggle",
                popover: {
                    title: "Nuevo chat de asistencia",
                    description: "Ya está disponible el chat virtual para resolver problemas técnicos. Haz clic en el botón flotante en la esquina inferior derecha.",
                    side: "top",
                    align: 'center'
                },
                onHighlightStarted: function() {
                    // Opcional: Log o acción al iniciar el tour
                    console.log('Tour iniciado');
                },
                onHighlighted: function() {
                    // Guardar que el tour se mostró (después de completarse)
                    localStorage.setItem('chatbot-tour-shown', 'true');
                    console.log('Tour completado, no se mostrará de nuevo');
                },
                onDestroyed: function() {
                    // Opcional: Limpieza si el usuario cierra el tour manualmente
                }
            }).drive(); // .drive() inicia el tour; usa .highlight() si solo quieres resaltar sin pasos
        }
    </script>

</body>

</html>
