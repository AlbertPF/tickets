<!-- Modal -->
<div id="modal-nuevo-personal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel">
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
            <form id="guardarPersonal">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_personal_editar" id="id_personal_editar" value="">
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
                                        <label class="form-label">Teléfono</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Introduce número telefónico">
                                        </div>
                                    </div>
                                </div>

                                <div class="col-xl-2 col-lg-2">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Año</label>
                                        <input type="text" class="form-control date" id="anio" name="anio" placeholder="Año">
                                    </div>
                                </div>

                                <div class="col-xl-4 col-lg-4">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Estado Laboral:</label>
                                        <select id="selectEstado" name="estado" class="form-control" data-toggle="select2" title="Estado Laboral">
                                            <option value="" disabled selected>Seleccionar Estado Laboral</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Regimen Laboral :</label>
                                        <select id="selectPersonal" name="id_rl" data-toggle="select2" title="Regimen Laboral">
                                            <option value="" disabled selected>Seleccionar Regimen Laboral</option>
                                            <!-- Las opciones serán llenadas dinámicamente -->
                                        </select>
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Oficina :</label>
                                        <select id="selectOficina" name="id_oficina" data-toggle="select2" title="Oficina">
                                            <option value="" disabled selected>Seleccionar Oficina Padre</option>
                                            <!-- Las opciones serán llenadas dinámicamente -->
                                        </select>
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

        $('.agregar_personal').click(function() {
            console.log('agregar personal');
            $("#title_modal").html('Agregar Personal');
            // Cambia la clase del div con id="modal-header"
            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Guardar');
            // Limpia los campos del formulario
            $('#guardarPersonal')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_personal_editar").val("");
            
        });

        // Inicializar select2 dentro del modal después de que se haya mostrado
        $('#modal-nuevo-personal').on('shown.bs.modal', function() {
            $('select[data-toggle="select2"]').select2({
                dropdownParent: $('#modal-nuevo-personal'),
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                },
                placeholder: "Seleccionar una opción"
            });

            $('#anio').datepicker({
                format: "yyyy",          
                viewMode: "years",       
                minViewMode: "years",    
                autoclose: true 
            });

            var currentYear = new Date().getFullYear();
            $('#anio').val(currentYear);
                
        });

        $('#guardarPersonal').validate({
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
                id_rl: {
                    required: true,
                },
                telefono: {
                    required: true,
                    minlength: 9,
                    maxlength: 9,
                    digits: true
                },
                anio: {
                    required: true,
                    digits: true,            
                    minlength: 4,            
                    maxlength: 4,            
                    min: 2015,               
                    max: new Date().getFullYear() + 1 
                },
                estado: {
                    required: true,
                },
                id_oficina: {
                    required: true,
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
                id_rl: {
                    required: "Regimen Laboral es obligatorio.",
                },
                telefono: {
                    required: "El número telefónico es obligatorio.",
                    minlength: "El número telefónico debe tener 8 caracteres.",
                    maxlength: "El número telefónico debe tener 8 caracteres.",
                    digits: "El número telefónico solo debe contener números."
                },
                anio: {
                    required: "El año de la oficina es obligatorio.",
                    digits: "El año debe contener solo números.",
                    minlength: "El año debe tener exactamente 4 dígitos.",
                    maxlength: "El año debe tener exactamente 4 dígitos.",
                    min: "El año no puede ser menor que 2015.",
                    max: `El año no puede ser mayor que ${new Date().getFullYear() + 1}.`,
                },
                estado: {
                    required: "El estado es obligatorio.",
                },
                id_oficina: {
                    required: "La oficina es obligatorio.",
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
                registrar_personal(); // Llamar a la función para registrar el usuario
            }
        });

        listar_regimenLaboral();
        listar_oficina();
        
    });

    function listar_regimenLaboral() {
        $.ajax({
            type: 'POST',
            url: '{{ route('selectPer.listaRlaboral') }}',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}'},
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let regimenes = data.regimenes;
                    let select = $('#selectPersonal'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Regimen Laboral</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    regimenes.forEach(function(regimen) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = regimen.nombre;
                        select.append(
                            $('<option></option>')
                            .val(regimen.id_rl)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar_categoria:', data);
            }
        });
    }

    function listar_oficina() {
        $.ajax({
            type: 'POST',
            url: '{{ route('selectPer.listaOficinas') }}',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}'},
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let oficinas = data.oficinas;
                    let select = $('#selectOficina'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Categoría Padre</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    oficinas.forEach(function(oficina) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = oficina.nombre;
                        select.append(
                            $('<option></option>')
                            .val(oficina.id_oficina)
                            .text(optionText)
                        );
                    });

                    /*select.select2({
                        dropdownParent: $('#modal-nueva-oficina')
                    });*/

                }
            },
            error: function(data) {
                console.error('Error en listar_categoria:', data);
            }
        });
    }


    function registrar_personal() {
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
                let formElement = document.getElementById("guardarPersonal");
                let formData = new FormData(formElement);
                return fetch('{{ route('registrar.personal') }}', {
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
                        $('#guardarPersonal')[0].reset();
                        $('#modal-nuevo-personal').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function editar_personal() {
        $("#alternative-page-datatable tbody").on('click', '.editar_personal', function() {
            let id_personal = $(this).attr('data-id-personal');

            $("#tipo_formulario").val(2);
            $("#id_personal_editar").val(id_personal);

            /*console.log(id_personal);*/
            $.ajax({
                type: 'POST',
                url: '{{ route('editar.personal') }}',
                data: {
                    id_personal: id_personal,
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
                    $("#title_modal").html('Editar Personal');
                    // Cambia la clase del div con id="modal-header"
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');

                    let personal = data.personal;

                    $("#dni").val(personal.dni);
                    $("#nombre").val(personal.nombre);
                    $("#apellidoPaterno").val(personal.apellidoPaterno);
                    $("#apellidoMaterno").val(personal.apellidoMaterno);
                    $("#id_rl").val(personal.id_rl);
                    $("#telefono").val(personal.telefono);

                    

                    let asigPersonal = data.asigPersonal;

                    $("#anio").val(asigPersonal.anio);

                    // Limpiar y llenar el select de estado laboral
                    $("#selectEstado").html(`
                        <option value="" disabled>Seleccionar Estado Laboral</option>
                        <option value="1">Activo</option>
                        <option value="0">Inactivo</option>
                    `);
                    // Asignar el estado
                    $("#selectEstado").val(asigPersonal.estado);
                    
                    // Llenar el select de Régimen Laboral
                    let opcionesRegimenLaboral = '<option value="" disabled>Seleccionar Régimen Laboral</option>';
                    data.regimenesLaborales.forEach(function(regimen) {
                        console.log('Comparando:', regimen.id_rl, 'con', personal.id_rl);  // Debug: Verificar la comparación
                        let isSelected = (regimen.id_rl == personal.id_rl) ? 'selected' : '';
                        opcionesRegimenLaboral += `<option value="${regimen.id_rl}" ${isSelected}>${regimen.nombre}</option>`;
                    });
                    $("#selectPersonal").html(opcionesRegimenLaboral);

                    // Llenar el select de Oficinas
                    let opcionesOficina = '<option value="" disabled>Seleccionar Oficina</option>';
                    data.oficinas.forEach(function(oficina) {
                        let isSelected = (oficina.id_oficina === asigPersonal.id_oficina) ? 'selected' : '';
                        opcionesOficina += `<option value="${oficina.id_oficina}" ${isSelected}>${oficina.nombre}</option>`;
                    });
                    $("#selectOficina").html(opcionesOficina);

                    $("#modal-nuevo-personal").modal('show');

                }
            });
        });
    }

    
</script>
