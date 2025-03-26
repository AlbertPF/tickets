<!-- Modal -->
<div id="modal-nueva-oficina" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-success">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-notebook font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal"></h4>
                {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" inert></button> --}}
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="guardarOficina">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_oficina_editar" id="id_oficina_editar" value="">
                <input type="hidden" name="codigo" id="codigo" value="">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">
                                <div class="col-xl-9 col-lg-9">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Nombre de la Oficina:</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Oficina">
                                    </div>
                                </div>

                                <div class="col-xl-3 col-lg-3">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Año</label>
                                        <input type="text" class="form-control date" id="anio" name="anio" placeholder="Año">
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
                                                        <label class="form-label">Oficina Padre:</label>
                                                        <select id="selectOficinaPadre" name="id_oficina_padre" data-toggle="select2" title="Oficina Padre">
                                                            <option value="" disabled selected>Seleccionar Oficina Padre</option>
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


        $('.agregar_oficina').click(function() {
            //console.log('agregar oficina');
            $("#title_modal").html('Agregar Oficina');
            // Cambia la clase del div con id="modal-header"
            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Guardar');
            // Limpia los campos del formulario
            $('#guardarOficina')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_oficina_editar").val("");

            listar_oficina();

        });

        // Inicializar select2 dentro del modal después de que se haya mostrado
        $('#modal-nueva-oficina').on('shown.bs.modal', function() {
            $('select[data-toggle="select2"]').select2({
                dropdownParent: $('#modal-nueva-oficina'),
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

            ElementosOficina();
                
        });

        $('#guardarOficina').validate({
            rules: {
                nombre: {
                    required: true,
                },
                anio: {
                    required: true,
                    digits: true,            
                    minlength: 4,            
                    maxlength: 4,            
                    min: 2015,               
                    max: new Date().getFullYear() + 1 
                },
            },
            messages: {
                nombre: {
                    required: "El nombre de la oficina es obligatorio.",
                },
                anio: {
                    required: "El año de la oficina es obligatorio.",
                    digits: "El año debe contener solo números.",
                    minlength: "El año debe tener exactamente 4 dígitos.",
                    maxlength: "El año debe tener exactamente 4 dígitos.",
                    min: "El año no puede ser menor que 2015.",
                    max: `El año no puede ser mayor que ${new Date().getFullYear() + 1}.`,
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
                registrar_oficina();
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
                    let select = $('#selectOficinaPadre'); // Seleccionar el <select>
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

                    select.select2({
                        dropdownParent: $('#modal-nueva-oficina')
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

    function registrar_oficina() {
        //console.log('registrar oficina');
        Swal.fire({
            title: "¿Esta seguro?",
            icon: "warning",
            text: "Verifique los datos antes de enviar",
            showCancelButton: true,
            confirmButtonText: "Si, estoy seguro",
            cancelButtonText: "Cancelar",
            showLoaderOnConfirm: true,
            preConfirm: () => {
                let token = $('meta[name="csrf-token"]').attr('content');
                let formElement = document.getElementById("guardarOficina");
                let formData = new FormData(formElement);

                return fetch('{{ route('registrar.oficina') }}', {
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
            //Read more about isConfirmed, isDenied below 
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
                        $('#guardarOficina')[0].reset();
                        $('#modal-nueva-oficina').modal('hide');
                        //window.location.href = "{{ url('/archivo') }}";
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function editar_oficina() {
        $("#alternative-page-datatable tbody").on('click', '.editar_oficina', function() {
            let id_oficina = $(this).attr('data-id-oficina');
             $("#tipo_formulario").val(2);
            $("#id_oficina_editar").val(id_oficina);

            $.ajax({
                type: 'POST',
                url: '{{ route('editar.oficina') }}',
                data: {
                    id_oficina: id_oficina,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                success: function(data) {

                    //console.log(data);

                    $("#title_modal").html('Editar Oficina');
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');

                    let oficina = data.oficina;
                    let oficinasOrd = data.oficinasOrd;
                    
                    // Asignar valores de archivo al formulario
                    $("#nombre").val(oficina.nombre);
                    $("#descripcion").val(oficina.descripcion);
                    $("#anio").val(oficina.anio);
                    $("#codigo").val(oficina.codigo);

                    // Llenar el select de oficina con la oficina asociada seleccionada
                    let opcionesOficina = '<option value="" disabled>Seleccionar Oficina</option>';
                    oficinasOrd.forEach(function(dataOficinas) {
                        // Comprobar si la oficina es la oficina padre asociada
                        let isSelected = (dataOficinas.id_oficina === oficina.id_oficina_padre) ? 'selected' : '';
                        
                        // Si la oficina es padre y su id_oficina_padre es null, seleccionarla
                        if (oficina.id_oficina_padre === null && dataOficinas.id_oficina === oficina.id_oficina) {
                            isSelected = 'selected';
                            opcionesOficina += `<option value="" ${isSelected}>Oficina Padre</option>`;
                        } else {
                            opcionesOficina += `<option value="${dataOficinas.id_oficina}" ${isSelected}>${dataOficinas.nombre}</option>`;
                        }
                    });

                    $("#selectOficinaPadre").html(opcionesOficina);

                    $("#modal-nueva-oficina").modal('show');

                    ElementosOficina();
                },
                error: function(data) {
                    let errorJson = JSON.parse(data.responseText);
                    Swal.fire({
                        icon: "error",
                        title: "Oops...",
                        text: errorJson.message,
                        footer: '<a href="">Vuelva a intentarlo</a>'
                    });
                }
            });
        });
    }
</script>
