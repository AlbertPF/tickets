<!-- Modal -->
<div id="modal-actividades" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-success">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-file-sign font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal"></h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="guardarActividades">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_actividad_editar" id="id_actividad_editar" value="">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Actividad :</label>
                                        <select id="selectActividad" name="id_actividad" data-toggle="select2" title="Regimen Laboral">
                                            <option value="" disabled selected>Seleccionar Regimen Laboral</option>
                                            <!-- Las opciones serán llenadas dinámicamente -->
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Documento Referencial :</label>
                                        <input type="text" class="form-control" id="doc_ref" name="doc_ref" placeholder="Ingrese documento referencial">
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div>
                                        <label class="form-label">Descripción : </label>
                                        <textarea id="descripcion" name="descripcion" data-toggle="maxlength" class="form-control" maxlength="225"
                                            rows="3" placeholder="Esta área de texto tiene un límite de 225 caracteres."></textarea>
                                        <br>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <button id="btnAsignarOficina" class="btn btn-outline-success" type="button" data-bs-toggle="collapse" data-bs-target="#collapseWidthExample"
                                            aria-expanded="false" aria-controls="collapseWidthExample" style="margin-top: 30px; margin-left: 20px;">
                                            Asignar Oficina
                                        </button>
                                    </div>
                                </div>
                                <div class="col-xl-12 col-lg-12">
                                    <div class="collapse multi-collapse" id="collapseWidthExample">
                                        <div class="card card-body mb-0">
                                            <div class="row">
                                                <div class="col-xl-6 col-lg-6">
                                                    <div class="mb-3 form-group">
                                                        <label class="form-label">Oficina :</label>
                                                        <select id="selectOficina" name="id_oficina" data-toggle="select2" title="Oficina Padre">
                                                            <option value="" disabled selected>Seleccionar Oficina</option>
                                                            <!-- Las opciones serán llenadas dinámicamente -->
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
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


        $('.agregar_actividad').click(function() {
            //console.log('agregar oficina');
            $("#title_modal").html('Agregar Actividad');
            // Cambia la clase del div con id="modal-header"
            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Guardar');
            // Limpia los campos del formulario
            $('#guardarActividades')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_oficina_editar").val("");

            listar_oficina();
            listar_act();

        });

        // Inicializar select2 dentro del modal después de que se haya mostrado
        $('#modal-actividades').on('shown.bs.modal', function() {
            $('select[data-toggle="select2"]').select2({
                dropdownParent: $('#modal-actividades'),
                language: {
                    noResults: function() {
                        return "No se encontraron resultados";
                    }
                },
                placeholder: "Seleccionar una opción"
            });

            ElementosOficina();
                
        });

        $('#guardarActividades').validate({
            rules: {
                id_actividad: {
                    required: true,
                },
            },
            messages: {
                id_actividad: {
                    required: "La Actividad es obligatorio.",
                },
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
                registrar_actividad();
            }
        });

    });

    function ElementosOficina() {
        var tipoFormulario = $('#tipo_formulario').val(); // Obtener el valor del formulario

        if (tipoFormulario === "1") {
            //console.log('entra 1');
            // Si es un nuevo registro, ocultar el select y mostrar el botón
            $('#collapseWidthExample').removeClass('show');  // Oculta el collapse
            $('#btnAsignarOficina').removeClass('collapsed').show();  // Muestra el botón

        } else if (tipoFormulario === "2") {
            //console.log('entra 2');
            // Si es editar, ocultar el botón y mostrar el select
            $('#btnAsignarOficina').hide();  // Oculta el botón
            $('#collapseWidthExample').addClass('show');  // Muestra el collapse
            $('#selectOficinaPadre').closest('.form-group').show();  // Asegura que el selector esté visible

            $('#anio').datepicker({
                format: "yyyy",          
                viewMode: "years",       
                minViewMode: "years",    
                autoclose: true 
            });
        }
    }

    function listar_act() {
        $.ajax({
            type: 'POST',
            url: '{{ route('select.listaActividad') }}',
            dataType: 'json',
            data: {_token: '{{ csrf_token() }}'},
            success: function(data) {
                //console.log('Oficinas:', data);
                if (data.code === 200) {
                    let acts = data.acts;
                    let select = $('#selectActividad'); // Seleccionar el <select>
                    select.empty(); // Limpiar opciones anteriores

                    // Agregar nuevamente la opción predeterminada
                    select.append('<option value="" disabled selected>Seleccionar actividad</option>');

                    // Iterar sobre las categorías jerárquicas para agregarlas al select
                    acts.forEach(function(act) {
                        // Añadir opción al select con un formato visual basado en el nivel
                        let optionText = act.nombre;
                        select.append(
                            $('<option></option>')
                            .val(act.id_actividad)
                            .text(optionText)
                        );
                    });
                }
            },
            error: function(data) {
                console.error('Error en listar actividad:', data);
            }
        });
    }

    function listar_oficina() {
        $.ajax({
            type: 'POST',
            url: '{{ route('select.listaOficinas') }}',
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

                    select.select2({
                        dropdownParent: $('#modal-actividades')
                    });
                    /*categorias.forEach(function(categoria) {
                        selectCategoria.append('<option value="' + categoria
                            .id_categoria + '">' + categoria.nombre_categoria +
                            '</option>');
                    });*/

                }
            },
            error: function(data) {
                console.error('Error en listar_categoria:', data);
            }
        });
    }

    function registrar_actividad() {
        //console.log('registrar actividad');
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
                let formElement = document.getElementById("guardarActividades");
                let formData = new FormData(formElement);
                return fetch('{{ route('registrar.actividad') }}', {
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
                        $('#guardarActividades')[0].reset();
                        $('#modal-actividades').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function editar_actividad() {
        $("#alternative-page-datatable tbody").on('click', '.editar_actividad', function() {
            let id_bitacora = $(this).attr('data-id-actividad');

            $("#tipo_formulario").val(2);
            $("#id_actividad_editar").val(id_bitacora);

            /*console.log(id_personal);*/
            $.ajax({
                type: 'POST',
                url: '{{ route('editar.actividad') }}',
                data: {
                    id_bitacora: id_bitacora,
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
                    $("#title_modal").html('Editar Actividad');
                    // Cambia la clase del div con id="modal-header"
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');

                    let actividad = data.actividad;
                    let oficinas = data.oficinas;
                    let oficinaAsignada = data.oficinaAsignada;

                    //$("#actividad").val(actividad.id_actividad);
                    $("#actividad").val(actividad.id_actividad);
                    $("#doc_ref").val(actividad.doc_ref);
                    $("#descripcion").val(actividad.descripcion);

                    // Llenar el select de Régimen Laboral
                    let opcionesAct = '<option value="" disabled>Seleccionar Actividad</option>';
                    data.acts.forEach(function(act) {
                        //console.log('Comparando:', act.id_actividad, 'con', actividad.id_actividad);  // Debug: Verificar la comparación
                        let isSelected = (act.id_actividad == actividad.id_actividad) ? 'selected' : '';
                        opcionesAct += `<option value="${act.id_actividad}" ${isSelected}>${act.nombre}</option>`;
                    });
                    $("#selectActividad").html(opcionesAct);

                    // Llenar el select con la oficina asociada y las otras oficinas
                    let opcionesOficina = '<option value="" disabled>Seleccionar Oficina</option>';

                    if (oficinaAsignada == null) {
                        // Si la oficina asignada es null, mantenemos la opción por defecto seleccionada
                        opcionesOficina = '<option value="" disabled selected>Seleccionar Oficina</option>';
                    } else {
                        // Si existe una oficina asignada, esta se marca como seleccionada
                        opcionesOficina += `<option value="${oficinaAsignada.id_oficina}" selected>${oficinaAsignada.nombre}</option>`;
                    }

                    // Agregar todas las otras oficinas disponibles para cambiar la selección si es necesario
                    oficinas.forEach(function(oficina) {
                        // Solo marcar como 'selected' la oficina asignada, las demás oficinas no deben ser seleccionadas
                        let isSelected = (oficina.id_oficina === oficinaAsignada?.id_oficina) ? 'selected' : '';
                        opcionesOficina += `<option value="${oficina.id_oficina}" ${isSelected}>${oficina.nombre}</option>`;
                    });

                    $("#selectOficina").html(opcionesOficina);

                    $("#modal-actividades").modal('show');

                }
            });
        });
    }
</script>