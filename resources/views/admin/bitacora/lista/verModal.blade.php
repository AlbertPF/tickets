<!-- Modal -->
<div id="modal-actividad-ver" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-primary">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-clipboard-list font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal">Ver mi Actividad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="tab-content">

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Detalle de mi Actividad :</h5>

                                    <div class="row">
                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Nombre</p>
                                            <div class="d-flex">
                                                <i
                                                    class='mdi mdi-badge-account-horizontal-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 nombre">---</h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->
    
                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Paterno</p>
                                            <div class="d-flex">
                                                <i
                                                    class='mdi mdi-account-box-multiple-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 apPaterno">---</h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->
    
                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Materno</p>
                                            <div class="d-flex">
                                                <i
                                                    class='mdi mdi-account-box-multiple-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 apMaterno">---</h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->
                                        
                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Actividad :</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-file-sign font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 actividad"></h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Documento Referencial :</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-file-document font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 doc_ref"></h5>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Estado :</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                {{-- <i class='mdi mdi-file-document font-18 text-info me-1'></i> --}}
                                                <div class="estado" style="margin: 5px 0;"></div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Registro:</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-calendar-month font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 fecha_reg"></h5>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <i class='mdi mdi-clock-time-seven-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h4 class="mt-1 font-14 hora_reg"></h4>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                        <div class="col-8">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Descripción :</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                {{-- <i class='mdi mdi-office-building font-18 text-primary me-1'></i> --}}
                                                <div>
                                                    <h5 class="mt-1 font-14 descripcion"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Documento de Atención :</p>
                                            <div class="d-flex">
                                                {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                <i class='mdi mdi-file-document-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 doc_aten"></h5>
                                                </div>
                                            </div>
                                            <!-- end assignee -->
                                        </div> <!-- end col -->

                                        <div class="col-4">
                                            <!-- assignee -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Oficina :</p>
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
                                            <!-- start due date -->
                                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha Atención :</p>
                                            <div class="d-flex">
                                                <i class='mdi mdi-calendar-month font-18 text-primary me-1'></i>
                                                <div>
                                                    <h5 class="mt-1 font-14 fecha_aten"></h5>
                                                </div>
                                            </div>
                                            <div class="d-flex">
                                                <i class='mdi mdi-clock-time-seven-outline font-18 text-primary me-1'></i>
                                                <div>
                                                    <h4 class="mt-1 font-14 hora_aten"></h4>
                                                </div>
                                            </div>
                                            <!-- end due date -->
                                        </div> <!-- end col -->

                                    </div> <!-- end row -->

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
    function ver_actividad() {
        $("#alternative-page-datatable tbody").on('click', '.ver_actividad', function() {
            let id_bitacora = $(this).attr('data-id-actividad');
            //console.log(id_bitacora);

            $.ajax({
                type: 'GET',
                url: '{{ route('ver.listActividades') }}',
                data: {
                    id_bitacora: id_bitacora,
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
                    $('#modal-actividad-ver').modal('show');
                    verDataListActividad(data);

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

    function verDataListActividad(data) {
        
        $(".nombre").html(data.ListBitacora.usuario.nombre || ' ');
        $(".apPaterno").html(data.ListBitacora.usuario.apellidoPaterno || '');
        $(".apMaterno").html(data.ListBitacora.usuario.apellidoMaterno || ' ');
        $(".actividad").html(data.ListBitacora.actividad || ' ');
        $(".doc_ref").html(data.ListBitacora.doc_ref || ' ');
        $('.estado').html(`
            <h5 style="margin: 0px 0 !important;">
                <span class="badge ${data.ListBitacora.estado_clase}">
                    <i class="mdi mdi-check-circle-outline"></i> ${data.ListBitacora.estado_nombre}
                </span>
            </h5>
        `);
        $('.fecha_reg').html(formatDate(data.ListBitacora.fecha_reg)); 
        $('.hora_reg').html(formatTime(data.ListBitacora.fecha_reg)); 
        $(".descripcion").html(data.ListBitacora.descripcion || ' ');
        $(".doc_aten").html(data.ListBitacora.doc_aten || ' ');
        $(".oficina").html(data.ListBitacora.oficina ? data.ListBitacora.oficina.nombre : " "); 
        $('.fecha_aten').html(formatDate(data.ListBitacora.fecha_aten)); 
        $('.hora_aten').html(formatTime(data.ListBitacora.fecha_aten)); 
        
    }
</script>