<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaTickets">
    <thead>
        <tr>
            <th>N°</th>
            <th>Código</th>
            <th>Personal</th>
            <th>Incidencia</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Fecha Envío</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($tickets as $ticket => $row)
            <tr>
                <td scope ="row"><strong> {{ $ticket + 1 }}</strong></td>
                <td> <strong>{{ $row->id_ticket }}</strong></td>
                <td>{{ $row->oficinaPersonal->personal->nombre }} {{ $row->oficinaPersonal->personal->apellidoPaterno }} {{ $row->oficinaPersonal->personal->apellidoMaterno }}</td>
                <td>{{ $row->soporte->nombre }}</td>
                <td>{{ $row->descripcion }}</td>
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $row->getEstadoClase() }}">
                            <i class="{{ $row->getEstadoIcono() }}"></i> {{ $row->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
                <td>{{ $row->fecha_env }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-primary rounded ver_tickets"
                        data-id-ticket="{{ $row->id_ticket }}"> 
                        <i class="mdi mdi-eye" title="Ver Ticket"></i>
                    </a>
                    {{-- <a href="javascript: void(0);" class="action-icon text-info rounded asignar_ticket"
                        data-id-ticket="{{ $row->id_ticket }}"> 
                        <i class="mdi mdi-check-network" title="Asignar"></i>
                    </a> --}}

                    @if ($row->estado != '5')
                        @if ($row->estado != '3')
                            @if ($row->estado != '2')
                                <a href="javascript: void(0);" class="action-icon text-success rounded asignar_ticket"
                                    data-id-ticket="{{ $row->id_ticket }}"> 
                                    <i class="mdi mdi-check-network" title="Asignar"></i>
                                </a>
                                <a href="javascript: void(0);" class="action-icon text-danger rounded cancelar_ticket"
                                    data-id-ticket="{{ $row->id_ticket }}"> 
                                    <i class="mdi mdi-close-network" title="Cancelar"></i>
                                </a>
                                @if(Session::has('usuario') && Session::get('usuario')->tipo === 'Administrador')
                                    <a href="javascript: void(0);" class="action-icon text-info rounded ModalAsignar_tickets"
                                        data-id-ticket="{{ $row->id_ticket }}"> 
                                        <i class="mdi mdi-account-details" title="Asignar Perosnal"></i>
                                    </a>
                                @endif
                            @else
                                {{-- Obtener la asignación del usuario en sesión --}}
                                @php
                                    $asignacion = $row->asignaciones->where('id_usuario', Session::get('usuario')->id_usuario)->first();
                                @endphp

                                {{-- Verificar si existe la asignación y si el estado no es 4 (No resuelto) --}}
                                @if ($asignacion && $asignacion->estado != 4)
                                    <a href="javascript: void(0);" class="action-icon text-danger rounded finalizar_ticket"
                                        data-id-ticket="{{ $row->id_ticket }}"> 
                                        <i class="mdi mdi-selection-ellipse-remove" title="Finalizar"></i>
                                    </a>
                                    <a href="javascript: void(0);" class="action-icon text-info rounded no_resuelto_ticket"
                                        data-id-ticket="{{ $row->id_ticket }}"> 
                                        <i class="mdi mdi-refresh-circle" title="No resuelto"></i>
                                    </a>
                                @endif
                            @endif
                        @endif
                    @endif

                    {{-- Mostrar el botón de asignar solo si el ticket no está asignado (estado != 2) --}}
                    {{-- @if ($row->estado != '3')
                        @if ($row->estado != '2')
                            <a href="javascript: void(0);" class="action-icon text-success rounded asignar_ticket"
                                data-id-ticket="{{ $row->id_ticket }}"> 
                                <i class="mdi mdi-check-network" title="Asignar"></i>
                            </a>
                        @else
                            -- Mostrar botones de finalizar y no logrado solo para el usuario que asignó el ticket
                            @if ($row->asignaciones->where('id_usuario', Session::has('usuario')==true?Session::get('usuario')->id_usuario:null)->count() > 0)
                                <a href="javascript: void(0);" class="action-icon text-danger rounded finalizar_ticket"
                                    data-id-ticket="{{ $row->id_ticket }}"> 
                                    <i class="mdi mdi-close-network" title="Finalizar"></i>
                                </a>
                                <a href="javascript: void(0);" class="action-icon text-info rounded no_resuelto_ticket"
                                    data-id-ticket="{{ $row->id_ticket }}"> 
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