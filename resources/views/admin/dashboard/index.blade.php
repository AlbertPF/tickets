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
    <style>
        .dashboard-range-card {
            border: 0;
            box-shadow: 0 8px 24px rgba(49, 58, 70, .08);
        }

        .dashboard-range-summary {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            gap: .45rem;
            padding: .5rem .85rem;
            border-radius: 999px;
            background: rgba(57, 175, 209, .12);
            color: #247b96;
            font-weight: 600;
        }

    </style>
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
        <div class="col-12">
            <div class="card dashboard-range-card">
                <div class="card-body">
                    <div class="row g-3 align-items-end">
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label" for="fecha_inicio">Desde</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-calendar-start"></i></span>
                                <input type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6">
                            <label class="form-label" for="fecha_fin">Hasta</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="mdi mdi-calendar-end"></i></span>
                                <input type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-6 d-grid gap-2 d-md-flex">
                            <button type="button" class="btn btn-info flex-grow-1" id="aplicar-rango-dashboard">
                                <i class="mdi mdi-filter-check me-1"></i>Aplicar rango
                            </button>
                            <button type="button" class="btn btn-light" id="rango-mes-actual"
                                title="Restablecer al mes actual">
                                <i class="mdi mdi-calendar-today"></i>
                            </button>
                        </div>
                        <div class="col-lg-3 col-md-6 text-lg-end">
                            <span class="dashboard-range-summary" id="dashboard-range-summary" aria-live="polite">
                                <i class="mdi mdi-calendar-range"></i>
                                <span>Mes actual</span>
                            </span>
                        </div>
                    </div>
                    <small class="text-muted d-block mt-2">
                        El rango se aplica a tarjetas, gráficos, métricas y asignaciones.
                    </small>
                </div>
            </div>
        </div>
    </div>

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
                                        <h3><i class="mdi mdi-file-document text-info"></i><span class="registrados"
                                                style="color: var(--ct-body-color);">0</span></h3>
                                        <p class="text-muted font-15 mb-0">Tickets Pendientes</p>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-checklist text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-check-circle-outline text-success"></i><span
                                            class="atendidos">0</span></h3>
                                    <p class="text-muted font-15 mb-0">Tickets Atendidos</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-user-group text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-progress-clock text-warning"></i><span class="proceso">0</span>
                                    </h3>
                                    <p class="text-muted font-15 mb-0">Tickets en Proceso</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6 col-lg-2">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    {{-- <i class="dripicons-graph-line text-muted" style="font-size: 24px;"></i> --}}
                                    <h3><i class="mdi mdi-close-circle-outline text-secondary"></i><span
                                            class="noAtendidos">0</span></h3>
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
        <div class="col-12">
            <div class="card widget-inline">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <div class="col-sm-6">
                            <div class="card shadow-none m-0">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="mdi mdi-progress-clock text-primary"></i><span
                                            id="tiempo-promedio-resolucion">--:--</span> min
                                    </h3>
                                    <p class="text-muted font-15 mb-0">
                                        Tiempo promedio de Atención de una incidencia
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="card shadow-none m-0 border-start">
                                <div class="card-body text-center">
                                    <h3>
                                        <i class="mdi mdi-progress-clock text-primary"></i><span
                                            id="tiempo-promedio-asignacion">--:--</span> min
                                    </h3>
                                    <p class="text-muted font-15 mb-0">
                                        Tiempo promedio de Asignación de un ticket
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title">Tickets por tipo de soporte</h4>

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
                    <h4 class="header-title">Tickets resueltos por usuario</h4>
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
    @if(Auth::check() && (Auth::user()->tipo === 'Administrador'))
        {{-- metricas-interaccion --}}    
        @include('admin.dashboard.metricas')

        {{-- metricas-notificaciones --}}    
        @include('admin.dashboard.metricasNotificaciones')
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <label class="form-label text-info ">Filtro de Asignación </label>

                    <div class="row">
                        <div class="col-lg-3">
                            <label class="form-label">Usuario Informático :</label>
                            <select class="form-control" id="selectUsuario" name="id_usuario" data-toggle="select2"
                                title="Usuarios Informáticos">
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

                    <div class="row">
                        <div class="col-lg-12">
                            <div class="app-search dropdown d-none d-lg-block">
                                <div class="input-group">
                                    <input type="text" id="buscar" name="buscar" class="form-control"
                                        placeholder="Palabra Clave" aria-label="Buscar">
                                    <span class="mdi mdi-magnify search-icon"></span>
                                    <button class="btn btn-info" id="buscar-btn" type="button">Buscar</button>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->

                    <br>

                    <div class="progress progress-sm">
                        <div class="progress-bar progress-lg bg-info" role="progressbar" aria-valuenow="100"
                            aria-valuemin="0" aria-valuemax="100" style="width: 100%;">
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
        const dashboardCharts = {};

        function formatDashboardDate(date) {
            const year = date.getFullYear();
            const month = String(date.getMonth() + 1).padStart(2, '0');
            const day = String(date.getDate()).padStart(2, '0');

            return `${year}-${month}-${day}`;
        }

        function formatDashboardDuration(seconds) {
            if (seconds === null || seconds === undefined || Number.isNaN(Number(seconds))) {
                return '--:--';
            }

            const totalMinutes = Math.max(0, Math.floor(Number(seconds) / 60));
            const hours = Math.floor(totalMinutes / 60);
            const minutes = totalMinutes % 60;

            return `${String(hours).padStart(2, '0')}:${String(minutes).padStart(2, '0')}`;
        }

        function setCurrentMonthRange() {
            const today = new Date();
            const firstDay = new Date(today.getFullYear(), today.getMonth(), 1);

            $('#fecha_inicio').val(formatDashboardDate(firstDay));
            $('#fecha_fin').val(formatDashboardDate(today));
        }

        window.getDashboardDateRange = function() {
            return {
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val()
            };
        };

        function validateDashboardRange() {
            const range = window.getDashboardDateRange();

            if (!range.fecha_inicio || !range.fecha_fin) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Rango incompleto',
                    text: 'Seleccione una fecha de inicio y una fecha de fin.'
                });

                return false;
            }

            if (range.fecha_fin < range.fecha_inicio) {
                Swal.fire({
                    icon: 'error',
                    title: 'Rango inválido',
                    text: 'La fecha de fin no puede ser anterior a la fecha de inicio.'
                });

                return false;
            }

            return true;
        }

        function updateDashboardRangeSummary() {
            const range = window.getDashboardDateRange();
            const formatter = new Intl.DateTimeFormat('es-PE', {
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            });
            const start = formatter.format(new Date(`${range.fecha_inicio}T00:00:00`));
            const end = formatter.format(new Date(`${range.fecha_fin}T00:00:00`));

            $('#dashboard-range-summary span').text(`${start} - ${end}`);
        }

        window.renderDashboardChart = function(key, selector, options) {
            if (dashboardCharts[key]) {
                dashboardCharts[key].destroy();
            }

            const container = document.querySelector(selector);
            container.innerHTML = '';
            dashboardCharts[key] = new ApexCharts(container, options);
            dashboardCharts[key].render();
        };

        window.refreshDashboard = function() {
            if (!validateDashboardRange()) {
                return;
            }

            updateDashboardRangeSummary();
            CantidadDatos();
            cantidadTicketPorSoporte();
            cantTikectResultadosPorUsuario();
            mostrarTicketsPorDia();
            mostrarGraficoTopOficinas();
            mostrarGraficoTopProblemas();
            aplicarFiltros();

            if (typeof window.loadChatbotMetrics === 'function') {
                window.loadChatbotMetrics();
            }

            if (typeof window.loadNotificationMetrics === 'function') {
                window.loadNotificationMetrics();
            }
        };

        $(document).ready(function() {
            setCurrentMonthRange();

            listar_personal();
            listar_usuario();
            listar_incidencia();
            listar_oficina();

            window.refreshDashboard();

            $('#aplicar-rango-dashboard').on('click', window.refreshDashboard);
            $('#rango-mes-actual').on('click', function() {
                setCurrentMonthRange();
                window.refreshDashboard();
            });


            $('#buscar-btn').click(function() {
                var query = $('#buscar').val(); // Obtener el valor del campo de búsqueda

                $.ajax({
                    url: '{{ route('dashBuscar.pCalve') }}', // La ruta del controlador para manejar la búsqueda
                    type: 'GET',
                    data: Object.assign({
                        buscar: query
                    }, window.getDashboardDateRange()),
                    beforeSend: function() {
                        var spinner =
                            `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
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

            $('#selectPersonal, #selectUsuario, #selectIncidencia, #selectOficina').on('change', aplicarFiltros);

        });

        function CantidadDatos() {
            $.ajax({
                url: "{{ route('cantidadDatos') }}",
                method: 'GET',
                dataType: 'JSON',
                data: window.getDashboardDateRange(),
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
                    $('#tiempo-promedio-resolucion').text(
                        formatDashboardDuration(data.tiempoPromedioResolucionSegundos)
                    );
                    $('#tiempo-promedio-asignacion').text(
                        formatDashboardDuration(data.tiempoPromedioAsignacionSegundos)
                    );
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

        function cantidadTicketPorSoporte() {
            $.ajax({
                url: '{{ route('cantTicketSoporte') }}',
                method: 'GET',
                data: window.getDashboardDateRange(),
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
                            style: {
                                colors: ["#fff"]
                            },
                            formatter: function(val, opt) {
                                return opt.w.globals.labels[opt.dataPointIndex] + ": " + val;
                            },
                            offsetX: 0,
                            dropShadow: {
                                enabled: false
                            }
                        },
                        series: [{
                            name: 'Tickets',
                            data: ticketCounts
                        }],
                        stroke: {
                            width: 2,
                            colors: ["#fff"]
                        },
                        xaxis: {
                            categories: soporteNames
                        },
                        yaxis: {
                            labels: {
                                show: false
                            }
                        },
                        grid: {
                            borderColor: "#f1f3fa"
                        },
                        tooltip: {
                            theme: "dark", // Tema oscuro para el tooltip
                            x: {
                                show: false // Ocultar nombres en el tooltip
                            },
                            y: {
                                title: {
                                    formatter: function() {
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

                    window.renderDashboardChart('tickets-soporte', '#cantTicketPorSoporte', options);
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

        function cantTikectResultadosPorUsuario() {
            $.ajax({
                url: '{{ route('cantticketsResueltosUsu') }}',
                method: 'GET',
                data: window.getDashboardDateRange(),
                success: function(data) {
                    var nombres = [];
                    var ticketsResueltos = [];

                    data.TikectResultadosPorUsuario.forEach(function(usuario) {
                        nombres.push(usuario.nombre_completo);
                        ticketsResueltos.push(usuario.tickets_resueltos);
                    });

                    var colors = ["#727cf5", "#6c757d", "#0acf97", "#fa5c7c", "#ffbc00", "#39afd1", "#e3eaef",
                        "#313a46"
                    ];
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
                                formatter: function(value) {
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

                    window.renderDashboardChart(
                        'tickets-usuario',
                        '#cantTikectResultadosPorUsuario',
                        options
                    );
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
                data: window.getDashboardDateRange(),
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
                                text: 'Tickets creados por día en el período',
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
                                    text: 'Fecha'
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

                        window.renderDashboardChart('tickets-dia', '#ticketsPorDia', options);
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
                data: window.getDashboardDateRange(),
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
                            },
                            legend: {
                                position: 'right',
                                floating: false,
                                fontSize: '14px',
                                labels: {
                                    useSeriesColors: false
                                },
                                formatter: function(seriesName) {
                                    // Forzar salto de línea en nombres largos cada 25 caracteres aprox.
                                    return seriesName.match(/.{1,25}/g).join('<br>');
                                },
                                itemMargin: {
                                    vertical: 5
                                }
                            },
                            responsive: [{
                                breakpoint: 768,
                                options: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };

                        window.renderDashboardChart('top-oficinas', '#graficoTopOficinas', options);
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
                data: window.getDashboardDateRange(),
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
                            },
                            legend: {
                                position: 'right',
                                floating: false,
                                fontSize: '14px',
                                labels: {
                                    useSeriesColors: false
                                },
                                formatter: function(seriesName) {
                                    // Forzar salto de línea en nombres largos cada 25 caracteres aprox.
                                    return seriesName.match(/.{1,25}/g).join('<br>');
                                },
                                itemMargin: {
                                    vertical: 5
                                }
                            },
                            responsive: [{
                                breakpoint: 768,
                                options: {
                                    legend: {
                                        position: 'bottom'
                                    }
                                }
                            }]
                        };

                        window.renderDashboardChart('top-problemas', '#graficoTopProblemas', options);
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
