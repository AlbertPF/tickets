@extends('layout.app')

@section('css-styles-home')
    
@endsection

@section('contenido')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Gore</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Panel Administrativo</a></li>
                        <li class="breadcrumb-item active">Mi Perfil</li>
                    </ol>
                </div>
                <h4 class="page-title">Mi Perfil</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->  

    <div class="row">
        <div class="col-xl-4 col-lg-5">
            <div class="card text-center">
                <div class="card-body">
                    <img src="{{ url('Images/Gore/team.jpg') }}" class="rounded-circle avatar-lg img-thumbnail"
                    alt="profile-image">

                    <h4 class="mb-0 mt-2 nombre">---</h4>
                    <p class="text-muted font-14 tipo">---</p>

                    <div class="text-start mt-3">
                        <h4 class="font-13 text-uppercase">Credenciales de Acceso:</h4>
                        <p class="text-muted font-13 mb-3">
                            Las credenciales proporcionadas a continuación son necesarias para acceder al sistema. 
                            Asegúrese de utilizarlas para iniciar sesión de forma segura y acceder a las funcionalidades
                            disponibles.
                        </p>
                        <p class="text-muted mb-2 font-13"><strong>Usuario :</strong> <span class="ms-2 usuario">---</span></p>

                        <p class="text-muted mb-2 font-13"><strong>Contraseña :</strong><span class="ms-2">*****************</span></p>

                    </div>

                    <button type="button" class="btn btn-outline-info" data-bs-toggle="modal" data-bs-target="#modalCamiarContraseña"><i class="mdi mdi-lock-outline"></i> Cambiar Contraseña</button>

                </div> <!-- end card-body -->
            </div> <!-- end card -->

        </div> <!-- end col-->

        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-body">

                    <h3 class="mt-3">Mis Datos Personales</h3>

                    <div class="row">
                        <div class="col-4">
                            <!-- assignee -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Nombre</p>
                            <div class="d-flex">
                                <img src="{{ url('Images/Gore/team.jpg') }}" alt="Arya S" class="rounded-circle me-2" height="24" />
                                <div>
                                    <h5 class="mt-1 font-14 nombre">---</h5>
                                </div>
                            </div>
                            <!-- end assignee -->
                        </div> <!-- end col -->

                        <div class="col-4">
                            <!-- start due date -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Paterno</p>
                            <div class="d-flex">
                                <i class='mdi mdi-card-account-details font-18 text-success me-1'></i>
                                <div>
                                    <h5 class="mt-1 font-14 apellidoPaterno">---</h5>
                                </div>
                            </div>
                            <!-- end due date -->
                        </div> <!-- end col -->

                        <div class="col-4">
                            <!-- start due date -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Apellido Materno</p>
                            <div class="d-flex">
                                <i class='mdi mdi-card-account-details font-18 text-success me-1'></i>
                                <div>
                                    <h5 class="mt-1 font-14 apellidoMaterno">---</h5>
                                </div>
                            </div>
                            <!-- end due date -->
                        </div> <!-- end col -->

                    </div> <!-- end row -->
                    <br>
                    <div class="row">
                        <div class="col-4">
                            <!-- start due date -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">DNI</p>
                            <div class="d-flex">
                                <i class='mdi mdi-card-account-details-star font-18 text-success me-1'></i>
                                <div>
                                    <h5 class="mt-1 font-14 dni">---</h5>
                                </div>
                            </div>
                            <!-- end due date -->
                        </div> <!-- end col -->

                        <div class="col-4">
                            <!-- start due date -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Número Telefónico</p>
                            <div class="d-flex">
                                <i class='mdi mdi-cellphone font-18 text-success me-1'></i>
                                <div>
                                    <h5 class="mt-1 font-14 telefono">---</h5>
                                </div>
                            </div>
                            <!-- end due date -->
                        </div> <!-- end col -->

                        <div class="col-4">
                            <!-- start due date -->
                            <p class="mt-2 mb-1 text-muted fw-bold font-12 text-uppercase">Fecha de Registro</p>
                            <div class="d-flex">
                                <i class='mdi mdi-calendar-month font-18 text-success me-1'></i>
                                <div>
                                    <h5 class="mt-1 font-14 fecha_reg">---</h5>
                                </div>
                            </div>
                            <!-- end due date -->
                        </div> <!-- end col -->
                    </div>


                    <h5 class="mt-3">Descripción General:</h5>

                    <p class="text-muted mb-4">
                        En el Portal de Transparencia Institucional del Gobierno Regional Apurímac, los usuarios pueden visualizar
                        toda la información relevante de su perfil personal de manera detallada. Además, se ofrece la opción de 
                        actualizar su contraseña si así lo requiere, garantizando un acceso seguro. Si necesita asistencia adicional,
                        por favor, póngase en contacto con el soporte técnico.
                    </p>

                </div> <!-- end card body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row-->

    @include('admin.usuarios_Informatica.mCambiarContraseña')

@endsection

@section('js-styles-home')
    <script>
        $(document).ready( function () {
            fillUsuario();
        });

        function fillUsuario()
        {
            $.ajax(
            { 
                url: "{{ route('verPerfil.usuario') }}",
                data: {id_usuario:"{{Session::get('usuario')->id_usuario}}"},
                method: 'POST',
                headers: {'X-CSRF-TOKEN': "{{ csrf_token() }}"},
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
                success: function(data){
                    console.log(data.usuario);
                    showDataUsuario(data);

                }
            });
        }

        function formatDate(dateString) {
            let date = new Date(dateString);
            let year = date.getFullYear();
            let month = ('0' + (date.getMonth() + 1)).slice(-2);
            let day = ('0' + date.getDate()).slice(-2);
            return `${year}-${month}-${day}`;
        }

        function showDataUsuario(data){
            codusuario = data.usuario.id_usuario;
            $('.dni').html(data.usuario.dni);
            $('.nombre').html(data.usuario.nombre);
            $('.apellidoPaterno').html(data.usuario.apellidoPaterno);
            $('.apellidoMaterno').html(data.usuario.apellidoMaterno);
            $('.usuario').html(data.usuario.usuario);
            $('.telefono').html(data.usuario.telefono); 
            $('.fecha_reg').html(formatDate(data.usuario.created_at));
            
            let apellidosCompletos = data.usuario.apellidoPaterno + ' ' + data.usuario.apellidoMaterno;
            $('.apellido').html(apellidosCompletos);
            $('.tipo').html(data.usuario.tipo);
        }
    </script>
@endsection