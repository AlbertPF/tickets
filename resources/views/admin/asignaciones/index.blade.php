@extends('layout.app')

@section('css-styles-home')
    <link href="{{ url('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedHeader.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedColumns.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="assets/css/style.css">
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
                        <li class="breadcrumb-item active">Asignaciones</li>
                    </ol>
                </div>
                <h4 class="page-title">Asignaciones</h4>
            </div>
        </div>
    </div>
    <!-- título de la página final -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-10 col-lg-10">
                            <h4 class="header-title">Lista de Asignaciones</h4>
                            <p class="text-muted font-14">
                                En el Gobierno Regional de Apurímac, el equipo de soporte técnico brinda asistencia técnica a
                                todas las oficinas del gobierno regional. Este sistema permite registrar asignaciones para 
                                atender solicitudes de asistencia y resolver problemas técnicos, facilitando así un servicio 
                                continuo y eficiente en cada área. De esta forma, se asegura que las actividades del gobierno 
                                se realicen sin interrupciones, beneficiando directamente a la comunidad.
                            </p>
                        </div>
                        {{-- <div class="col-xl-3 col-lg-2">
                            <div class="d-grid">
                                <button type="button" class="btn btn-success agregar_personal" data-bs-toggle="modal"
                                    data-bs-target="#modal-nuevo-personal"><i class="mdi mdi-account-multiple-plus me-2"></i>
                                    Nuevo Personal</button>
                            </div>
                        </div> --}}
                    </div>
                    <div class="row mb-2">
                        <label class="form-label">Filtro por Fecha :</label>
                        <div class="col-xl-3 col-lg-3">
                            <select class="form-control" id="selectUsuario" name="id_usuario" data-toggle="select2" title="Usuarios Informáticos">
                                <option value="" disabled selected>Seleccionar Usuario</option>
                                <!-- Las opciones serán llenadas dinámicamente -->
                            </select> 
                        </div>  
                        <div class="col-xl-3 col-lg-3">
                            <input type="text" class="form-control date" id="fecha_inicio" name="fecha_inicio"
                                placeholder="Fecha Inicio">
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <input type="text" class="form-control date" id="fecha_fin" name="fecha_fin"
                                placeholder="Fecha Fin">
                        </div>
                        <div class="col-xl-2 col-lg-2">
                            <div class="d-grid">
                                <button type="button" id="limpiarFiltro" class="btn btn-primary">
                                    <i class="mdi mdi-file-sign me-2"></i>limpiar
                                </button>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#tablaTicket" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Vista
                            </a>
                        </li>
                    </ul> <!-- end nav-->

                    <div class="tab-content">
                        <div class="tab-pane show active" id="tablaTicket">
                            <div class="tab-pane" id="tablaAsigTicket">
                                <div class="table-responsive" id="contenedorRegistrosAsig">
    
                                </div>
                            </div>
                        </div> <!-- end preview-->

                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    @include('admin.asignaciones.verModal')

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

    <script>
        $(document).ready(function() {
            let hoy = moment();
            let primerDia = moment().startOf('month');

            let configuracionFecha = {
                singleDatePicker: true,
                autoUpdateInput: false,
                autoApply: true,
                locale: {
                    format: 'DD/MM/YYYY',
                    applyLabel: 'Aplicar',
                    cancelLabel: 'Cancelar',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                    monthNames: [
                        'Enero', 'Febrero', 'Marzo', 'Abril',
                        'Mayo', 'Junio', 'Julio', 'Agosto',
                        'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'
                    ],
                    firstDay: 1
                }
            };

            $('#fecha_inicio').daterangepicker({
                ...configuracionFecha, startDate: primerDia, endDate: primerDia
            });

            $('#fecha_fin').daterangepicker({
                ...configuracionFecha, startDate: hoy, endDate: hoy
            });

            $('#fecha_inicio').val(primerDia.format('DD/MM/YYYY'));
            $('#fecha_fin').val(hoy.format('DD/MM/YYYY'));

            listar_usuario();
            mostrar_tablaAsig();

            $('#fecha_inicio, #fecha_fin').on('apply.daterangepicker', function(ev, picker) {
                $(this).val(picker.startDate.format('DD/MM/YYYY'));
                mostrar_tablaAsig();
            });

            $('#selectUsuario').on('change', function() {
                mostrar_tablaAsig();
            });

            $('#limpiarFiltro').on('click', function() {

                $('#selectUsuario').val('').trigger('change.select2');

                let hoy = moment();
                let primerDia = moment().startOf('month');

                let pickerInicio = $('#fecha_inicio').data('daterangepicker');

                pickerInicio.setStartDate(primerDia);
                pickerInicio.setEndDate(primerDia);

                let pickerFin = $('#fecha_fin').data('daterangepicker');

                pickerFin.setStartDate(hoy);
                pickerFin.setEndDate(hoy);

                $('#fecha_inicio').val(primerDia.format('DD/MM/YYYY'));
                $('#fecha_fin').val(hoy.format('DD/MM/YYYY'));

                mostrar_tablaAsig();
            });

        });

        function mostrar_tablaAsig() {
            //console.log('listar tickets');
            let id_usuario = $('#selectUsuario').val();
            if (id_usuario === '') {
                id_usuario = null;
            }
            let fechaInicioVisual = $('#fecha_inicio').val();
            let fechaFinVisual = $('#fecha_fin').val();

            let fechaInicio = moment(fechaInicioVisual, 'DD/MM/YYYY', true);
            let fechaFin = moment(fechaFinVisual, 'DD/MM/YYYY', true);

            if (!fechaInicio.isValid() || !fechaFin.isValid()) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Fechas inválidas',
                    text: 'Seleccione correctamente ambas fechas.'
                });
                return;
            }

            if (fechaFin.isBefore(fechaInicio, 'day')) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Rango de fechas incorrecto',
                    text: 'La fecha de fin no puede ser menor que la fecha de inicio.'
                });
                return;
            }

            let fecha_inicio = fechaInicio.format('YYYY-MM-DD');
            let fecha_fin = fechaFin.format('YYYY-MM-DD');

            $.ajax({
                type: 'POST',
                url: '{{ route('listar.ticketsAsigGeneral') }}',
                dataType: 'json',
                headers: {
                    'Accept': 'application/json'
                },
                data: {
                    _token: '{{ csrf_token() }}',
                    id_usuario: id_usuario,
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin
                },
                beforeSend: function() {
                     $("#contenedorRegistrosAsig").html(`
                        <div class="text-center p-4">
                            <div class="spinner-border text-info" role="status">
                                <span class="visually-hidden">Cargando...</span>
                            </div>
                        </div>
                    `);
                },
                error: function(xhr, status, error) {
                    let mensaje = xhr.responseJSON?.message ||
                        'Hubo un problema al filtrar las asignaciones de tickets.';
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: mensaje,
                        timer: 3000,
                        timerProgressBar: true
                    });

                },
                success: function(data) {
                    //console.log(data.html);
                    $("#contenedorRegistrosAsig").html(data.html);
                    InicializacionTablaAsig();
                    ver_AsigTicketsGeneral();
                }
            });

        }

        function InicializacionTablaAsig() {
            $.fn.dataTable.ext.order['estado-prioridad'] = function(settings, colIndex) {
                return this.api().column(colIndex, { order: 'index' }).nodes().map(function(td, i) {
                    // Obtener el texto del estado
                    var estado = $(td).text().trim();

                    // Asignar prioridades a cada estado
                    switch (estado) {
                        case 'No logrado':
                            return 1;  // Mayor prioridad
                        case 'Registrado':
                            return 2;  // Menor prioridad
                        case 'En proceso':
                            return 3;  // Siguiente en prioridad
                        /*case 'Atendido':
                            return 4;  // Siguiente en prioridad
                        case 'Cancelado':
                            return 5;
                        default: // Cancelado u otros estados
                            return 6;*/
                    }
                });
            };

            $("#selection-datatable").DataTable({
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
                order: [
                    //[7, 'desc', 'estado-prioridad'], // Ordenar por estado con prioridad
                    [4, 'desc'] // Luego por fecha (columna 5)
                ],
                columnDefs: [
                    //{ orderDataType: 'estado-prioridad', targets: 7 }, // Aplicar la función personalizada en la columna 4 (Estado)
                    { type: 'date', targets: 4 } // Asegurarse de que la columna 5 sea tratada como fecha
                ],
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

    </script>
@endsection