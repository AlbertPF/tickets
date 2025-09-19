<!-- Modal -->
<div id="modal-ticket-ver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-primary">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-file-document font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal">Ver Ticket</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">

                                    <div class="row">
                                        <h5 class="text-muted fw-normal mt-2 text-truncate" title="Campaign Sent">Información del Personal:</h5>
                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Nombre:</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-card-account-details font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 personal"></h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Paterno:</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-card-account-details-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 apePaterno"></h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Materno</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-card-account-details-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 apeMaterno"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <h5 class="text-muted fw-normal mt-4 text-truncate" title="Campaign Sent">Información del Ticket:</h5>

                                        <div class="col-12">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Código de Ticket:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-ticket-confirmation font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 codigo"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Oficina:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-office-building font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 oficina"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Incidencia:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-cpu-64-bit font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 incidencia"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Estado:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                {{-- <i class='mdi mdi-file-document font-18 text-info me-1'></i> --}}
                                                <div class="estado" style="margin: 5px 0;"></div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Envío:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-calendar-month font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 fecha_env"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Hora Envío:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-clock-time-seven-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 hora_env"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">N° Telefónico:</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-cellphone font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 telefono"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                    </div> <!-- end row -->

                                    <h5 class="mt-3">Descripción:</h5>

                                    <p class="text-muted mb-4 descripcion">
                                        ---
                                    </p>


                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div>
                    <!-- end row-->

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary descargar-pdf" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    /*$(document).ready(function() {
        $('#modal-archivo-ver').on('shown.bs.modal', function() {
            $('#input-element')
        .focus(); // Reemplaza #input-element con el selector del campo que quieres enfocar
        });
    });*/

    function ver_tickets() {
        $("#alternative-page-datatable tbody").on('click', '.ver_tickets', function() {
            let id_ticket = $(this).attr('data-id-ticket');
            //console.log(id_ticket);

            $.ajax({
                type: 'GET',
                url: '{{ route('ver.tickets') }}',
                data: {
                    id_ticket: id_ticket,
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
                    //console.log(data);
                    $('#modal-ticket-ver').modal('show');
                    verDataTickets(data);

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

    function formatTime(dateString) {
        let date = new Date(dateString);
        let hours = ('0' + date.getHours()).slice(-2);  // Obtener horas con dos dígitos
        let minutes = ('0' + date.getMinutes()).slice(-2);  // Obtener minutos con dos dígitos
        return `${hours}:${minutes}`;
    }

    function verDataTickets(data) {
        codTickets = data.tickets.id_ticket;
        $('.codigo').html(data.tickets.id_ticket);
        $('.personal').html(data.tickets.oficina_personal.personal.nombre);
        $('.apePaterno').html(data.tickets.oficina_personal.personal.apellidoPaterno);
        $('.apeMaterno').html(data.tickets.oficina_personal.personal.apellidoMaterno);
        $('.oficina').html(data.tickets.oficina_personal.oficina.nombre);
        $('.incidencia').html(data.tickets.soporte.nombre);
        $('.descripcion').html(data.tickets.descripcion);
        $('.fecha_env').html(formatDate(data.tickets.fecha_env));
        $('.hora_env').html(formatTime(data.tickets.fecha_env));
        $('.telefono').html(data.tickets.oficina_personal.personal.telefono);
        $('.estado').html(`
            <h5 style="margin: 0px 0 !important;">
                <span class="badge ${data.tickets.estado_clase}">
                    <i class="mdi mdi-check-circle-outline"></i> ${data.tickets.estado_nombre}
                </span>
            </h5>
        `);
    }
</script>