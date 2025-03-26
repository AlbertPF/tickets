<!-- Modal -->
<div id="modal-nueva-rl" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel"
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
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="guardarRLaboral">
                @csrf
                <input type="hidden" name="tipo_formulario" id="tipo_formulario" value="">
                <input type="hidden" name="id_rlaboral_editar" id="id_rlaboral_editar" value="">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6">
                                    <div class="mb-3 form-group">
                                        <label class="form-label">Nombre del Régimen Laboral :</label>
                                        <input type="text" class="form-control" id="nombre" name="nombre"
                                            placeholder="Nombre del régimen laboral">
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

        $('.agregar_rlaboral').click(function() {
            console.log('agregar régimen laboral');
            $("#title_modal").html('Agregar Régimen Laboral');

            $("#modal-header").removeClass('bg-info').addClass('bg-success');
            $("#btnGuardar").removeClass('btn-info').addClass('btn-success').html('Guardar');
            // Limpia los campos del formulario
            $('#guardarRLaboral')[0].reset();

            $("#tipo_formulario").val(1);
            $("#id_rlaboral_editar").val("");

        });

        $('#guardarRLaboral').validate({
            rules: {
                nombre: {
                    required: true,
                },
            },
            messages: {
                nombre: {
                    required: "El nombre del régimen laboral es obligatorio.",
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
                registrar_rloboral();
            }
        });

    });

    function registrar_rloboral() {
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
                let formElement = document.getElementById("guardarRLaboral");
                let formData = new FormData(formElement);
                return fetch('{{ route('rlaboral.registrar') }}', {
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
                    Swal.showValidationMessage(
                        `Error: ${mensaje}`
                    )
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
                        $('#guardarRLaboral')[0].reset();
                        $('#modal-nueva-rl').modal('hide');
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function editar_rloboral() {

        $("#alternative-page-datatable tbody").on('click', '.editar_rlaboral', function() {
            let id_rlaboral = $(this).attr('data-id-rlaboral');
            //console.log(id_rlaboral);
            
            $("#tipo_formulario").val(2);
            $("#id_rlaboral_editar").val(id_rlaboral);

            $.ajax({
                type: 'POST',
                url: '{{ route('rlaboral.editar') }}',
                data: {
                    id_rl: id_rlaboral,
                    _token: '{{ csrf_token() }}'
                },
                dataType: 'json',
                beforeSend: function() {
                    // Puedes agregar aquí un spinner si lo deseas
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

                    $("#title_modal").html('Editar Régimen Laboral');
                    $("#modal-header").removeClass('bg-success').addClass('bg-info');
                    $("#btnGuardar").removeClass('btn-success').addClass('btn-info').html('Actualizar');

                    
                    let rlaboral = data.rlaboral;

                    $("#nombre").val(rlaboral.nombre);
                    $("#descripcion").val(rlaboral.descripcion);
                    
                    $("#modal-nueva-rl").modal('show');
                }
            });
        });
    }
</script>
