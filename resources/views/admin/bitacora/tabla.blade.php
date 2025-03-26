<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaBitacora">
    <thead>
        <tr>
            <th>N°</th>
            <th>Actividad</th>
            <th>Doc. Referencial</th>
            <th>Fecha Reg.</th>
            <th>Estado</th>
            <th>Doc. Atención</th>
            <th>Fecha Aten.</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($miBitacoras as $Bitacora)
            <tr>
                <td><strong>{{ $loop->iteration }}</strong> </td>
                <td>{{ $Bitacora->actividad->nombre }}</td>
                <td>{{ $Bitacora->doc_ref }}</td>
                <td><strong>Registrado : </strong> <br>{{ $Bitacora->fecha_reg }}</td>
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $Bitacora->getEstadoClase() }}"> <!-- Usando el método de estado -->
                            <i class="{{ $Bitacora->getEstadoIcono() }}"></i> {{ $Bitacora->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
                <td>{{ $Bitacora->doc_aten }}</td>
                <td> <strong>Atendido : </strong> <br>{{ $Bitacora->fecha_aten }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);"class="action-icon text-primary rounded ver_actividad" data-id-actividad="{{ $Bitacora->id_bitacora }}">  
                        <i class="mdi mdi-file-eye" title="Visualizar"></i>
                    </a> 
                    @if ($Bitacora->estado == 1)
                        <a href="javascript: void(0);" class="action-icon text-info rounded editar_actividad" data-id-actividad="{{ $Bitacora->id_bitacora }}"> 
                            <i class="mdi mdi-file-document-edit" title="Editar Actividad"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_actividad" data-id-actividad="{{ $Bitacora->id_bitacora }}">
                            <i class="mdi mdi-file-remove" title="Eliminar Actividad"></i>
                        </a>
                        <a href="javascript: void(0);" class="action-icon text-success rounded atender_actividad" data-id-actividad="{{ $Bitacora->id_bitacora }}">
                            <i class="mdi mdi-check-network" title="Atender"></i>
                        </a>
                    @endif

                    @if ($Bitacora->estado == 2)
                        <a href="javascript: void(0);" class="action-icon text-danger rounded finalizar_actividad" data-id-actividad="{{ $Bitacora->id_bitacora }}">
                            <i class="mdi mdi-close-network" title="Finalizar Atención"></i>
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>

</table>