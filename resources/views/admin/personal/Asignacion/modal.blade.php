<!-- Modal -->
<div id="modal-asignar-personal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel">
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
            <form id="guardarAsigPersonal">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_asignacion_editar" id="id_asignacion_editar" value="">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">

                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Personal :</label>
                                        <select id="selectPersonal" name="id_personal" data-toggle="select2" title="Personal">
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

                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Año</label>
                                        <input type="text" class="form-control date" id="anio" name="anio" placeholder="Año">
                                    </div>
                                </div>

                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Estado Laboral:</label>
                                        <select id="selectEstado" name="estado" class="form-control" data-toggle="select2" title="Estado Laboral">
                                            <option value="" disabled selected>Seleccionar Estado Laboral</option>
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
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

        $('.asignar_personal').click(function() {
            console.log('Asignar personal');
            $("#title_modal").html('Asiganar Personal');
            // Cambia la clase del div con id="modal-header"
            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Asignar');
            // Limpia los campos del formulario
            $('#guardarAsigPersonal')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_asignacion_editar").val("");

            // Inicializar select2 dentro del modal después de que se haya mostrado
            $('#modal-asignar-personal').on('shown.bs.modal', function() {
                $('select[data-toggle="select2"]').select2({
                    dropdownParent: $('#modal-asignar-personal'),
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
        });

        $('#guardarAsigPersonal').validate({
            rules: {
                id_personal: {
                    required: true,
                },
                anio: {
                    required: true,
                    digits: true,            
                    minlength: 4,            
                    maxlength: 4,            
                    min: new Date().getFullYear(), // Cambiado para permitir solo el año actual
                    max: new Date().getFullYear() 
                },
                estado: {
                    required: true,
                },
                id_oficina: {
                    required: true,
                }
            },
            messages: {
                id_personal: {
                    required: "El personal es obligatorio.",
                },
                anio: {
                    required: "El año de la oficina es obligatorio.",
                    digits: "El año debe contener solo números.",
                    minlength: "El año debe tener exactamente 4 dígitos.",
                    maxlength: "El año debe tener exactamente 4 dígitos.",
                    min: "El año debe ser el actual: " + new Date().getFullYear() + ".",
                    max: "El año debe ser el actual: " + new Date().getFullYear() + ".",
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
                Asignar_personal(); // Llamar a la función para registrar el usuario
            }
        });

        listar_personal();
        listar_oficina();

    });

    function listar_personal() {
        $.ajax({
            type: 'POST',
            url: '{{ route('selectPer.listaPersonal') }}',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}'},
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let personals = data.personals;
                    let select = $('#selectPersonal'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar Personal</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    personals.forEach(function(personal) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = personal.nombreCompletoPersonal;
                        select.append(
                            $('<option></option>')
                            .val(personal.id_personal)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar personal:', data);
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
                    select.append('<option value="" disabled selected>Seleccionar Oficina</option>');

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
                console.error('Error en listar oficina:', data);
            }
        });
    }

    function Asignar_personal() {
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
                let formElement = document.getElementById("guardarAsigPersonal");
                let formData = new FormData(formElement);
                return fetch('{{ route('asignar.ofiPersonal') }}', {
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
                        $('#guardarAsigPersonal')[0].reset();
                        $('#modal-asignar-personal').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    /*function editarAsig_personal() {
        $("#alternative-page-datatable tbody").on('click', '.editarAsig_personal', function() {
            let id_personal = $(this).attr('data-id-personal');

            $("#tipo_formulario").val(2);
            $("#id_asignacion_editar").val(id_personal);

            //console.log(id_personal);
            $.ajax({
                type: 'POST',
                url: ,
                data: {
                    id_personal: id_personal,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    /*var spinner =
                        `<div class="spinner-border text-info ms-auto cargando" role="status" aria-hidden="true"></div>`;
                    $("#contenedorRegistros").html(spinner);
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
                    $("#title_modal").html('Editar Asiganación del Personal');
                    // Cambia la clase del div con id="modal-header"
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');


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
                    let opcionesPersonal = '<option value="" disabled>Seleccionar Personal</option>';
                    data.personals.forEach(function(personal) {
                        console.log('Comparando:', personal.id_personal, 'con', asigPersonal.id_personal);  // Debug: Verificar la comparación
                        let isSelected = (personal.id_personal == asigPersonal.id_personal) ? 'selected' : '';
                        opcionesPersonal += `<option value="${personal.id_personal}" ${isSelected}>${personal.nombre}</option>`;
                    });
                    $("#selectPersonal").html(opcionesPersonal);

                    // Llenar el select de Oficinas
                    let opcionesOficina = '<option value="" disabled>Seleccionar Oficina</option>';
                    data.oficinas.forEach(function(oficina) {
                        let isSelected = (oficina.id_oficina === asigPersonal.id_oficina) ? 'selected' : '';
                        opcionesOficina += `<option value="${oficina.id_oficina}" ${isSelected}>${oficina.nombre}</option>`;
                    });
                    $("#selectOficina").html(opcionesOficina);

                    $("#modal-asignar-personal").modal('show');

                }
            });
        });
    }*/
</script>