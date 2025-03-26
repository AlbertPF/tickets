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
                        <li class="breadcrumb-item active">Resumen General</li>
                    </ol>
                </div>
                <h4 class="page-title">Resumen General</h4>
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
                            <h4 class="header-title">Lista de Resumen General de actividades</h4>
                            <p class="text-muted font-14">
                                Esta es la lista de resumen general de las actividades realizadas por el personal de la 
                                Sub Gerencia de Desarrollo Institucional, Estadística e Informática del Gobierno Regional de Apurímac. 
                                Aquí se registran y documentan las tareas ejecutadas en diversas áreas, permitiendo un seguimiento detallado 
                                del trabajo realizado. Además, puede filtrar la información según sus necesidades y generar un reporte 
                                en formato imprimible para un mejor control y análisis.
                            </p>
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
            listar_usuario();

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


            $('#selectUsuario, #fecha_inicio, #fecha_fin').on('change', aplicarFiltros);
        });

        $('#limpiarFiltro').click(function() {
            $('#selectUsuario').val('');
            $('#fecha_inicio').val('');
            $('#fecha_fin').val('');
            listar_usuario();
            mostrar_tabla();
        });

        function mostrar_tabla() {
            //console.log('mostrar tabla');
            $.ajax({
                type: 'POST',
                url: '{{ route('listar.resumen') }}',
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
                }
            });

        }

        
    </script>

    @include('admin.Resumen.filtroTabla')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- Para Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> <!-- Fuentes para PDF -->
@endsection