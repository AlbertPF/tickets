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
                        <li class="breadcrumb-item active">Tickets</li>
                    </ol>
                </div>
                <h4 class="page-title">Tickets</h4>
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
                            <h4 class="header-title">Lista de Tickets</h4>
                            <p class="text-muted font-14">
                                El personal del Gobierno Regional de Apurímac puede registrar tickets para reportar incidencias o
                                solicitar soporte técnico. Esto permite resolver problemas de manera eficiente y asegurar el correcto
                                funcionamiento de sus actividades. El sistema de tickets mejora la gestión interna y garantiza la
                                continuidad de los servicios públicos ofrecidos a la comunidad.
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
                        <li class="nav-item">
                            <a href="#tablaAsigTicket" data-bs-toggle="tab" aria-expanded="true" class="nav-link">
                                Mis Asignaciones
                            </a>
                        </li>
                    </ul> <!-- end nav-->

                    <div class="tab-content">
                        <div class="tab-pane show active" id="tablaTicket">
                            <div class="table-responsive" id="contenedorRegistros">

                            </div>
                        </div> <!-- end preview-->

                        <div class="tab-pane" id="tablaAsigTicket">
                            <div class="table-responsive" id="contenedorRegistrosAsig">

                            </div>
                        </div>


                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    @include('admin.tickest.verModal')
    @include('admin.tickest.asignacion.verModal')
    @include('admin.tickest.finalizarModal')
    @include('admin.tickest.asignacion.finalizarModal')
    @include('admin.tickest.cancelarModal')
    @include('admin.tickest.asignarModal')

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

            mostrar_tabla();

            setInterval(mostrar_tabla, 5 * 60 * 1000); 

            $('a[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href");
                if (target === '#tablaAsigTicket') {
                    mostrar_tablaAsig();
                }
            });

            //registrar_ticketsAsig();
        });

        /*----------- funciones--------------*/

        function mostrar_tabla() {
            //console.log('listar tickets');

            $.ajax({
                type: 'POST',
                url: '{{ route('listar.tickets') }}',
                dataType: 'json',
                data: {
                    _token: '{{ csrf_token() }}'
                },
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
                    ver_tickets();
                    registrar_ticketsAsig();
                    modalFinalizarTickets();
                    NoResuelto_ticketsAsig();
                    modalCancelarTickets();
                    AsignarModal_tickets();
                }
            });

        }

        function InicializacionTabla() {

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
                        /*case 'En proceso':
                            return 3;  // Siguiente en prioridad
                        case 'Atendido':
                            return 4;  // Siguiente en prioridad
                        case 'Cancelado':
                            return 5;
                        default: // Cancelado u otros estados
                            return 6;*/
                    }
                });
            };

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
                order: [
                    [5, 'desc', 'estado-prioridad'], // Ordenar por estado con prioridad
                    [6, 'desc'] // Luego por fecha (columna 5)
                ],
                columnDefs: [
                    { orderDataType: 'estado-prioridad', targets: 4 }, // Aplicar la función personalizada en la columna 4 (Estado)
                    { type: 'date', targets: 5 } // Asegurarse de que la columna 5 sea tratada como fecha
                ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
                responsive: true,
                scrollX: true
            });
        }

        function mostrar_tablaAsig() {
            //console.log('listar tickets');

            $.ajax({
                type: 'POST',
                url: '{{ route('listar.ticketsAsig') }}',
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
                    ver_AsigTickets();
                    modalFinalizarTickets2()
                    NoResuelto_ticketsAsig2();
                }
            });

        }

        function InicializacionTablaAsig() {
            $.fn.dataTable.ext.order['estado2-prioridad2'] = function(settings, colIndex) {
                return this.api().column(colIndex, { order: 'index' }).nodes().map(function(td, i) {
                    // Obtener el texto del estado
                    var estado = $(td).text().trim();

                    // Asignar prioridades a cada estado
                    switch (estado) {
                        case 'En proceso':
                            return 1;  // Mayor prioridad
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
                    [6, 'desc', ''],
                    [3, 'desc']
                ],
                columnDefs: [
                    { orderDataType: 'estado2-prioridad2', targets: 6 }, // Aplicar la función personalizada en la columna 4 (Estado)
                    { type: 'date', targets: 3 } // Asegurarse de que la columna 5 sea tratada como fecha
                ],
                drawCallback: function() {
                    $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                },
                responsive: true,
                scrollX: true
            });
        }

        function registrar_ticketsAsig() {
            $("#alternative-page-datatable tbody").on('click', '.asignar_ticket', function() {
                let id_ticket = $(this).attr('data-id-ticket');

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Se asignará el ticket al usuario actual.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, asignar !',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar solicitud AJAX para asignar el ticket
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('registrar.ticketsAsig') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_ticket: id_ticket,  // Enviar el id del ticket
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "Asignación exitosa!",
                                    icon: "success",
                                    text: data.message,
                                    timer: 2000,
                                    timerProgressBar: true,
                                });

                                $('a[href="#tablaAsigTicket"]').tab('show');

                                mostrar_tablaAsig();
                                mostrar_tabla();
                            },
                            error: function(error) {
                                let response = error.responseJSON;
                                /*if (error.status === 403) {
                                    Swal.fire({
                                        title: "Oops...",
                                        text: "Debe asignarse al primer ticket pendiente del día.",
                                        icon: "warning",
                                    });
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: "No se pudo asignar el ticket.",
                                        icon: "error",
                                    });
                                }*/
                                Swal.fire({
                                    title: "Oops...",
                                    text: response.message,
                                    icon: response.msg || "error",
                                }).then(() => {
                                    mostrar_tabla();
                                });
                            }
                        });
                    }
                });
            });
        }

        function NoResuelto_ticketsAsig() {
            $("#alternative-page-datatable tbody").on('click', '.no_resuelto_ticket', function() {
                let id_ticket = $(this).attr('data-id-ticket');

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Este ticket será marcado como no resuelto y cambiará de estado.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, marcar como no resuelto !',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar solicitud AJAX para asignar el ticket
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('no_resuelto.ticketsAsig') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_ticket: id_ticket,  // Enviar el id del ticket
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "Ticket marcado como no resuelto!",
                                    icon: "success",
                                    text: "El ticket ha sido cambiado a no resuelto.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                });

                                $('a[href="#tablaAsigTicket"]').tab('show');

                                mostrar_tablaAsig();
                                mostrar_tabla();
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error",
                                    text: "No se pudo marcar el ticket como no resuelto.",
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });
        }

        function NoResuelto_ticketsAsig2() {
            $("#selection-datatable tbody").on('click', '.no_logrado_ticket', function() {
                let id_ticket = $(this).attr('data-id-ticketAsig');

                Swal.fire({
                    title: "¿Estás seguro?",
                    text: "Este ticket será marcado como no resuelto y cambiará de estado.",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, marcar como no resuelto !',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar solicitud AJAX para asignar el ticket
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('no_resuelto.ticketsAsig') }}',
                            data: {
                                _token: '{{ csrf_token() }}',
                                id_ticket: id_ticket,  // Enviar el id del ticket
                            },
                            success: function(data) {
                                Swal.fire({
                                    title: "Ticket marcado como no resuelto!",
                                    icon: "success",
                                    text: "El ticket ha sido cambiado a no resuelto.",
                                    timer: 2000,
                                    timerProgressBar: true,
                                });

                                $('a[href="#tablaAsigTicket"]').tab('show');

                                mostrar_tablaAsig();
                                mostrar_tabla();
                            },
                            error: function(error) {
                                Swal.fire({
                                    title: "Error",
                                    text: "No se pudo marcar el ticket como no resuelto.",
                                    icon: "error",
                                });
                            }
                        });
                    }
                });
            });
        }

    </script>
@endsection