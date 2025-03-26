<table id="selection-datatable" class="table table-striped nowrap w-100 tablaTicketsAsigGeneral">
    <thead>
        <tr>
            <th>N°</th>
            <th>Incidencia</th>
            <th>Personal</th>
            <th>Usuario</th>
            <th>Fecha Asig.</th>
            <th>Fecha Fin.</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ticketsAsigGeneral as $ticketAsig => $row)
            <tr>
                <td scope ="row"><strong> {{ $ticketAsig + 1 }}</strong></td>
                <td>{{ $row->ticket->soporte->nombre ?? 'N/A' }}</td>
                <td>{{ $row->ticket->oficinaPersonal->personal->nombre . ' ' . $row->ticket->oficinaPersonal->personal->apellidoPaterno . ' ' . $row->ticket->oficinaPersonal->personal->apellidoMaterno ?? 'N/A' }}</td>
                <td>{{ $row->usuario->nombre }} {{ $row->usuario->apellidoPaterno }} {{ $row->usuario->apellidoMaterno }}</td>
                <td>{{ $row->fecha_asig }}</td>
                <td>{{ $row->fecha_fin }}</td>
                <td>{{ $row->descripcion }}</td>
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $row->getEstadoClase() }}"> <!-- Usando el método de estado -->
                            <i class="{{ $row->getEstadoIcono() }}"></i> {{ $row->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-primary rounded ver_ticketAsigGeneral"
                        data-id-ticketAsig="{{ $row->id_Asigticket }}"> 
                        <i class="mdi mdi-eye" title="Ver Asignación "></i>
                    </a>
                    {{-- <a href="javascript: void(0);" class="action-icon text-info rounded finalizar_personal"
                        data-id-ticketAsig="{{ $row->id_Asigticket }}"> 
                        <i class="mdi mdi-check-network" title="Finalizar Asignación"></i>
                    </a>  --}}
                    {{-- @if ($row->ticket->estado != '3' && $row->estado != '4' && $row->estado != '5' )
                        @if ($row->ticket->estado != '2')
                            <a href="javascript: void(0);" class="action-icon text-success rounded asignar_ticket"
                                data-id-ticketAsig="{{ $row->id_Asigticket }}"> 
                                <i class="mdi mdi-check-network" title="Asignar"></i>
                            </a>
                        @else
                            {{-- Obtener la asignación del usuario en sesión
                            @php
                                $asignacionUsuario = $row->where('id_usuario', Session::get('usuario')->id_usuario)->first();
                            @endphp

                            {{-- Verificar si la asignación del usuario en sesión tiene estado distinto de 4 
                            @if ($asignacionUsuario && $row->estado != '4')
                                <a href="javascript: void(0);" class="action-icon text-danger rounded finalizar_ticket"
                                    data-id-ticketAsig="{{ $row->ticket->id_ticket }}"> 
                                    <i class="mdi mdi-selection-ellipse-remove" title="Finalizar"></i>
                                </a>
                                <a href="javascript: void(0);" class="action-icon text-info rounded no_logrado_ticket"
                                    data-id-ticketAsig="{{ $row->ticket->id_ticket }}"> 
                                    <i class="mdi mdi-refresh-circle" title="No resuelto"></i>
                                </a>
                            @endif
                        @endif
                    @endif --}}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>