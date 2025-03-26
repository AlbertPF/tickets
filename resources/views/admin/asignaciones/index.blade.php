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

            mostrar_tablaAsig();


        });

        function mostrar_tablaAsig() {
            //console.log('listar tickets');

            $.ajax({
                type: 'POST',
                url: '{{ route('listar.ticketsAsigGeneral') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {

                    var spinner =
                        `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistrosAsig").html(spinner);

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


    </script>
@endsection