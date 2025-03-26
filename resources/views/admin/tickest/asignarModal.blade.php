<!-- Modal -->
<div id="modal-ticket-asignar" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-info">
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
            <form id="guardarAsigPerTick">
                @csrf
                <input type="hidden" name="id_tickets_asignar" id="id_tickets_asignar" value="">
                <div class="modal-body">
                    <div class="tab-content">

                        <div class="row">
                            <div class="col-xxl-12 col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Información del Personal:</h5>

                                        <div class="row">
                                            <div class="col-4">
                                                <!-- start due date -->
                                                <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Personal:</p>
                                                <div class="d-flex">
                                                    <i class='mdi mdi-card-account-details font-18 text-info me-1'></i>
                                                    <div>
                                                        <h5 class="mt-1 font-14">
                                                            <p class="personal"></p>
                                                        </h5>
                                                    </div>
                                                </div>
                                                <!-- end due date -->
                                            </div> <!-- end col -->

                                            <div class="col-4">
                                                <!-- assignee -->
                                                <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Oficina:</p>
                                                <div class="d-flex">
                                                    {{-- <img src="assets/images/users/avatar-9.jpg" alt="Arya S" class="rounded-circle me-2" height="24" /> --}}
                                                    <i class='mdi mdi-office-building font-18 text-info me-1'></i>
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
                                                    <i class='mdi mdi-cpu-64-bit font-18 text-info me-1'></i>
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
                                                    <i class='mdi mdi-calendar-month font-18 text-info me-1'></i>
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
                                                    <i class='mdi mdi-clock-time-seven-outline font-18 text-info me-1'></i>
                                                    <div>
                                                        <h5 class="mt-1 font-14 hora_env"></h5>
                                                    </div>
                                                </div>
                                                <!-- end assignee -->
                                            </div> <!-- end col -->

                                        </div> <!-- end row -->
                                        <h5 class="mt-3">Descripción:</h5>

                                        <p class="text-muted mb-4 descripcion">
                                            ---
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xxl-12 col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Seleccionar Usuario de Informática:</h5>
                                        <div class="tab-pane show active" id="custom-styles-preview">
                                            <div class="row">
                
                                                <div class="col-xl-6 col-lg-12">
                                                    <div class="mb-3 form-group">
                                                        <label class="form-label">Usuario Informático :</label>
                                                        <select class="form-control" id="selectUsuario" name="id_usuario" data-toggle="select2" title="Usuarios Informáticos">
                                                            <option value="" disabled selected>Seleccionar Usuario</option>
                                                            <!-- Las opciones serán llenadas dinámicamente -->
                                                        </select>
                                                    </div> <!-- end col -->
                                                </div>
                                            </div>
                                        </div> <!-- end preview-->
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-info" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btnGuardar" type="submit" class="btn btn-info">Asignar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {

        $('#modal-ticket-asignar').on('shown.bs.modal', function() {
            $('select[data-toggle="select2"]').select2({
                dropdownParent: $('#modal-ticket-asignar'),
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                },
            });

                // Llama a listar_usuario para vaciar y cargar el select cada vez que se abre el modal
            listar_usuario();
        });

        $('#guardarAsigPerTick').validate({
            rules: {
                id_ticket: {
                    required: true,
                },
                id_usuario: {
                    required: true,
                }
            },
            messages: {
                id_ticket: {
                    required: "El ticket es obligatorio.",
                },
                id_usuario: {
                    required: "El usuario es obligatorio.",
                }
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                if (element.closest('.input-group').length) {
                    element.closest('.input-group').append(error);
                } else {
                    element.after(error);
                }
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form) {
                Asignar_ticketsUsuario(); // Llamar a la función para registrar el usuario
            }
        });

        //listar_usuario();

    });

    function AsignarModal_tickets() {
        $("#alternative-page-datatable tbody").on('click', '.ModalAsignar_tickets', function() {
            let id_ticket = $(this).attr('data-id-ticket');
            //console.log(id_ticket);

            $.ajax({
                type: 'GET',
                url: '{{ route('modalAsignar.tickets') }}',
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

                    let Asig = data.tickets;

                    $('#id_tickets_asignar').val(Asig.id_ticket);

                    $('#modal-ticket-asignar').modal('show');
                    verDataAsigTickets2(data);

                }
            });
        });
    }

    function formatDate01(dateString) {
        let date = new Date(dateString);
        let year = date.getFullYear();
        let month = ('0' + (date.getMonth() + 1)).slice(-2);
        let day = ('0' + date.getDate()).slice(-2);
        return `${year}-${month}-${day}`;
    }

    function formatTime01(dateString) {
        let date = new Date(dateString);
        let hours = ('0' + date.getHours()).slice(-2);  // Obtener horas con dos dígitos
        let minutes = ('0' + date.getMinutes()).slice(-2);  // Obtener minutos con dos dígitos
        return `${hours}:${minutes}`;
    }

    function verDataAsigTickets2(data) {
        codTickets = data.tickets.id_ticket;
        $('.personal').html(data.tickets.oficina_personal.personal.nombre + ' '+ data.tickets.oficina_personal.personal.apellidoPaterno +' '+ data.tickets.oficina_personal.personal.apellidoMaterno);
        // $('.apePaterno').html(data.tickets.oficina_personal.personal.apellidoPaterno);
        // $('.apeMaterno').html(data.tickets.oficina_personal.personal.apellidoMaterno);
        $('.oficina').html(data.tickets.oficina_personal.oficina.nombre);
        $('.incidencia').html(data.tickets.soporte.nombre);
        $('.descripcion').html(data.tickets.descripcion);
        $('.fecha_env').html(formatDate01(data.tickets.fecha_env));
        $('.hora_env').html(formatTime01(data.tickets.fecha_env));
        $('.estado').html(`
            <h5 style="margin: 0px 0 !important;">
                <span class="badge ${data.tickets.estado_clase}">
                    <i class="mdi mdi-check-circle-outline"></i> ${data.tickets.estado_nombre}
                </span>
            </h5>
        `);
    }

    function Asignar_ticketsUsuario() {
        //console.log('registrar usuario');
        Swal.fire({
            title: "¿Esta seguro?",
            icon: "warning",
            text: "Verifique los datos antes de enviar",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            canselButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                let token = $('meta[name="csrf-token"]').attr('content');
                let formElement = document.getElementById("guardarAsigPerTick");
                let formData = new FormData(formElement);
                return fetch('{{ route('asignar.ticketsAsig') }}', {
                    method: "POST",
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': token
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
                    /*Swal.showValidationMessage(
                        `Error: ${mensaje}`
                    )*/

                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: mensaje,
                        timer: 3000,
                        showConfirmButton: false,
                        timerProgressBar: true
                    });
                    return false; 

                });
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            /* Read more about isConfirmed, isDenied below */
            if (result.isConfirmed) {
                Swal.fire({
                    title: "Atención!",
                    icon: "success",
                    text: result.value.message,
                    confirmButtonText: 'ok',
                    timer: 2000,
                    timerProgressBar: true,
                    didOpen: () => {
                        Swal.showLoading();
                        //const timer = Swal.getPopup().querySelector("b");
                        timerInterval = setInterval(() => {
                            //timer.textContent = `${Swal.getTimerLeft()}`;
                        }, 100);
                    },
                    willClose: () => {
                        clearInterval(timerInterval);
                    }
                }).then((confirmar) => {
                    if (confirmar.isConfirmed || confirmar.dismiss === Swal.DismissReason.timer) {
                        $('#guardarAsigPerTick')[0].reset();
                        $('#modal-ticket-asignar').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function listar_usuario() {
        $.ajax({
            type: 'POST',
            url: '{{ route('dashListaUsuario') }}',
            dataType: 'json',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let usuarios = data.usuarios;
                    let select = $('#selectUsuario'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Usuarios</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    usuarios.forEach(function(usuario) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = usuario.nombreCompleto;
                        select.append(
                            $('<option></option>')
                            .val(usuario.id_usuario)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar usuario:', data);
            }
        });
    }
</script>