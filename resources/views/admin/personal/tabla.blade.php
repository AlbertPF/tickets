<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaUsuario">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Regimen Laboral</th>
            <th>Teléfono</th>
            <th>Fecha</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($personals as $personal)
            <tr>
                <td>{{ $personal->dni }}</td>
                <td>{{ $personal->nombre }}</td>
                <td>{{ $personal->apellidoPaterno }} {{ $personal->apellidoMaterno }}</td>
                <td>{{ $personal->regimenLaboral->nombre ?? 'Sin asignar' }}</td>
                <td>{{ $personal->telefono }}</td>
                <td>{{ $personal->created_at }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-info rounded ver_personal"
                        data-id-personal="{{ $personal->id_personal }}"> 
                        <i class="mdi mdi-account-eye" title="Ver personal"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_personal"
                        data-id-personal="{{ $personal->id_personal }}"> 
                        <i class="mdi mdi-account-edit" title="Editar"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_personal"
                        data-id-personal="{{ $personal->id_personal }}">
                        <i class="mdi mdi-account-multiple-remove" title="Eliminar"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
