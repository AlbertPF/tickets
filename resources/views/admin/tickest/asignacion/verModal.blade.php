<!-- Modal -->
<div id="modal-asignacionT-ver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
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
                <h4 class="modal-title" id="title_modal">Ver Asiganación</h4>
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

                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Observación del personal de Soporte Técnico:</h5>

                                    <div class="row">
                                        <div class="col-6">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Asignación:</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-calendar-month font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 fecha_asignacion"></h5>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <i class='mdi mdi-clock-time-seven-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h4 class="mt-1 font-14 hora_asignacion"></h4>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-6">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Finalización:</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-calendar-month font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 fecha_finalizacion">---</h5>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <i class='mdi mdi-clock-time-seven-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h4 class="mt-1 font-14 hora_finalizacion">---</h4>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                    </div> <!-- end row -->

                                    <h5 class="mt-3">Descripción:</h5>

                                    <p class="text-muted mb-4 descripcionUsuarioInf">
                                        ---
                                    </p>

                                    <button class="btn btn-outline-primary generar-pdf" onclick="generar_pdf()">
                                        <i class="mdi mdi-file-download"></i> Generar PDF
                                    </button>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                    </div>
                    <!-- end row-->

                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cerrar</button>
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

    function ver_AsigTickets() {
        $("#selection-datatable tbody").on('click', '.ver_ticketAsig', function() {
            let id_Asigticket = $(this).attr('data-id-ticketAsig');
            //console.log(id_archivo);

            $.ajax({
                type: 'GET',
                url: '{{ route('ver.ticketsAsig') }}',
                data: {
                    id_Asigticket: id_Asigticket,
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
                    //console.log(data.tickets);
                    $('#modal-asignacionT-ver').modal('show');
                    verDataAsigTickets(data);

                }
            });
        });
    }

    function formatDate(dateString) {
        if (!dateString) { 
            return null;
        }
        let date = new Date(dateString);
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2);
        let day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function formatTime(dateString) {
        if (!dateString) {
            return null;
        }
        let date = new Date(dateString);
        let hours = ('0' + date.getHours()).slice(-2);  // Obtener horas con dos dígitos
        let minutes = ('0' + date.getMinutes()).slice(-2);  // Obtener minutos con dos dígitos
        return `${hours}:${minutes}`;
    }

    function verDataAsigTickets(data) {
        // Asegúrate de que estás accediendo a los datos correctos
        $('.codigo').html(data.tickets.ticket.id_ticket);
        $('.personal').html(data.tickets.ticket.oficina_personal.personal.nombre);
        $('.apePaterno').html(data.tickets.ticket.oficina_personal.personal.apellidoPaterno);
        $('.apeMaterno').html(data.tickets.ticket.oficina_personal.personal.apellidoMaterno);
        $('.oficina').html(data.tickets.ticket.oficina_personal.oficina.nombre); 
        $('.incidencia').html(data.tickets.ticket.soporte.nombre);
        $('.descripcion').html(data.tickets.ticket.descripcion);
        $('.fecha_env').html(formatDate(data.tickets.ticket.fecha_env)); 
        $('.hora_env').html(formatTime(data.tickets.ticket.fecha_env)); 
        $('.telefono').html(data.tickets.ticket.oficina_personal.personal.telefono);
        $('.estado').html(`
            <h5 style="margin: 0px 0 !important;">
                <span class="badge ${data.tickets.ticket.estado_clase}">
                    <i class="mdi mdi-check-circle-outline"></i> ${data.tickets.ticket.estado_nombre}
                </span>
            </h5>
        `);

        $('.fecha_asignacion').html(formatDate(data.tickets.fecha_asig));
        $('.hora_asignacion').html(formatTime(data.tickets.fecha_asig));
        $('.fecha_finalizacion').html(formatDate(data.tickets.fecha_fin));
        $('.hora_finalizacion').html(formatTime(data.tickets.fecha_fin));
        $('.descripcionUsuarioInf').html(data.tickets.descripcion);
        $('.generar-pdf').data('id', data.tickets.id_Asigticket );
    }

    function generar_pdf() {
        const id_Asigticket = $('.generar-pdf').data('id');
        if (!id_Asigticket) {
            Swal.fire({
                icon: "error",
                title: "ID no encontrado",
                text: "No se pudo obtener el ID de la asignación.",
            });
            return;
        }

        $.ajax({
            type: 'GET',
            url: `ticketsAsig/${id_Asigticket}/pdf`, // Usa ruta absoluta
            xhrFields: {
                responseType: 'blob' // <-- importante para manejar blob (PDF)
            },
            beforeSend: function() {
                Swal.fire({
                    title: 'Generando PDF...',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
            },
            success: function(data) {
                Swal.close(); // Cierra el loading
                const blob = new Blob([data], { type: 'application/pdf' });
                const url = URL.createObjectURL(blob);
                window.open(url, '_blank');
            },
            error: function(xhr) {
                Swal.close();
                let mensaje = "Ocurrió un error.";
                try {
                    const errorJson = JSON.parse(xhr.responseText);
                    mensaje = errorJson.message;
                } catch (e) {}
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: mensaje,
                    footer: '<a href="">Vuelva a intentarlo</a>'
                });
            }
        });
    }

</script>