<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaUsuario">
    <thead>
        <tr>
            <th>DNI</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Usuario</th>
            <th>Tipo</th>
            <th>Teléfono</th>
            <th>Fecha</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($usuarios as $usuario)
            <tr>
                <td>{{ $usuario->dni }}</td>
                <td>{{ $usuario->nombre }}</td>
                <td>{{ $usuario->apellidoPaterno }} {{ $usuario->apellidoMaterno }}</td>
                <td>{{ $usuario->usuario }}</td>
                <td>{{ $usuario->tipo }}</td>
                <td>{{ $usuario->telefono }}</td>
                <td>{{ $usuario->created_at }}</td>
                <td class="table-action">
                    {{-- <a href="{{ route('ver.usuario',$usuario->id_usuario) }}"class="action-icon text-primary rounded visualizar_usuario"
                        data-id-usuario="{{ $usuario->id_usuario }}">  
                        <i class="mdi mdi-account-eye" title="Visualizar"></i>
                    </a> --}}
                    <a href="{{ route('ver.usuario',$usuario->id_usuario) }}"class="action-icon text-primary rounded visualizar_usuario"
                        data-id-usuario="{{ $usuario->id_usuario }}">  
                        <i class="mdi mdi-account-eye" title="Visualizar"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_usuario"
                        data-id-usuario="{{ $usuario->id_usuario }}"> 
                        <i class="mdi mdi-account-edit" title="Editar"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_usuario"
                        data-id-usuario="{{ $usuario->id_usuario }}">
                        <i class="mdi mdi-account-multiple-remove" title="Eliminar"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
