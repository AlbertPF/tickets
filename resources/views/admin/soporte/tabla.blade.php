<table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100 tablaIncidencia">
    <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Estado</th>
            <th>Opciones</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($incidencias as $incidencia => $row)
            <tr>
                <td scope ="row"><strong> {{ $incidencia + 1 }}</strong></td>
                <td>{{ $row->nombre }}</td>
                <td>{{ $row->descripcion }}</td>
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $row->getEstadoClase() }}">
                            <i class="{{ $row->getEstadoIcono() }}"></i> {{ $row->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_soporte" data-id-soporte="{{ $row->id_soporte }}"> 
                        <i class="mdi mdi-notebook-edit" title="Editar Incidencia"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_soporte" data-id-soporte="{{ $row->id_soporte }}">
                        <i class="mdi mdi-notebook-remove" title="Eliminar Incidencia"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>