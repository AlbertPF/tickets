@extends('layout.app')

@section('css-styles-home')
    <link href="{{ url('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedHeader.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('assets/css/vendor/fixedColumns.bootstrap5.css') }}" rel="stylesheet" type="text/css" /> 
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
@endsection


@section('contenido')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Gore</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('homeAdmin') }}">Potal Administativo</a></li>
                        <li class="breadcrumb-item active">Incidencias</li>
                    </ol>
                </div>
                <h4 class="page-title">Incidencias</h4>
            </div>
        </div>
    </div>
    <!-- end page title --> 

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-9 col-lg-10">
                            <h4 class="header-title">Lista de Incidencias</h4>
                            <p class="text-muted font-14" style="text-align: justify;">
                                En el Gobierno Regional de Apurímac, las incidencias más comunes que se presentan en las oficinas incluyen:
                            </p>
                        </div>
                        <div class="col-xl-3 col-lg-2">
                            <div class="d-grid">
                                {{-- <button type="button" class="btn btn-sm btn-info"><i class="uil-circuit"></i>Nuevo Usuario</button> --}}
                                <button type="button" class="btn btn-success agregar_incidencia" data-bs-toggle="modal"
                                    data-bs-target="#modal-nueva-incidencia"><i class="mdi mdi-notebook-plus me-2"></i>
                                    Nuevo Incidencia</button>
                            </div>
                        </div>
                    </div>

                    <ul class="nav nav-tabs nav-bordered mb-3">
                        <li class="nav-item">
                            <a href="#alt-pagination-preview" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">
                                Vista
                            </a>
                        </li>
                    </ul> <!-- end nav-->

                    <div class="tab-content">
                        <div class="tab-pane show active" id="alt-pagination-preview">
                            <div class="table-responsive" id="contenedorRegistros">
                                    
                            </div>                                           
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div> <!-- end row-->

    @include('admin.soporte.modal')

@endsection

@section('js-styles-home')
    <script>
        $(document).ready(function() {
            mostrar_tabla();
        });

        function mostrar_tabla() {
            //console.log('tabla Inicializado');

            $.ajax({
                type: 'POST',
                url: '{{ route('incidencia.listar') }}',
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
                    editar_incidencia();
                    eliminar_incidencia();
                    
                }
            });

            function InicializacionTabla() {
                // Initialize DataTable
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
                    drawCallback: function() {
                        $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
                    },
                    responsive: true,
                    scrollX: true
                });
            }

        }

        function eliminar_incidencia() {
            $("#alternative-page-datatable tbody").on('click', '.eliminar_soporte', function() {
                let id_soporte = $(this).attr('data-id-soporte');
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¡No podrás revertir esto!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: 'danger',
                    confirmButtonText: 'Sí, eliminarlo',
                    cancelButtonText: 'Cancelar',
                    showLoaderOnConfirm: true,
                    preConfirm: () => {
                        let token = $('meta[name="csrf-token"]').attr('content');
                        return fetch('{{ route('incidencia.eliminar') }}', {
                            method: "POST",
                            body: JSON.stringify({
                                id_soporte: id_soporte
                            }),
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': token,
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        }).then(response => {
                            if (!response.ok) {
                                return response.text().then(text => {
                                    throw new Error(text)
                                })
                            } else {
                                return response.json()
                            }
                        }).catch(response => {
                            let texto = JSON.parse(response.toString().substring(7));
                            let mensaje = texto.message;
                            Swal.showValidationMessage(
                                `Error: ${mensaje}`
                            )
                        });
                    },
                    allowOutsideClick: () => !Swal.isLoading()
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Eliminado!',
                            text: result.value.message,
                            icon: 'success',
                            confirmButtonText: 'Ok',
                            timer: 3000,
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading()
                                timerInterval = setInterval(() => {}, 100)
                            },
                            willClose: () => {
                                clearInterval(timerInterval)
                            }
                        }).then((confirmar) => {
                            if (confirmar.isConfirmed || confirmar.dismiss === Swal.DismissReason
                                .timer) {
                                mostrar_tabla();
                            }
                        });
                    }
                });
            });
        }
    </script>
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

@endsection