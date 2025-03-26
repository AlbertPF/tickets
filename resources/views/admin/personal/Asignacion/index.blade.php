@extends('layout.app')

@section('css-styles-home')
    <link href="{{ url('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedHeader.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedColumns.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
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
                        <li class="breadcrumb-item active">Asignación</li>
                    </ol>
                </div>
                <h4 class="page-title">Asignación</h4>
            </div>
        </div>
    </div>
    <!-- título de la página final -->

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10">
                            <h4 class="header-title">Lista de Asignación de Personal</h4>
                            <p class="text-muted font-14">
                                El proceso de asignación de personal a las diversas oficinas del Gobierno Regional de Apurímac es 
                                fundamental para garantizar una adecuada distribución de los recursos humanos. El personal asignado 
                                desempeña roles clave en el fortalecimiento de las actividades administrativas y operativas, 
                                contribuyendo al cumplimiento de los objetivos institucionales y al desarrollo de la región.
                            </p>
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-2">
                            <div class="d-grid">
                                <button type="button" class="btn btn-success asignar_personal" data-bs-toggle="modal"
                                    data-bs-target="#modal-asignar-personal"><i class="mdi mdi-account-convert-outline me-2"></i>
                                    Asignar
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

@include('admin.personal.Asignacion.modal')

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

        });

        /*----------- funciones--------------*/

        function mostrar_tabla() {
            //console.log('hola luis');

            $.ajax({
                type: 'POST',
                url: '{{ route('listar.ofiPersonal') }}',
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
                    //editarAsig_personal();
                    //eliminar_personal();
                    //ver_personal();
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
                order: [
                    [2, 'desc'],
                    [4, 'desc']
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