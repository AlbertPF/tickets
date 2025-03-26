@extends('layout.app')


@section('contenido')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">GORE</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('home') }}">Panel Administrativo</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('index.usuario') }}">Usuarios</a></li>
                        <li class="breadcrumb-item active">Perfil {{ $usuario->nombre }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Perfil</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->


    <div class="row">
        <div class="col-sm-12">
            <!-- Profile -->
            <div class="card bg-primary">
                <div class="card-body profile-user-box">
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <div class="avatar-lg">
                                        <img src="{{ url('assets/images/users/avatar-2.jpg') }}" alt=""
                                            class="rounded-circle img-thumbnail">
                                    </div>
                                </div>
                                <div class="col">
                                    <div>
                                        <h4 class="mt-1 mb-1 text-white">{{ $usuario->nombre }}</h4>
                                        <p class="font-13 text-white-50"> {{ $usuario->apellidoPaterno }}
                                            {{ $usuario->apellidoMaterno }}</p>

                                        <ul class="mb-0 list-inline text-light">
                                            <li class="list-inline-item me-3">
                                                <h5 class="mb-1 text-white">{{ $usuario->usuario }}</h5>
                                                <p class="mb-0 font-13 text-white-50">Usuario</p>
                                            </li>
                                            <li class="list-inline-item me-3">
                                                <h5 class="mb-1 text-white">{{ $usuario->tipo }}</h5>
                                                <p class="mb-0 font-13 text-white-50">Tipo</p>
                                            </li>
                                            <li class="list-inline-item">
                                                <h5 class="mb-1 text-white">{{ $usuario->telefono }}</h5>
                                                <p class="mb-0 font-13 text-white-50">Número Telefónico</p>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col-->

                        <div class="col-sm-4">
                            <div class="text-center mt-sm-0 mt-3 text-sm-end">
                                <button type="button" class="btn btn-light" data-bs-toggle="modal">
                                    {{-- <i class="mdi mdi-account-edit me-1"></i> Editar perfil --}}
                                    <a href="{{ route('index.usuario') }}"><i class="mdi mdi-undo-variant me-1"></i> Regresar</a>
                                </button>
                            </div>
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                </div> <!-- end card-body/ profile-user-box-->
            </div><!--end profile/ card -->
        </div> <!-- end col-->
    </div>
    <!-- end row -->


    <div class="row">
        <div class="col-xl-4">
            <!-- Personal-Information -->
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mt-0 mb-3">Información Personal</h4>
                    <p class="text-muted font-13">

                    </p>

                    <hr />

                    <div class="text-start">
                        <p class="text-muted"><strong>Nombres :</strong> <span class="ms-2">{{ $usuario->nombre }}</span>
                        </p>

                        <p class="text-muted"><strong>Apellidos :</strong> <span
                                class="ms-2">{{ $usuario->apellidoPaterno }} {{ $usuario->apellidoMaterno }}</span></p>

                        {{-- <p class="text-muted"><strong>DNI :</strong><span class="ms-2">{{ $usuario->dni }}</span></p> --}}

                        <p class="text-muted"><strong>Número Telefónico :</strong> <span class="ms-2">{{ $usuario->telefono }}</span>
                        </p>

                        <p class="text-muted"><strong>Usuario :</strong> <span
                                class="ms-2">{{ $usuario->usuario }}</span></p>

                        <p class="text-muted"><strong>Password</strong> <span class="ms-2"> ***************</span></p>
                        <p class="text-muted mb-0" id="tooltip-container"><strong>En otra parte:</strong>
                            <a class="d-inline-block ms-2 text-muted" data-bs-container="#tooltip-container"
                                data-bs-placement="top" data-bs-toggle="tooltip" href="#" title="Facebook"><i
                                    class="mdi mdi-facebook"></i></a>
                            <a class="d-inline-block ms-2 text-muted" data-bs-container="#tooltip-container"
                                data-bs-placement="top" data-bs-toggle="tooltip" href="#" title="Twitter"><i
                                    class="mdi mdi-twitter"></i></a>
                            <a class="d-inline-block ms-2 text-muted" data-bs-container="#tooltip-container"
                                data-bs-placement="top" data-bs-toggle="tooltip" href="#" title="Skype"><i
                                    class="mdi mdi-skype"></i></a>
                        </p>

                    </div>
                </div>
            </div>
            <!-- Personal-Information -->

        </div> <!-- end col-->

        <div class="col-xl-8">

            <div class="row">
                <div class="col-sm-4">
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="mdi mdi-archive float-end text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Tickets asiganados</h6>
                            <h2 class="m-b-20">{{ $ticketsAsignados }}</h2>
                            <span class="badge bg-primary"> {{ number_format($porcentajeAsignados, 2) }}% </span> <span class="text-muted">del total de Tickets</span>
                        </div> <!-- end card-body-->
                    </div> <!--end card-->
                </div><!-- end col -->
                
                <div class="col-sm-4">
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="mdi mdi-notebook float-end text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Tickets asiganados</h6>
                            <h2 class="m-b-20">{{ $ticketsAtendidos }}</h2>
                            <span class="badge bg-primary"></span> <span class="text-muted">Atendidos</span>
                        </div> <!-- end card-body-->
                    </div> <!--end card-->
                </div><!-- end col -->

                <div class="col-sm-4">
                    <div class="card tilebox-one">
                        <div class="card-body">
                            <i class="mdi mdi-notebook float-end text-muted"></i>
                            <h6 class="text-muted text-uppercase mt-0">Tickets asiganados</h6>
                            <h2 class="m-b-20">{{ $ticketsNoResueltos }}</h2>
                            <span class="badge bg-primary"></span> <span class="text-muted">No logrados</span>
                        </div> <!-- end card-body-->
                    </div> <!--end card-->
                </div><!-- end col -->

                <!-- Toll free number box-->
                <div class="card text-white bg-info overflow-hidden">
                    <div class="card-body">
                        <div class="toll-free-box text-center">
                            <h4> <i class="mdi mdi-smart-card"></i> DNI : {{ $usuario->dni }}</h4>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
                <!-- End Toll free number box-->

            </div>
            <!-- end row -->

        </div>
        <!-- end col -->

    </div>
    <!-- end row -->
@endsection
