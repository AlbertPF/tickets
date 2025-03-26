<!-- Modal -->
<div id="modal-ver-personal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-success">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-account-group font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">
                    <div class="col-xxl-12 col-xl-12">
                        <!-- project card -->
                        <div class="card d-block">
                            <div class="card-body">

                                <h3 class="mt-3">Información del Personal</h3>

                                <div class="row">

                                    <div class="col-3">
                                        <!-- start due date -->
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">DNI</p>
                                        <div class="d-flex">
                                            <i
                                                class='mdi mdi-card-account-details-outline font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 dni">---</h5>
                                            </div>
                                        </div>
                                        <!-- end due date -->
                                    </div> <!-- end col -->

                                    <div class="col-3">
                                        <!-- assignee -->
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Nombre</p>
                                        <div class="d-flex">
                                            <i
                                                class='mdi mdi-badge-account-horizontal-outline font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 nombre">---</h5>
                                            </div>
                                        </div>
                                        <!-- end assignee -->
                                    </div> <!-- end col -->

                                    <div class="col-3">
                                        <!-- start due date -->
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Paterno
                                        </p>
                                        <div class="d-flex">
                                            <i
                                                class='mdi mdi-account-box-multiple-outline font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 apPaterno">---</h5>
                                            </div>
                                        </div>
                                        <!-- end due date -->
                                    </div> <!-- end col -->

                                    <div class="col-3">
                                        <!-- start due date -->
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Materno
                                        </p>
                                        <div class="d-flex">
                                            <i
                                                class='mdi mdi-account-box-multiple-outline font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 apMaterno">---</h5>
                                            </div>
                                        </div>
                                        <!-- end due date -->
                                    </div> <!-- end col -->

                                </div> <!-- end row -->

                                <br>

                                <div class="row">
                                    <div class="col-4">
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Regimen Laboral
                                        </p>
                                        <div class="d-flex">
                                            <i class='mdi mdi-book-open-page-variant font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 rgLaboral">---</h5>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-4">
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Teléfono</p>
                                        <div class="d-flex">

                                            <i class='mdi mdi-cellphone font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 telefono">---</h5>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->

                                    <div class="col-4">
                                        <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Registro
                                        </p>
                                        <div class="d-flex">
                                            <i class='mdi mdi-calendar-month font-18 text-success me-1'></i>
                                            <div>
                                                <h5 class="mt-1 font-14 fecha_reg">---</h5>
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                </div>


                                <h5 class="mt-3">Adicional:</h5>

                                <p class="text-muted mb-2">
                                    Este resumen proporciona información clave sobre el personal seleccionado.
                                    Actualmente, el personal forma parte del régimen <span
                                        class="fw-bold rgLaboral">---</span>, y ha estado registrado desde el <span
                                        class="fw-bold fecha_reg">---</span>.
                                    Este registro ha sido esencial para mantener un control preciso de sus actividades
                                    dentro de la organización.
                                </p>

                            </div> <!-- end card-body-->

                        </div> <!-- end card-->

                        <div class="card">
                            <div class="card-header">
                                {{-- <button type="button" class="btn btn-outline-success">
                                    <i class="mdi mdi-account-convert-outline me-2" data-bs-toggle="modal"
                                        data-bs-target="#modal-asignar-personal"></i> Asignar
                                </button> --}}
                                <h4 class="my-1">Lista de asignación de <span class="nombre">---</span></h4>
                            </div>
                            <div class="card-body">

                                <div class="tab-pane show active" id="alt-pagination-preview">
                                    <div class="table-responsive" id="contenedorAsignacion">

                                    </div>
                                </div> <!-- end preview-->

                            </div> <!-- end card-body-->
                        </div>
                        <!-- end card-->
                    </div> <!-- end col -->
                </div>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {

        $("#alternative-page-datatable tbody").on('click', '.editar_personal', function() {
            let id_personal = $(this).attr('data-id-personal');
            $('#modal-ver-personal').on('shown.bs.modal', function() {

                mostrar_tabla_AsigOP(id_personal);

            });
        });
    });

    function mostrar_tabla_AsigOP(id_personal) {
        $.ajax({
            type: 'POST',
            url: '{{ route('listar.PersonalAsig') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}',
                id_personal: id_personal
            },
            beforeSend: function() {

                var spinner =
                    `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                $("#contenedorAsignacion").html(spinner);

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
                /*//console.log(data.html);
                $("#contenedorAsignacion").html(data.html);
                InicializacionTablaAsig();*/
                $("#contenedorAsignacion").html(data.html);
                setTimeout(function() {
                    InicializacionTablaAsig(); // Inicializa DataTable después de un pequeño retraso
                }, 200); // Espera 200ms
            }
        });
    }

    function InicializacionTablaAsig() {
        if ($.fn.DataTable.isDataTable('#basic-datatable')) {
            // Destruir la tabla existente
            $('#basic-datatable').DataTable().clear().destroy();
        }

        // Reinicializar la tabla
        $("#basic-datatable").DataTable({
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
            order: [[2, 'desc']],
            order: [[4, 'desc']],
            drawCallback: function() {
                $(".dataTables_paginate > .pagination").addClass("pagination-rounded");
            },
            responsive: true,
            scrollX: true
        });
    }

    function ver_personal() {
        $("#alternative-page-datatable tbody").on('click', '.ver_personal', function() {
            let id_personal = $(this).attr('data-id-personal');
            //console.log(id_personal);

            $.ajax({
                type: 'GET',
                url: '{{ route('ver.personal') }}',
                data: {
                    id_personal: id_personal,
                    _token: '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    /*var spinner =
                        `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistros").html(spinner);*/
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
                    //console.log(data.personal);
                    //console.log(data.personal.categoria_nombre);
                    //console.log(data.file);
                    $("#modal-ver-personal").modal('show');
                    verDataPersanal(data);
                    mostrar_tabla_AsigOP(id_personal);
                }
            });
        });
    }

    function formatDate(dateString) {
        let date = new Date(dateString);
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2);
        let day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function verDataPersanal(data) {
        codpersonal = data.personal.id_personal;
        $('.dni').html(data.personal.dni);
        $('.nombre').html(data.personal.nombre);
        $('.apPaterno').html(data.personal.apellidoPaterno);
        $('.apMaterno').html(data.personal.apellidoMaterno);
        $('.rgLaboral').html(data.personal.rlaboral_nombre);
        $('.telefono').html(data.personal.telefono);
        $('.fecha_reg').html(formatDate(data.personal.created_at));

    }
</script>
