@extends('layout.app')

@section('css-styles-home')
    <link href="{{ url('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedHeader.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedColumns.bootstrap5.css') }}" rel="stylesheet" type="text/css" />

    <link href="{{ url('assets/css/style.css') }}"  rel="stylesheet">
@endsection

@section('contenido')
     <!-- título de la página de inicio -->
     <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">GORE</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('homeAdmin') }}">Panel Administativo</a></li>
                        <li class="breadcrumb-item active">Bitácora de Trabajo</li>
                    </ol>
                </div>
                <h4 class="page-title">Bitácora de Trabajo</h4>
            </div>
        </div>
    </div>
    <!-- título de la página final -->

    <div class="row">

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Cantidad de Tickets registrados por día.</h4> --}}
                    <div dir="ltr">
                        <div id="actividadUsuario" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

    </div>
    <!-- end row-->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-12 col-lg-10">
                            <h4 class="header-title">Lista de actividades</h4>
                            <p class="text-muted font-14">
                                Esta es la lista de actividades registradas en la bitácora de trabajo de todo el personal de la 
                                Subgerencia de Desarrollo Institucional, Estadística e Informática. Aquí se documentan las tareas realizadas 
                                en diversas áreas, garantizando un seguimiento detallado de sus funciones y contribuciones al desarrollo institucional.
                            </p>
                        </div>
                    </div>
                    <div class="row">
                        <label class="form-label">Aplicar Filtros :</label>
                        <div class="col-xl-4 col-lg-4">
                            <select class="form-control" id="selectUsuario" name="id_usuario" data-toggle="select2" title="Usuarios Informáticos">
                                <option value="" disabled selected>Seleccionar Usuario</option>
                                <!-- Las opciones serán llenadas dinámicamente -->
                            </select> 
                        </div>  
                        
                        <div class="col-lg-3">
                            <input type="text" class="form-control date" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha Inicio">
                            {{-- <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true"> --}}
                        </div> <!-- end col -->
                        <div class="col-lg-3">
                            <input type="text" class="form-control date" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin">
                            {{-- <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true"> --}}
                        </div>
                        
                        <div class="col-xl-2 col-lg-2">
                            <div class="d-grid">
                                <button type="button" id="limpiarFiltro" class="btn btn-success">
                                    <i class="mdi mdi-file-sign me-2"></i>limpiar
                                </button>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#alt-pagination-preview" data-bs-toggle="tab" aria-expanded="false"
                                class="nav-link active">
                                Vista
                            </a>
                        </li>
                    </ul> <!-- end nav-->
                    <div class="tab-content">
                        <div class="tab-pane show active" id="responsive-preview">
                            <div class="table-responsive" id="contenedorRegistros">

                            </div>
                        </div> <!-- end preview-->

                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    @include('admin.bitacora.lista.verModal')

@endsection

@section('js-styles-home')
    <script src="{{ url('assets/js/vendor/jquery.dataTables.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/dataTables.bootstrap5.js') }}"></script>
    <script src="{{ url('assets/js/vendor/dataTables.responsive.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/responsive.bootstrap5.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/dataTables.buttons.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/buttons.bootstrap5.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/buttons.html5.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/buttons.flash.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/buttons.print.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/dataTables.keyTable.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/dataTables.select.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/fixedColumns.bootstrap5.min.js') }}"></script>
    <script src="{{ url('assets/js/vendor/fixedHeader.bootstrap5.min.js') }}"></script>
    <!-- demo app -->
    <script src="{{ url('assets/js/pages/demo.datatable-init.js') }}"></script>
    <!-- end demo js-->   

    <script src="{{ url('assets/js/vendor/apexcharts.min.js') }}"></script>
    
    <script>
        $(document).ready(function() {
            mostrar_tabla();
            listar_usuario();

            /*$('#selectUsuario').change(function() {
                let id_usuario = $(this).val();
                
                if (id_usuario) {
                    filtrarPorUsuario(id_usuario); 
                } else {
                    mostrar_tabla(); 
                }
            });*/

            $('#fecha_inicio').datepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });

            $('#fecha_fin').datepicker({
                singleDatePicker: true,
                locale: {
                    format: 'YYYY/MM/DD'
                }
            });

            $('#limpiarFiltro').click(function() {
                $('#selectUsuario').val('');
                $('#fecha_inicio').val(''); 
                $('#fecha_fin').val(''); 
                listar_usuario();
                mostrar_tabla();
            });

            actividadUsuario();

            $('#selectUsuario, #fecha_inicio, #fecha_fin').on('change', aplicarFiltros);
        });

        function mostrar_tabla() {
            //console.log('mostrar tabla');
            $.ajax({
                type: 'POST',
                url: '{{ route('listar.listActividades') }}',
                dataType: 'json',
                data: {_token: '{{ csrf_token() }}'},
                beforeSend: function() {

                    var spinner =
                        `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistros").html(spinner);

                },
                error: function(data) {

                    let errorJson = JSON.parse(data.responseText);

                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorJson.message,
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    });
                },
                success: function(data) {
                    //console.log(data.html);
                    $("#contenedorRegistros").html(data.html);
                    InicializacionTabla();
                    ver_actividad();
                }
            });

        }

        function InicializacionTabla() {

            $("#alternative-page-datatable").DataTable({
                pagingType: "full_numbers",
                language: {
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        previous: "<i class='mdi mdi-chevron-left'>",
                        next: "<i class='mdi mdi-chevron-right'>"
                    },
                    zeroRecords: "No se encontraron registros coincidentes",
                    loadingRecords: "Cargando...",
                    emptyTable: "No hay datos disponibles en la tabla",
                    processing: "Procesando...",
                },
                order: [[0, 'desc']],
                //order: [[3, 'desc']],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
                responsive: true,
                scrollX: true
            });
        }

        function listar_usuario() {
            $.ajax({
                type: 'POST',
                url: '{{ route('dashListaUsuario') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    //console.log('Oficinas:', data);
                    if (data.code === 200) {
                        let usuarios = data.usuarios;
                        let select = $('#selectUsuario'); // Seleccionar el <select>
                        select.empty(); // Limpiar opciones anteriores

                        // Agregar nuevamente la opción predeterminada
                        select.append('<option value="" disabled selected>Seleccionar Usuarios</option>');

                        // Iterar sobre las categorías jerárquicas para agregarlas al select
                        usuarios.forEach(function(usuario) {
                            // Añadir opción al select con un formato visual basado en el nivel
                            let optionText = usuario.nombreCompleto;
                            select.append(
                                $('<option></option>')
                                .val(usuario.id_usuario)
                                .text(optionText)
                            );
                        });
                    }
                },
                error: function(data) {
                    console.error('Error en listar usuario:', data);
                }
            });
        }

        /*function filtrarPorUsuario(id_usuario) {
            $.ajax({
                type: 'POST',
                url: '{{ route('filtrar.listActividades') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_usuario: id_usuario // Enviamos el id del usuario como filtro
                },
                beforeSend: function() {
                    var spinner = `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistros").html(spinner); // Muestra el spinner mientras cargan los datos
                },
                success: function(data) {
                    $("#contenedorRegistros").html(data.html); // Actualiza la tabla con los resultados filtrados
                    InicializacionTabla(); // Reinicia la tabla con el nuevo contenido
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorJson.message,
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    });
                }
            });
        }*/

        function aplicarFiltros() {
            let id_usuario = $('#selectUsuario').val();
            let fecha_inicio = $('#fecha_inicio').val();
            let fecha_fin = $('#fecha_fin').val();

            // Validación de fechas
            if (fecha_inicio && fecha_fin) {
                let fechaInicioDate = new Date(fecha_inicio);
                let fechaFinDate = new Date(fecha_fin);

                if (fechaFinDate < fechaInicioDate) {
                    $('#fecha_fin').val('');
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "La fecha de fin no puede ser menor que la fecha de inicio.",
                        timer: 3000,
                        timerProgressBar: true,
                    });
                    return;
                }
            }

            $.ajax({
                type: 'POST',
                url: '{{ route('filtrar.listActividades') }}', // Asegúrate de definir esta ruta en tu web.php
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}',
                    id_usuario: id_usuario,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin
                },
                beforeSend: function() {
                    var spinner = `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistros").html(spinner);
                },
                success: function(data) {
                    if (data.code === 200) {
                        $("#contenedorRegistros").html(data.html);
                        InicializacionTabla();
                    }
                },
                error: function(data) {
                    console.error('Error al filtrar bitácora:', data);
                }
            });
        }



        function actividadUsuario() { 
            $.ajax({
                type: 'POST',
                url: '{{ route('actividades.usuarios') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    let usuariosActividades = data.usuariosActividades;
                    let categories = [];
                    let pendientes = [];
                    let enProceso = [];
                    let atendidos = [];
                    let cancelados = [];

                    usuariosActividades.forEach(usuario => {
                        categories.push(usuario.nombre); // Nombre del usuario
                        pendientes.push(usuario.actividades.Pendiente);
                        enProceso.push(usuario.actividades['En Proceso']);
                        atendidos.push(usuario.actividades.Atendido);
                        cancelados.push(usuario.actividades.Cancelado);
                    });

                    // Configuración del gráfico
                    var options = {
                        chart: {
                            type: 'bar',
                            height: 400,
                            stacked: true // Apilado
                        },
                        series: [
                            { name: 'Pendiente', data: pendientes, color: '#3095b2' },
                            { name: 'En Proceso', data: enProceso, color: '#FEB019' },
                            { name: 'Atendido', data: atendidos, color: '#00E396' },
                            { name: 'Cancelado', data: cancelados, color: '#775DD0' }
                        ],
                        xaxis: {
                            categories: categories,
                            title: {
                                text: 'Usuarios'
                            }
                        },
                        yaxis: {
                            title: {
                                text: 'Cantidad de Actividades'
                            }
                        },
                        tooltip: {
                            y: {
                                formatter: function(value) {
                                    return value + " actividades";
                                }
                            }
                        }
                    };

                    // Renderizar gráfico
                    var chart = new ApexCharts(document.querySelector("#actividadUsuario"), options);
                    chart.render();
                },
                error: function(data) {
                    console.error('Error al obtener actividades:', data);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: "Ocurrió un error al obtener las actividades de los usuarios.",
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    });
                }
            });
        }

    </script>
    
@endsection