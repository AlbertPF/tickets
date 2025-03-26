<!-- Modal -->
<div id="modal-final-MisTickets" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="success-header-modalLabel">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div id="modal-header" class="modal-header modal-colored-header bg-success">
                <div class="d-flex align-items-center">
                    <div class="flex-shrink-0 me-2">
                        <div class="avatar-sm">
                            <span class="avatar-title bg-light-lighten text-light rounded">
                                <i class="mdi mdi-eye-settings font-24"></i>
                            </span>
                        </div>
                    </div>
                </div>
                <h4 class="modal-title" id="title_modal">Observación</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="MisTickest">
                @csrf
                <input type="hidden" name="id_ticket" id="id_ticket2">
                <div class="modal-body">
                    <div class="tab-content">
                        <div class="tab-pane show active" id="custom-styles-preview">
                            <div class="row">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="col-xl-12 col-lg-12">
                                            <div>
                                                <label class="form-label">Detalle observación : </label>
                                                <textarea id="descripcion2" name="descripcion" data-toggle="maxlength" class="form-control" maxlength="225"
                                                    rows="3" placeholder="Esta área de texto tiene un límite de 225 caracteres."></textarea>
                                                <br>
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
                    <button id="btnGuardar" type="submit" class="btn btn-success">Finalizar</button>
                </div>
            </form>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
    $(document).ready(function() {

        $('#MisTickest').validate({
            rules: {
                descripcion: {
                    required: true,
                    maxlength: 225
                }
            },
            messages: {
                descripcion: {
                    required: "La observación es obligatoria.",
                    maxlength: "La observación no puede superar los 225 caracteres."
                },
            },
            errorElement: 'span',
            errorPlacement: function(error, element) {
                error.addClass('invalid-feedback');
                element.after(error);
            },
            highlight: function(element) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function(element) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            },
            submitHandler: function(form) {
                finalizar2_asignacion2();
            }
        });

    });

    function finalizar2_asignacion2() {
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
                let formElement = document.getElementById("MisTickest");
                let formData = new FormData(formElement);

                return fetch('{{ route('final2.ticketsAsig2') }}', {
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
                        $('#MisTickest')[0].reset();
                        $('#modal-final-MisTickets').modal('hide');
                        mostrar_tablaAsig();
                        mostrar_tabla();
                    }
                });
            } else if (result.isDenied) {
                Swal.fire("Error en el registro", "", "info");
            }
        });
    }

    function modalFinalizarTickets2() {
        $("#selection-datatable tbody").on('click', '.finalizar_ticket', function() {
            let id_ticket = $(this).attr('data-id-ticketAsig');
            console.log(id_ticket);

            $.ajax({
                type: 'POST',
                url: '{{ route('editar2.ticketsAsig2') }}',
                data: {
                    id_ticket: id_ticket,
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

                    let Asig = data.asigTicket;

                    $('#descripcion2').val('');
                    $('#id_ticket2').val(Asig.id_ticket);

                    $("#modal-final-MisTickets").modal('show');
                }
            });

        });
    }
</script>
