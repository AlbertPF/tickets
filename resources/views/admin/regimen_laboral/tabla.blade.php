<table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100 tablaRLaboral">
    <thead>
        <tr>
            <th>Número</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Opciones</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($rlaborals as $rlaboral => $row)
            <tr>
                <td scope ="row"><strong> {{ $rlaboral + 1 }}</strong></td>
                <td>{{ $row->nombre }}</td>
                <td>{{ $row->descripcion }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_rlaboral" data-id-rlaboral="{{ $row->id_rl }}"> 
                        <i class="mdi mdi-notebook-edit" title="Editar Régimen Laboral"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_rlaboral" data-id-rlaboral="{{ $row->id_rl }}">
                        <i class="mdi mdi-notebook-remove" title="Eliminar Régimen Laboral"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>