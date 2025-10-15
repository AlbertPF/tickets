@extends('layout.app')

@section('css-styles-home')
@endsection

@section('contenido')
    <!-- título de la página de inicio -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="">GORE</a></li>
                        <li class="breadcrumb-item"><a href="{{ url('homeAdmin') }}">Panel Administativo</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('index.tickets') }}">Tickets</a></li>
                        <li class="breadcrumb-item active">{{ $ticket->id_ticket }}</li>
                    </ol>
                </div>
                <h4 class="page-title">Detalle de Ticket</h4>
            </div>
        </div>
    </div>
    <!-- título de la página final -->


    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-5">

                            <a href="javascript: void(0);" class="text-center d-block mb-4">
                                <img src="{{ url('Images/Gore/Ticket Gore A.png') }}" class="img-fluid"
                                    alt="Tickets - img" />
                            </a>

                        </div> <!-- end col -->
                        <div class="col-lg-7">

                            <h3 class="mt-0">Información del Ticket: {{ $ticket->id_ticket }} </h3>
                            <p class="mb-1">fecha de registro: {{ $ticket->fecha_env }}</p>

                            <div class="mt-3">
                                <h4 style="margin: 0px 0 !important;">
                                    <span class="badge {{ $ticket->getEstadoClase() }}">
                                        <i class="mdi mdi-check-circle-outline"></i> {{ $ticket->getEstadoNombre() }}
                                    </span>
                                </h4>
                            </div>

                            <div class="mt-4">
                                <h6 class="font-14">Incidencia:</h6>
                                <h3> {{ $ticket->soporte->nombre }}</h3>
                            </div>

                            <!-- Product description -->
                            <div class="mt-4">
                                <h6 class="font-14">Descripción:</h6>
                                <p>{{ $ticket->descripcion }} </p>
                            </div>

                            <!-- Product information -->
                            <div class="mt-4">
                                <div class="row">
                                    <div class="col-md-6">
                                        <h6 class="font-14">Personal:</h6>
                                        <p class="text-sm lh-150">
                                            {{ $ticket->oficinaPersonal->personal->nombre }}
                                            {{ $ticket->oficinaPersonal->personal->apellidoPaterno }}
                                            {{ $ticket->oficinaPersonal->personal->apellidoMaterno }}
                                        </p>
                                    </div>
                                    <div class="col-md-6">
                                        <h6 class="font-14">Oficina:</h6>
                                        <p class="text-sm lh-150">{{ $ticket->oficinaPersonal->oficina->nombre }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-4 gap-2">
                                <div class="d-flex">
                                    <button id="btnAsignar" data-id="{{ $ticket->id_ticket }}" class="btn btn-primary ms-4" @if(in_array($ticket->estado,[2,3,5])) disabled @endif>
                                        <i class="mdi mdi-account-check-outline me-1"></i> Asignar
                                    </button>

                                    <button id="btnCancelar" data-id="{{ $ticket->id_ticket }}" class="btn btn-danger ms-4" @if(in_array($ticket->estado,[2,3,5])) disabled @endif>
                                        <i class="mdi mdi-close-circle-outline me-1"></i> Cancelar
                                    </button>

                                </div>
                            </div>

                        </div> <!-- end col -->
                    </div> <!-- end row-->

                </div> <!-- end card-body-->
            </div> <!-- end card-->
        </div> <!-- end col-->
    </div>
    <!-- end row-->

@endsection

@section('js-styles-home')

<script>
    $(function(){

        $(document).on('click','#btnAsignar',function(e){
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: '¿Asignar Ticket?',
                text: "Se asignará este ticket a usted",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Sí, asignar'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('tickets.asignar',['id_tickets'=>':id']) }}".replace(':id',id),
                        type: 'POST',
                        data: { _token: "{{ csrf_token() }}", id_tickets:id },
                        success: function(res){
                            Swal.fire('¡Éxito!', res.message, 'success').then(() => {
                                window.location.href = "{{ route('index.tickets') }}"; 
                            });
                        },
                        error: function(err){
                            Swal.fire('Error',err.responseJSON.message,'error');
                        }
                    });
                }
            });
        });


        $(document).on('click','#btnCancelar',function(e){
            e.preventDefault();
            let id = $(this).data('id');

            Swal.fire({
                title: 'Motivo de cancelación',
                input: 'textarea',
                inputPlaceholder: 'Escriba el motivo...',
                showCancelButton: true,
                confirmButtonText: 'Cancelar Ticket',
                inputValidator: (value) => {
                    if (!value) {
                        return 'Debe ingresar un motivo';
                    }
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('tickets.cancelar',['id_tickets'=>':id']) }}".replace(':id',id),
                        type: 'POST',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id_tickets:id,
                            descripcion:result.value
                        },
                        success: function(res){
                            Swal.fire('¡Cancelado!',res.message,'success').then(()=> {
                                window.location.href = "{{ route('index.tickets') }}"; 
                            });
                        },
                        error: function(err){
                            Swal.fire('Error',err.responseJSON.message,'error');
                        }
                    });
                }
            });
        });

    });
</script>


@endsection
