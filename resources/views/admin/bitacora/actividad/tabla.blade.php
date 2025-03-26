<table id="alternative-page-datatable" class="table table-striped dt-responsive nowrap w-100 tablaActividad">
    <thead>
        <tr>
            <th>N°</th>
            <th>Nombre</th>
            <th>Descripción</th>
            <th>Opciones</th>
        </tr>
    </thead>


    <tbody>
        @foreach ($actividads as $actividad)
            <tr>
                <td><strong>{{ $loop->iteration }}</strong> </td>
                <td>{{ $actividad->nombre }}</td>
                <td>{{ $actividad->descripcion }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_act" data-id-act="{{ $actividad->id_actividad }}"> 
                        <i class="mdi mdi-playlist-edit" title="Editar Actividad"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_act" data-id-act="{{ $actividad->id_actividad }}">
                        <i class="mdi mdi-playlist-remove" title="Eliminar Actividad"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>