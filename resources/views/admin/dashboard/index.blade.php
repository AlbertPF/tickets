@extends('layout.app')

@section('css-styles-home')
<link href="{{ url('assets/css/vendor/dataTables.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/vendor/responsive.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/vendor/buttons.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/vendor/select.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/vendor/fixedHeader.bootstrap5.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ url('assets/css/vendor/fixedColumns.bootstrap5.css') }}" rel="stylesheet" type="text/css" /> 
{{-- <link href="{{ asset('assets/css/stylePortal.css') }}"  rel="stylesheet"> --}}
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
                        <li class="breadcrumb-item active">Panel Administrativo</li>
                    </ol>
                </div>
                <h4 class="page-title">Panel Administrativo</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one widget-flat">
                <div class="card-body bg-success text-white">
                    <i class="mdi mdi-notebook float-end text-white"></i>
                    <h6 class="text-uppercase mt-0">Tickets</h6>
                    <h2 class="my-2" id="cantTickets">0</h2>
                      <p class="mb-0 text-muted">
                        <!--<span class="text-white me-2"><span class="mdi mdi-arrow-down-bold"></span> 1.08%</span> -->
                        <span class="text-white">registrados</span>
                    </p>
                        <!-- <div class="row">
                            <div class="col-md-3 col-xl-3">
                                <span class="text-white">R:</span>
                                <span class="text-white me-2"><span class="mdi mdi-arrow-up-bold registrados">0</span></span>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <span class="text-white">A:</span>
                                <span class="text-white me-2"><span class="mdi mdi-arrow-up-bold atendidos">0</span></span>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <span class="text-white">P:</span>
                                <span class="text-white me-2"><span class="mdi mdi-arrow-up-bold proceso">0</span></span>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <span class="text-white">NA:</span>
                                <span class="text-white me-2"><span class="mdi mdi-arrow-up-bold noAtendidos">0</span></span>
                            </div>
                            <div class="col-md-3 col-xl-3">
                                <span class="text-white">C:</span>
                                <span class="text-white me-2"><span class="mdi mdi-arrow-up-bold cancelados">0</span></span>
                            </div>
                        </div> -->
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div>
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one widget-flat">
                <div class="card-body bg-warning text-white">
                    <i class="mdi mdi-archive float-end text-white"></i>
                    <h6 class="text-uppercase mt-0">Oficinas</h6>
                    <h2 class="my-2" id="cantOficinas">0</h2>
                    <p class="mb-0 text-muted">
                        {{-- <span class="text-white me-2"><span class="mdi mdi-arrow-down-bold"></span> 1.08%</span> --}}
                        <span class="text-white">registradas</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one widget-flat">
                <div class="card-body bg-primary text-white">
                    <i class='mdi mdi-account-group float-end'></i>
                    <h6 class="text-uppercase mt-0">Personal</h6>
                    <h2 class="my-2" id="cantPersonal">0</h2>
                    <p class="mb-0 text-muted">
                        {{-- <span class="text-white me-2"><span class="mdi mdi-arrow-down-bold"></span> 1.08%</span> --}}
                        <span class="text-white">registrados</span>
                    </p> 
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div> <!-- end col -->
        <div class="col-md-6 col-xl-3">
            <div class="card tilebox-one widget-flat">
                <div class="card-body bg-info text-white">
                    <i class='mdi mdi-account-group float-end'></i>
                    <h6 class="text-uppercase mt-0">Usuarios de Informática</h6>
                    <h2 class="my-2" id="cantUsuarios">0</h2>
                    <p class="mb-0 text-muted">
                        {{-- <span class="text-white me-2"><span class="mdi mdi-arrow-down-bold"></span> 1.08%</span> --}}
                        <span class="text-white">registrados</span>
                    </p>
                </div> <!-- end card-body-->
            </div>
            <!--end card-->
        </div> <!-- end col -->

    </div>
    <!-- end row -->

    <div class="row">
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6 col-lg-3">
                            <div class="card shadow-none m-0">
                                <a href="{{ route('index.tickets') }}">
                                    <div class="card-body text-center">
                                        {{-- <i class="dripicons-briefcase text-muted" style="font-size: 24px;"></i> --}}
                                        <h3><i class="mdi mdi-file-document text-info"></i><span class="registrados" style="color: var(--ct-body-color);">0</span></h3>
                                        <p class="text-muted font-15 mb-0">Tickets Pendientes</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-check-circle-outline text-success"></i><span class="atendidos">0</span></h3>
                                    <p class="text-muted font-15 mb-0">Tickets Atendidos</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-progress-clock text-warning"></i><span class="proceso">0</span></h3>
                                    <p class="text-muted font-15 mb-0">Tickets en Proceso</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-close-circle-outline text-secondary"></i><span class="noAtendidos">0</span></h3>
                                    <p class="text-muted font-15 mb-0">Tickets no Atendidos</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-3">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-cancel text-danger"></i><span class="cancelados">0</span></h3>
                                    <p class="text-muted font-15 mb-0">Tickets cancelados</p>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end row -->
                </div>
            </div> <!-- end card-box-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

    <div class="row">

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Cantidad de Tickets por Soporte</h4> --}}
                    <div class="row">
                        <div class="col-xl-3 col-lg-3">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="tsmes">Mes :</label>
                                <select id="tsmes" class="form-control select2" data-toggle="select2">
                                    <option value="" selected disabled>selecione mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="tsanio">Año :</label>
                                <select id="tsanio" class="form-control select2" data-toggle="select2">
                                </select>
                            </div>
                        </div>
                    </div>

                    <div dir="ltr">
                        <div id="cantTicketPorSoporte" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Cantidad de Tickets Atendidos con éxito por Usuarios de Informática</h4> --}}
                    <div class="row">
                        <div class="col-xl-3 col-lg-3">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="mes">Mes :</label>
                                <select id="mes" class="form-control select2" data-toggle="select2">
                                    <option value="" selected disabled>selecione mes</option>
                                    <option value="01">Enero</option>
                                    <option value="02">Febrero</option>
                                    <option value="03">Marzo</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Mayo</option>
                                    <option value="06">Junio</option>
                                    <option value="07">Julio</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-3">
                            <div class="mb-3 form-group">
                                <label class="form-label" for="anio">Año :</label>
                                <select id="anio" class="form-control select2" data-toggle="select2">
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    
                    <div dir="ltr">
                        <div id="cantTikectResultadosPorUsuario" class="apex-charts"></div>
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

        <div class="col-xl-12">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Cantidad de Tickets registrados por día.</h4> --}}
                    <div dir="ltr">
                        <div id="ticketsPorDia" class="apex-charts"></div>
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

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Top 5 de oficinas con más solicitudes</h4> --}}
                    <div dir="ltr">
                        <div id="graficoTopOficinas" class="apex-charts"></div>
                    </div>
                </div>
                <!-- end card body-->
            </div>
            <!-- end card -->
        </div>
        <!-- end col-->

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    {{-- <h4 class="header-title">Top 5 problemas más comunes</h4> --}}
                    <div dir="ltr">
                        <div id="graficoTopProblemas" class="apex-charts"></div>
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

                    <label class="form-label text-info ">Filtro de Asignación </label>

                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Usuario Informático :</label>
                            <select class="form-control" id="selectUsuario" name="id_usuario" data-toggle="select2" title="Usuarios Informáticos">
                                <option value="" disabled selected>Seleccionar Usuario</option>
                                <!-- Las opciones serán llenadas dinámicamente -->
                            </select>
                        </div> <!-- end col -->
                        <div class="col-lg-3">
                            <label class="form-label">Incidencia :</label>
                            <select id="selectIncidencia" name="id_soporte" data-toggle="select2" title="Incidencia">
                                <option value="" disabled selected>Seleccionar Incidencia</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Personal :</label>
                            <select id="selectPersonal" name="id_personal" data-toggle="select2" title="Personal">
                                <option value="" disabled selected>Seleccionar Personal</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-label">Oficina :</label>
                            <select id="selectOficina" name="id_oficina" data-toggle="select2" title="Oficina">
                                <option value="" disabled selected>Seleccionar Oficina</option>
                            </select>
                        </div>
                    </div> <!-- end row --> 

                    <br>    

                    <label class="form-label text-info">Filtro por Rango de Fechas <strong class="buscador-text"></strong></label>
                    {{-- <p class="mb-1 fw-bold text-muted">Buscador avanzado de solo ........</p> --}}

                    <div class="row">
                        <div class="col-lg-3">
                            <input type="text" class="form-control date" id="fecha_inicio" name="fecha_inicio" placeholder="Fecha Inicio">
                            {{-- <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true"> --}}
                        </div> <!-- end col -->
                        <div class="col-lg-3">
                            <input type="text" class="form-control date" id="fecha_fin" name="fecha_fin" placeholder="Fecha Fin">
                            {{-- <input type="text" class="form-control date" id="birthdatepicker" data-toggle="date-picker" data-single-date-picker="true"> --}}
                        </div>
                        <div class="col-lg-6">
                            <div class="app-search dropdown d-none d-lg-block">
                                <div class="input-group">
                                    <input type="text" id="buscar" name="buscar" class="form-control" placeholder="Palabra Clave" aria-label="Buscar">
                                    <span class="mdi mdi-magnify search-icon"></span>
                                    <button class="btn btn-info"  id="buscar-btn" type="button">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row --> 

                    <br>

                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-info" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
                        </div>
                    </div>

                    <br>
                    
                    <div class="tab-content">
                        <div class="tab-pane show active" id="buttons-table-preview">
                            <div class="table-responsive" id="contenedorRegistros">
                                   
                            </div>                              
                        </div> <!-- end preview-->
                    
                    </div> <!-- end tab-content--> 

                </div> <!-- end card body-->
            </div> <!-- end card -->
        </div><!-- end col-->
    </div>
    <!-- end row-->
    

@endsection

@section('js-styles-home')

    <script>
        $(document).ready(function() {

            CantidadDatos();
            //cantidadTicketPorSoporte();
            let currentDatest = new Date();
            let currentYearst = currentDatest.getFullYear();
            let currentMonthst = String(currentDatest.getMonth() + 1).padStart(2, '0'); // Mes en formato 01-12

            $('#tsmes').val(currentMonthst);
            $('#tsanio').val(currentYearst);

            // Cargar gráfico con el mes y año actual
            cantidadTicketPorSoporte(currentMonthst, currentYearst);

            $('#tsmes, #tsanio').change(function () {
                let selectedMonthst = $('#tsmes').val();
                let selectedYearst = $('#tsanio').val();
                cantidadTicketPorSoporte(selectedMonthst, selectedYearst);
            });

            //cantTikectResultadosPorUsuario();
            let currentDate = new Date();
            let currentYear = currentDate.getFullYear();
            let currentMonth = String(currentDate.getMonth() + 1).padStart(2, '0'); // Mes en formato 01-12

            $('#mes').val(currentMonth);
            $('#anio').val(currentYear);

            // Cargar gráfico con el mes y año actual
            cantTikectResultadosPorUsuario(currentMonth, currentYear);

            // Evento para cambiar los filtros
            $('#mes, #anio').change(function () {
                let selectedMonth = $('#mes').val();
                let selectedYear = $('#anio').val();
                cantTikectResultadosPorUsuario(selectedMonth, selectedYear);
            });

            cargarAnios('tsanio');
            cargarAnios('anio');

            mostrarTicketsPorDia();

            mostrarGraficoTopOficinas(); 
            mostrarGraficoTopProblemas();

            mostrar_tabla();
            $('.date').datepicker({
                format: 'yyyy-mm-dd', // Formato de fecha
                autoclose: true, // Cierra automáticamente el datepicker al seleccionar la fecha
                //todayHighlight: true, // Resalta el día de hoy
                orientation: "bottom auto", // Coloca el calendario en la parte inferior automáticamente
                clearBtn: true // Botón para limpiar la fecha
            });

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

            listar_personal();
            listar_usuario();
            listar_incidencia();
            listar_oficina();


            $('#buscar-btn').click(function() {
                var query = $('#buscar').val(); // Obtener el valor del campo de búsqueda
                
                $.ajax({
                    url: '{{ route('dashBuscar.pCalve') }}', // La ruta del controlador para manejar la búsqueda
                    type: 'GET',
                    data: { buscar: query }, // Pasar el valor del campo de búsqueda
                    beforeSend: function() {
                        var spinner = `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                        $("#contenedorRegistros").html(spinner);
                    },
                    success: function(data) {
                        // Renderiza la tabla con los resultados de la búsqueda
                        //$('#tabla-archivos').html(response.html); 
                        //console.log(data);  
                        
                        if (data.code === 200) {
                            $("#contenedorRegistros").html(data.html);
                            InicializacionTabla();
                        } else {
                            $("#contenedorRegistros").html(data.html); // Mostrar la tabla vacía
                            Swal.fire({
                                icon: "warning",
                                title: "Sin datos",
                                text: data.msg
                            });
                        }
                    },
                    error: function(data) {
                        //alert('Error en la búsqueda.');
                        let errorJson = JSON.parse(data.responseText);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: errorJson.message,
                            footer: '<a href="">Vuelva a intentarlo</a>'
                        });
                    }
                });
            });

            $('#selectPersonal, #selectUsuario, #selectIncidencia, #selectOficina, #fecha_inicio, #fecha_fin').on('change', aplicarFiltros);

        });

        function CantidadDatos(){
            $.ajax({
                url: "{{ route('cantidadDatos') }}",
                method: 'GET',
                dataType: 'JSON',
                success: function(data) {
                    $('.atendidos').text(data.ticketsAtendidos);
                    $('.registrados').text(data.ticketsRegistrados);
                    $('.proceso').text(data.ticketsProceso);
                    $('.noAtendidos').text(data.ticketsNoAtendidos);
                    $('.cancelados').text(data.ticketsCancelados);
                    $('#cantTickets').text(data.tickets);
                    $('#cantOficinas').text(data.oficinas);
                    $('#cantPersonal').text(data.personal);
                    $('#cantUsuarios').text(data.usuarios);
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
        }

        function cargarAnios(selectId) {
            let select = document.getElementById(selectId);
            let yearActual = new Date().getFullYear(); // Obtener año actual
            let yearInicio = 2023; // Año de inicio
            let yearMax = yearActual + 1; // Año actual + 1

            // Vaciar el select antes de llenarlo
            select.innerHTML = '<option value="" selected disabled>Seleccione año</option>';

            // Generar las opciones dinámicamente
            for (let year = yearInicio; year <= yearMax; year++) {
                let option = document.createElement('option');
                option.value = year;
                option.textContent = year;
                select.appendChild(option);
            }
        }

         /*====================Tickets  por soporte sin filtro de fecha=====================*/
        /*function cantidadTicketPorSoporte() {
            $.ajax({
                url: '{{ route('cantTicketSoporte') }}',
                method: 'GET',
                success: function(data) {
                    //console.log(data); 
                    var soporteNames = [];
                    var ticketCounts = [];

                    // Accede a 'cantTickSopote' en la respuesta JSON
                    data.cantTickSopote.forEach(function(soporte) {
                        soporteNames.push(soporte.nombre);
                        ticketCounts.push(soporte.total);
                    });

                    var colors = [
                        "#727cf5", "#0acf97", "#fa5c7c", "#6c757d", 
                        "#39afd1", "#2b908f", "#ffbc00", "#90ee7e", 
                        "#f48024", "#212730"
                    ];

                    var options = {
                        chart: {
                            height: 450,
                            type: "bar"
                        },
                        plotOptions: {
                            bar: {
                                barHeight: "100%",
                                distributed: true,  // Colores diferentes por cada barra
                                horizontal: true,   // Barras horizontales
                                dataLabels: {
                                    position: "bottom"  // Posición de las etiquetas dentro de la barra
                                }
                            }
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: true,           // Mostrar etiquetas
                            textAnchor: "start",     // Alinear las etiquetas a la izquierda
                            style: {
                                colors: ["#fff"]       // Color del texto
                            },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: false
                            }
                        },
                        series: [{
                            name: 'Tickets',
                            data: ticketCounts  // Valores de las barras
                        }],
                        stroke: {
                            width: 2,
                            colors: ["#fff"]           // Sin borde en las barras
                        },
                        xaxis: {
                            categories: soporteNames  // Nombres de los soportes
                        },
                        yaxis: {
                            labels: {
                                show: false  // Ocultar etiquetas en el eje Y
                            }
                        },
                        grid: {
                            borderColor: "#f1f3fa"  // Color del borde de la cuadrícula
                        },
                        tooltip: {
                            theme: "dark",  // Tema oscuro para el tooltip
                            x: {
                                show: false   // Ocultar nombres en el tooltip
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return "";
                                    }
                                }
                            }
                        },
                        title: {
                            text: 'Tickets por Soporte',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#cantTicketPorSoporte"), options);
                    chart.render();
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
        var chart = null;
        function cantidadTicketPorSoporte(tsmes, tsanio) {
            //console.log("Mes:", tsmes, "Año:", tsanio);
            $.ajax({
                url: '{{ route('cantTicketSoporte') }}',
                method: 'GET',
                data: {tsmes: tsmes, tsanio: tsanio }, // Enviar datos en la petición
                success: function(data) {
                    var soporteNames = [];
                    var ticketCounts = [];

                    data.cantTickSopote.forEach(function(soporte) {
                        soporteNames.push(soporte.nombre);
                        ticketCounts.push(soporte.total);
                    });

                    var colors = [
                        "#727cf5", "#0acf97", "#fa5c7c", "#6c757d", 
                        "#39afd1", "#2b908f", "#ffbc00", "#90ee7e", 
                        "#f48024", "#212730"
                    ];

                    var options = {
                        chart: {
                            height: 450,
                            type: "bar"
                        },
                        plotOptions: {
                            bar: {
                                barHeight: "100%",
                                distributed: true,
                                horizontal: true,
                                dataLabels: {
                                    position: "bottom"
                                }
                            }
                        },
                        colors: colors,
                        dataLabels: {
                            enabled: true,
                            textAnchor: "start",
                            style: { colors: ["#fff"] },
                            formatter: function (val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: false
                            }
                        },
                        series: [{ name: 'Tickets', data: ticketCounts }],
                        stroke: {width: 2,colors: ["#fff"]},
                        xaxis: { categories: soporteNames },
                        yaxis: { labels: { show: false } },
                        grid: {borderColor: "#f1f3fa"},
                        tooltip: {
                            theme: "dark",  // Tema oscuro para el tooltip
                            x: {
                                show: false   // Ocultar nombres en el tooltip
                            },
                            y: {
                                title: {
                                    formatter: function () {
                                        return "";
                                    }
                                }
                            }
                        },
                        title: { text: 'Tickets por Soporte', align: 'center' }
                    };

                    $("#cantTicketPorSoporte").html(""); // Resetear gráfico
                    var chart = new ApexCharts(document.querySelector("#cantTicketPorSoporte"), options);
                    chart.render();
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
        }


        /*====================Tickets resuelto por usuario sin filtro de fecha=====================*/
        /*function cantTikectResultadosPorUsuario() {
            $.ajax({
                url: '{{ route('cantticketsResueltosUsu') }}', // Asegúrate de tener la ruta correcta
                method: 'GET',
                success: function(data) {
                    //console.log(data);
                    var nombres = [];
                    var ticketsResueltos = [];

                    // Procesar los datos obtenidos
                    data.TikectResultadosPorUsuario.forEach(function(usuario) {
                        nombres.push(usuario.nombre_completo);
                        ticketsResueltos.push(usuario.tickets_resueltos);
                    });

                    // Configuración del gráfico con ApexCharts
                    var colors = ["#727cf5", "#6c757d", "#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#e3eaef", "#313a46"];
                    var options = {
                        chart: {
                            height: 450,
                            type: "bar",
                            dropShadow: {
                                enabled: true,
                                top: 10,
                                left: 10,
                                blur: 10,
                                opacity: 0.15,
                                color: '#000'
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: colors,
                        plotOptions: {
                            bar: {
                                columnWidth: "45%",
                                distributed: true,
                                borderRadius: 5,  // Bordes redondeados para mejorar el aspecto
                                dataLabels: {
                                    position: "top"
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false,
                            style: {
                                fontSize: '14px',
                                colors: ["#fff"]
                            }
                        },
                        series: [{
                            data: ticketsResueltos  // Valores de los tickets resueltos
                        }],
                        xaxis: {
                            categories: nombres, // Nombres de los usuarios
                            labels: {
                                style: {
                                    colors: colors,
                                    fontSize: "14px"
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    return value;
                                }
                            }
                        },
                        /*legend: {
                            offsetY: 7
                        },
                        grid: {
                            row: {
                                colors: ["transparent", "transparent"],
                                opacity: 0.2
                            },
                            borderColor: "#f1f3fa"
                        }***
                        grid: {
                            borderColor: "#f1f3fa"
                        },
                        tooltip: {
                            theme: "dark"
                        },
                        title: {
                            text: 'Tickets Resueltos por Usuario',
                            align: 'center'
                        }
                    };

                    var chart = new ApexCharts(document.querySelector("#cantTikectResultadosPorUsuario"), options);
                    chart.render();
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

        function cantTikectResultadosPorUsuario(mes, anio) {
            $.ajax({
                url: '{{ route('cantticketsResueltosUsu') }}',
                method: 'GET',
                data: { mes: mes, anio: anio }, // Enviar los filtros al backend
                success: function(data) {
                    var nombres = [];
                    var ticketsResueltos = [];

                    data.TikectResultadosPorUsuario.forEach(function(usuario) {
                        nombres.push(usuario.nombre_completo);
                        ticketsResueltos.push(usuario.tickets_resueltos);
                    });

                    var colors = ["#727cf5", "#6c757d", "#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#e3eaef", "#313a46"];
                    var options = {
                        chart: {
                            height: 450,
                            type: "bar",
                            dropShadow: {
                                enabled: true,
                                top: 10,
                                left: 10,
                                blur: 10,
                                opacity: 0.15,
                                color: '#000'
                            },
                            toolbar: {
                                show: false
                            }
                        },
                        colors: colors,
                        plotOptions: {
                            bar: {
                                columnWidth: "45%",
                                distributed: true,
                                borderRadius: 5,
                                dataLabels: {
                                    position: "top"
                                }
                            }
                        },
                        dataLabels: {
                            enabled: false,
                            style: {
                                fontSize: '14px',
                                colors: ["#fff"]
                            }
                        },
                        series: [{
                            data: ticketsResueltos
                        }],
                        xaxis: {
                            categories: nombres,
                            labels: {
                                style: {
                                    colors: colors,
                                    fontSize: "14px"
                                }
                            }
                        },
                        yaxis: {
                            labels: {
                                formatter: function (value) {
                                    return value;
                                }
                            }
                        },
                        grid: {
                            borderColor: "#f1f3fa"
                        },
                        tooltip: {
                            theme: "dark"
                        },
                        title: {
                            text: 'Tickets Resueltos por Usuario',
                            align: 'center'
                        }
                    };

                    $("#cantTikectResultadosPorUsuario").html(""); // Limpiar el contenedor antes de renderizar
                    var chart = new ApexCharts(document.querySelector("#cantTikectResultadosPorUsuario"), options);
                    chart.render();
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
        }



        function mostrarTicketsPorDia() {
            $.ajax({
                url: '{{ route('ticketsCreadosPorDiaDelMesActual') }}', // Asegúrate de tener la ruta correcta
                method: 'GET',
                success: function(data) {
                    if (data.code === 200) {
                        const fechas = data.data.map(ticket => ticket.fecha);
                        const totalTickets = data.data.map(ticket => ticket.total_tickets);

                        // Configuración del gráfico con ApexCharts
                        var options = {
                            chart: {
                                height: 380,
                                type: 'line', // Tipo de gráfico de líneas
                                toolbar: {
                                    show: false
                                }
                            },
                            title: {
                                text: 'Número de Tickets Creados por Día',
                                align: 'left'
                            },
                            dataLabels: {
                                enabled: true // Mostrar etiquetas de datos
                            },
                            stroke: {
                                curve: 'smooth' // Hacer la línea suave
                            },
                            series: [{
                                name: 'Tickets',
                                data: totalTickets
                            }],
                            xaxis: {
                                categories: fechas, // Días del mes
                                title: {
                                    text: 'Días del Mes'
                                }
                            },
                            yaxis: {
                                title: {
                                    text: 'Número de Tickets'
                                }
                            },
                            grid: {
                                borderColor: '#f1f1f1'
                            },
                            tooltip: {
                                x: {
                                    format: 'dd/MM' // Formato de tooltip para las fechas
                                }
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#ticketsPorDia"), options);
                        chart.render();
                    }
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
        }

        function mostrarGraficoTopOficinas() {
            $.ajax({
                url: '{{ route('top5OficinasConMasSolicitudes') }}',
                method: 'GET',
                success: function(data) {
                    if (data.code === 200) {
                        const nombresOficinas = data.data.map(oficina => oficina.nombre);
                        const totalSolicitudes = data.data.map(oficina => oficina.total_solicitudes);

                        // Configurar el gráfico de torta para oficinas
                        var options = {
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            series: totalSolicitudes,
                            labels: nombresOficinas,
                            title: {
                                text: 'Top 5 Oficinas con Más Solicitudes',
                                align: 'center'
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#graficoTopOficinas"), options);
                        chart.render();
                    }
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
        }

        // Función para mostrar el gráfico de problemas (soportes)
        function mostrarGraficoTopProblemas() {
            $.ajax({
                url: '{{ route('top5ProblemasMasComunes') }}',
                method: 'GET',
                success: function(data) {
                    if (data.code === 200) {
                        const nombresProblemas = data.data.map(soporte => soporte.nombre);
                        const totalProblemas = data.data.map(soporte => soporte.total_problemas);

                        // Configurar el gráfico de torta para problemas
                        var options = {
                            chart: {
                                type: 'pie',
                                height: 350
                            },
                            series: totalProblemas,
                            labels: nombresProblemas,
                            title: {
                                text: 'Top 5 Problemas más Comunes',
                                align: 'center'
                            }
                        };

                        var chart = new ApexCharts(document.querySelector("#graficoTopProblemas"), options);
                        chart.render();
                    }
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
        }

    </script>

    @include('admin.dashboard.filtroTabla')

   <script src="{{ url('assets/js/vendor/apexcharts.min.js') }}"></script>

    {{-- JS Tabla --}}

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

    <script src="{{ url('assets/js/pages/demo.datatable-init.js') }}"></script>

    <script src="{{ url('assets/js/pages/demo.timepicker.js') }}"></script> 


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script> <!-- Para Excel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script> <!-- Fuentes para PDF -->

@endsection
