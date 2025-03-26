<!-- Modal -->
<div id="modal-nuevo-usuario" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
    aria-hidden="true">
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
            <form id="guardarUsuario">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_usuario_editar" id="id_usuario_editar" value="">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">DNI:</label>
                                        <input type="text" class="form-control" id="dni" name="dni" placeholder="DNI">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Nombres:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombres">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Apellido Paterno:</label>
                                        <input type="text" class="form-control" id="apellidoPaterno" name="apellidoPaterno" placeholder="Apellido Paterno">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Apellido Materno:</label>
                                        <input type="text" class="form-control" id="apellidoMaterno" name="apellidoMaterno" placeholder="Apellido Materno">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Usuario:</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario" placeholder="Usuario">
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label" id="title_Contraseña">Contraseña</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Introduce tu contraseña">
                                            <div class="input-group-text" data-password="false">
                                                <span class="password-eye"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Tipo Usuario:</label>
                                        <select id="tipo" name="tipo" class="form-control" data-toggle="select2" title="Tipo Usuario">
                                            <option value="" disabled selected>Seleccionar Tipo Usuario</option>
                                            <option value="Administrador">Administrador</option>
                                            <option value="Agente Informático">Agente Informático</option>
                                            <option value="Personal">Personal</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Teléfono</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Introduce número telefónico">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end preview-->
                    </div> <!-- end tab-content-->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancelar</button>
                    <button id="btnGuardar" type="submit" class="btn btn-success">Guardar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {

        $('select[data-toggle="select2"]').select2({
            dropdownParent: $('#modal-nuevo-usuario'),
            language: {
                noResults: function() {
                    return "No se encontraron resultados";
                }
            },
            placeholder: "Seleccionar una opción"
        });

        $('.agregar_usuario').click(function() {
            console.log('agregar usuario');
            $("#title_modal").html('Agregar Usuario');
            $("#title_Contraseña").html('Contraseña');
            // Cambia la clase del div con id="modal-header"
            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Guardar');
            // Limpia los campos del formulario
            $('#guardarUsuario')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_usuario_editar").val("");

            $('#modal-nuevo-usuario').on('shown.bs.modal', function() {
                
                
            });
        });

        $('#guardarUsuario').validate({
            rules: {
                dni: {
                    required: true,
                    minlength: 8,
                    maxlength: 8,
                    digits: true
                },
                nombre: {
                    required: true,
                    minlength: 3
                },
                apellidoPaterno: {
                    required: true,
                    minlength: 3
                },
                apellidoMaterno: {
                    required: true,
                    minlength: 3
                },
                usuario: {
                    required: true,
                    minlength: 5
                },
                password: {
                    required: function() {
                        return $("#tipo_formulario").val() == 1; // Requerido solo para agregar
                    },
                    minlength: 8
                },
                tipo: {
                    required: true,
                },
                telefono: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    digits: true
                }
            },
            messages: {
                dni: {
                    required: "El DNI es obligatorio.",
                    minlength: "El DNI debe tener 8 caracteres.",
                    maxlength: "El DNI debe tener 8 caracteres.",
                    digits: "El DNI solo debe contener números."
                },
                nombre: {
                    required: "El nombre es obligatorio.",
                    minlength: "El nombre debe tener al menos 3 caracteres."
                },
                apellidoPaterno: {
                    required: "El apellido paterno es obligatorio.",
                    minlength: "El apellido paterno debe tener al menos 3 caracteres."
                },
                apellidoMaterno: {
                    required: "El apellido materno es obligatorio.",
                    minlength: "El apellido materno debe tener al menos 3 caracteres."
                },
                usuario: {
                    required: "El nombre de usuario es obligatorio.",
                    minlength: "El nombre de usuario debe tener al menos 5 caracteres."
                },
                password: {
                    required: "La contraseña es obligatoria.",
                    minlength: "La contraseña debe tener al menos 8 caracteres."
                },
                tipo: {
                    required: "El tipo de usuario es obligatorio.",
                },
                telefono: {
                    required: "El número telefónico es obligatorio.",
                    minlength: "El número telefónico debe tener 8 caracteres.",
                    maxlength: "El número telefónico debe tener 8 caracteres.",
                    digits: "El número telefónico solo debe contener números."
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
                registrar_usuario(); // Llamar a la función para registrar el usuario
            }
        });
        
    });

    /* Función agregar Usuario*/

    function registrar_usuario() {
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
                let formElement = document.getElementById("guardarUsuario");
                let formData = new FormData(formElement);
                return fetch('{{ route('registrar.usuario') }}', {
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
                        timer: 2000,
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
                        $('#guardarUsuario')[0].reset();
                        $('#modal-nuevo-usuario').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function editar_usuario() {
        $("#alternative-page-datatable tbody").on('click', '.editar_usuario', function() {
            let id_usuario = $(this).attr('data-id-usuario');

            $("#tipo_formulario").val(2);
            $("#id_usuario_editar").val(id_usuario);

            /*console.log(id_usuario);*/
            $.ajax({
                type: 'POST',
                url: '{{ route('editar.usuario') }}',
                data: {
                    id_usuario: id_usuario,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
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
                    //console.log(data.usuario);
                    $("#title_modal").html('Editar Usuario');
                     $("#title_Contraseña").html('Nueva Contraseña');
                    // Cambia la clase del div con id="modal-header"
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');

                    let usuario = data.usuario;

                    $("#dni").val(usuario.dni);
                    $("#nombre").val(usuario.nombre);
                    $("#apellidoPaterno").val(usuario.apellidoPaterno);
                    $("#apellidoMaterno").val(usuario.apellidoMaterno);
                    $("#usuario").val(usuario.usuario);
                    $("#password").val('');
                    $("#tipo").val(usuario.tipo);
                    $("#telefono").val(usuario.telefono);
                    $("#modal-nuevo-usuario").modal('show');

                }
            });
        });
    }
</script>
