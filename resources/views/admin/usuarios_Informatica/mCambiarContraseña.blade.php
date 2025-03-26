<div id="modalCamiarContraseña" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-2 mb-4">
                    <a href="index.html" class="text-success">
                        <span><img src="{{ url('Images/Gore/logo_GORE.png') }}" alt="" height="60"></span>
                    </a>
                </div>

                <form id="guardarContraseña" >
                    @csrf
                    <div class="mb-3 form-group">
                        <label class="form-label">Contraseña</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control input" type="password" id="password" name="password">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>  
                        </div>
                    </div>

                    <div class="mb-3 form-group">
                        <label class="form-label">Confirmar Contraseña</label>
                        <div class="input-group input-group-merge">
                            <input class="form-control input" type="password" id="password_confirmation" name="password_confirmation">
                            <div class="input-group-text" data-password="false">
                                <span class="password-eye"></span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3 text-center">
                        <button class="btn rounded-pill btn-light" type="button" data-bs-dismiss="modal"> Cancelar</button>
                        <button class="btn rounded-pill btn-primary actulizarContra" type="submit"><i class="mdi mdi-lock-check"></i> Cambiar Contraseña</button>
                    </div>

                </form>

            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $(document).ready( function () {
        // validacion personalizada para verificar la igualdad de las contraseñas
        $.validator.addMethod("equalToPassword", function (value, element) {
            return value === $("#password").val();
        }, "Las contraseñas no coinciden");
        //initFv('guardarContraseña',rulesChangePassowrd());

        $('#guardarContraseña').validate({
            rules: {
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalToPassword: true
                }
            },
            messages: {
                password: {
                    required: "La contraseña es obligatoria.",
                    minlength: "La contraseña debe tener al menos 8 caracteres."
                },
                password_confirmation: {
                    required: "Confirme su contraseña.",
                    minlength: "La confirmación de la contraseña debe tener al menos 8 caracteres.",
                    equalToPassword: "Las contraseñas no coinciden."
                }
            },
            errorElement: 'span',
            errorPlacement: function (error, element) {
                error.addClass('invalid-feedback');
                element.closest('.input-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                $(element).addClass('is-invalid').removeClass('is-valid');
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).removeClass('is-invalid').addClass('is-valid');
            }
        }); 
    });

    $('.actulizarContra').on('click',function(){
        actulizarContra();
    });


    /*function rulesChangePassowrd()
    {
        return {
            password: {required: true,minlength: 8},
            password_confirmation: {required: true,minlength: 8,equalToPassword: true},
        };
    }*/

    function actulizarContra()
    {
        if($('#guardarContraseña').valid()==false)
        {return;}
    
        var formData = new FormData($("#guardarContraseña")[0]);
        $('.actulizarContra').prop('disabled',true);

        $.ajax({ 
            url: "{{ route('contra.usuario') }}",
            data: formData,
            method: 'POST',
            dataType: 'json',
            contentType: false,
            processData: false, 
            headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
            beforeSend: function() {
                // Puedes agregar aquí un spinner si lo deseas
            },
            error: function(data) {
                let errorJson = data.responseJSON;
                Swal.fire({
                    icon: "error",
                    title: "Oops...",
                    text: errorJson.message,
                    footer: '<a href="">Vuelva a intentarlo</a>'
                });
                $('.actulizarContra').prop('disabled', false);
            },
            success: function(data){
                console.log(data.usuario);
                Swal.fire({
                    icon: "success",
                    title: "Éxito",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    $('#modalCamiarContraseña').modal('hide');
                    $('.actulizarContra').prop('disabled', false);
                });
            }
        });
    }
</script>
