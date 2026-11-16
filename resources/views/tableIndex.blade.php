{{-- @foreach ($tickets as $ticket)
    <tr>
        <td>{{ $loop->iteration }}</td> 
        <td>{{ $ticket->oficinaPersonal->personal->nombre }} {{ $ticket->oficinaPersonal->personal->apellidoPaterno }}</td> 
        <td>{{ $ticket->oficinaPersonal->oficina->nombre }}</td>
        <td>{{ $ticket->soporte->nombre }}</td> 
        <td>{{ $ticket->descripcion }}</td> 
        {{-- <td>{{ $ticket->estado }}</td> 
        <td>
            @switch($ticket->estado)
                @case(1)
                    <span class="badge bg-primary text-white">
                        <i class="fas fa-file-alt"></i> Registrado
                    </span>
                    @break
                @case(2)
                    <span class="badge bg-warning text-dark">
                        <i class="fas fa-spinner"></i> En Proceso
                    </span>
                    @break
                @case(3)
                    <span class="badge bg-success text-white">
                        <i class="fas fa-check-circle"></i> Atendido
                    </span>
                    @break
                @case(4)
                    <span class="badge bg-secondary text-white">
                        <i class="fas fa-times-circle"></i> No logrado
                    </span>
                    @break
                @case(5)
                    <span class="badge bg-danger text-white">
                        <i class="fas fa-ban"></i> Cancelado
                    </span>
                    @break
                @default
                    <span class="badge bg-dark text-white">Desconocido</span>
            @endswitch
        </td>
        <td>{{ \Carbon\Carbon::parse($ticket->fecha_env)->format('d/m/Y H:i') }}</td>
    </tr>
@endforeach --}}

@forelse($tickets as $ticket)
    <tr>
        {{-- <td>{{ $loop->iteration }}</td> --}}
        <td>
            <span class="fw-bold font-monospace" style="color: #25549c;">{{ $ticket->id_ticket }}</span>
        </td>
        <td class="fw-semibold">
            {{ $ticket->oficinaPersonal->personal->nombre }} {{ $ticket->oficinaPersonal->personal->apellidoPaterno }} {{ $ticket->oficinaPersonal->personal->apellidoMaterno }}
        </td>
        <td><span class="text-muted" style="font-size: 12px;">{{ $ticket->oficinaPersonal->oficina->nombre }}</span></td>
        <td><span class="badge bg-light text-dark border">{{ $ticket->soporte->nombre }}</span></td>
        <td>{{ $ticket->descripcion }}</td>
        <td>
            @switch($ticket->estado)
                @case(1)
                    <span class="badge bg-primary text-white"><i class="fas fa-file-alt"></i> Registrado</span>
                @break

                @case(2)
                    <span class="badge bg-warning text-dark"><i class="fas fa-spinner"></i> En Proceso</span>
                @break

                @case(3)
                    <span class="badge bg-success text-white"><i class="fas fa-check-circle"></i> Atendido</span>
                @break

                @case(4)
                    <span class="badge bg-secondary text-white"><i class="fas fa-times-circle"></i> No logrado</span>
                @break

                @case(5)
                    <span class="badge bg-danger text-white"><i class="fas fa-ban"></i> Cancelado</span>
                @break

                @default
                    <span class="badge bg-dark text-white">Desconocido</span>
            @endswitch
        </td>
        <td class="text-muted" style="font-size: 12px;">
            {{ \Carbon\Carbon::parse($ticket->fecha_env)->format('d/m/Y H:i') }}
        </td>
        
        <td>
            @forelse($ticket->asignaciones as $asignacion)
                <span class="text-primary fw-semibold" style="font-size: 12.5px;"><i class="bi bi-person-badge me-1"></i>{{ $asignacion->usuario->nombre }} {{ $asignacion->usuario->apellidoPaterno }} {{ $asignacion->usuario->apellidoMaterno }}</span>
            @empty
            <span class="text-primary fw-semibold" style="font-size: 12.5px;">No hay asignaciones</span>
                <div>No hay asignaciones</div>
            @endforelse
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8">No se encontraron tickets.</td>
    </tr>
@endforelse
