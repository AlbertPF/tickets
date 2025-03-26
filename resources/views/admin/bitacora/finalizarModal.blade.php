<!-- Modal -->
<div id="modal-actividad-fin" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
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
                <h4 class="modal-title" id="title_modal">Finalizar Actividad</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="finalizarAtencion">
                <input type="hidden" name="id_actividad_finalizar" id="id_actividad_finalizar">
                <div class="modal-body">
                    <div class="tab-content">
    
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Detalle de mi Actividad :</h5>
    
                                        <div class="row">
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
                                                <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Documento Refecial :</p>
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
                                                <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Documneto de Atención :</p>
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
    
                                        </div> <!-- end row -->
    
                                    </div> <!-- end card-body-->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
    
                        </div>
                        <!-- end row-->
    
                        <div class="col-xl-12">
                            <div class="card">
                                <div class="card-body">
    
                                    <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Finalizar atención :</h5>
    
                                    <div class="row">
                                        <div class="col-xl-8 col-lg-8">
                                            <div class="mb-3 form-group">
                                                <label class="form-label">Documento Atención :</label>
                                                <input type="text" class="form-control" id="doc_aten" name="doc_aten" placeholder="Ingrese documento atención">
                                            </div>
                                        </div>
    
                                    </div> <!-- end row -->
                                    
                                </div>
                            </div>    
                        </div>
    
                    </div>
                </div>
    
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardar" type="submit" class="btn btn-primary">Finalizar</button>
                </div>
            </form>
            
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>

    function ver_fin_actividad() {
        $("#alternative-page-datatable tbody").on('click', '.finalizar_actividad', function() {
            let id_bitacora = $(this).attr('data-id-actividad');
            $("#id_actividad_finalizar").val(id_bitacora);
            //console.log(id_bitacora);

            $.ajax({
                type: 'GET',
                url: '{{ route('ver.actividad') }}',
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
                    $('#modal-actividad-fin').modal('show');
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
    console.log(data.bitacora.id_bitacora);
    
        $('.actividad').html(data.bitacora.actividad ? data.bitacora.actividad.nombre : " ");
        $('.doc_ref').html(data.bitacora.doc_ref);
        $('.estado').html(`
            <h5 style="margin: 0px 0 !important;">
                <span class="badge ${data.bitacora.estado_clase}">
                    <i class="mdi mdi-check-circle-outline"></i> ${data.bitacora.estado_nombre}
                </span>
            </h5>
        `);
        $('.fecha_reg').html(formatDate(data.bitacora.fecha_reg)); 
        $('.hora_reg').html(formatTime(data.bitacora.fecha_reg)); 
        $('.descripcion').html(data.bitacora.descripcion);
        $('.doc_aten').html(data.bitacora.doc_aten);
        $('.oficina').html(data.bitacora.oficina ? data.bitacora.oficina.nombre : " "); 
        $('.fecha_aten').html(formatDate(data.bitacora.fecha_aten)); 
        $('.hora_aten').html(formatTime(data.bitacora.fecha_aten)); 
        //$(".id_actividad_finalizar").val(data.bitacora.id_bitacora);
        
    }
</script>

<script>

    function finalizar_actividad() {
        $(".finalizarAtencion").on("submit", function(event) {
            event.preventDefault();

            Swal.fire({
                title: "¿Está seguro?",
                icon: "warning",
                text: "Verifique los datos antes de enviar",
                showCancelButton: true,
                confirmButtonText: "Sí, estoy seguro",
                cancelButtonText: "Cancelar",
                showLoaderOnConfirm: true,
                preConfirm: () => {
                    let token = $('meta[name="csrf-token"]').attr('content');
                    let formElement = document.querySelector(".finalizarAtencion");
                    let formData = new FormData(formElement);

                    return fetch('{{ route('finalizar.actividad') }}', {
                        method: "POST",
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'X-CSRF-TOKEN': token
                        }
                    }).then(response => {
                        if (!response.ok) {
                            return response.text().then(text => { throw new Error(text) })
                        } else {
                            return response.json()
                        }
                    }).catch(response => {
                        let texto = JSON.parse(response.toString().substring(7));
                        let mensaje = texto.message;

                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: mensaje,
                            timer: 2000,
                            showConfirmButton: false,
                            timerProgressBar: true
                        });
                        return false; 
                    });
                },
                allowOutsideClick: () => !Swal.isLoading()
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: "Atención!",
                        icon: "success",
                        text: result.value.message,
                        confirmButtonText: 'OK',
                        timer: 2000,
                        timerProgressBar: true
                    }).then(() => {
                        $('#modal-actividad-fin').modal('hide');
                        mostrar_tabla(); // Recargar la tabla
                    });
                }
            });
        });
    }

</script>