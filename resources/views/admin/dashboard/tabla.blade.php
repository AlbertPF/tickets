<table id="datatable-buttons" class="table table-striped dt-responsive nowrap w-100 tablaDashboard">
    <thead>
        <tr>
            <th>Oficina</th>
            <th>Incidencia</th>
            <th>Personal</th>
            <th>Usuario Inf.</th>
            <th>Fecha Env.</th>
            <th>Fecha Asig.</th>
            <th>Fecha Fin.</th>
            <th>Estado</th>
        </tr>
    </thead>

    <tbody>
        @forelse ($asignacionUsu as $asignacion)
            <tr>
                <td>{{ $asignacion->ticket->oficinaPersonal->oficina->nombre ?? 'Sin oficina' }}</td>
                <td>{{ $asignacion->ticket->soporte->nombre }}</td>
                <td>{{ $asignacion->ticket->oficinaPersonal->personal->nombre }} {{ $asignacion->ticket->oficinaPersonal->personal->apellidoPaterno }}</td>
                <td>{{ $asignacion->usuario->nombre }} {{ $asignacion->usuario->apellidoPaterno }}</td>
                <td>{{ $asignacion->ticket->fecha_env }}</td>
                <td>{{ $asignacion->fecha_asig ? $asignacion->fecha_asig : 'No asignado' }}</td>
                <td>{{ $asignacion->fecha_fin ? $asignacion->fecha_fin : 'No finalizado' }}</td>
                {{-- <td>{{ $asignacion->estado == 1 ? 'Activo' : 'Inactivo' }}</td> --}}
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $asignacion->getEstadoClase() }}">
                            <i class="mdi mdi-check-circle-outline"></i> {{ $asignacion->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No se encontraron asignaciones de tickets.</td>
            </tr>
        @endforelse
    </tbody>
</table>