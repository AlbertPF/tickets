<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaOficina">
    <thead>
        <tr>
            <th>Código</th>
            <th>Oficina</th>
            <th>Oficina Padre</th>
            <th>Año</th>
            <th>Descripción</th>
            <th>Fecha</th>
            <th>Opción</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($oficinas as $oficina)
            <tr>
                <td><strong> {{ $oficina->codigo }}</strong></td>
                <td>{{ $oficina->nombre }}</td>
                <td>{{ $oficina->oficinasPadre ? $oficina->oficinasPadre->nombre : 'No tiene' }}</td>
                <td>{{ $oficina->anio }}</td>
                <td>{{ $oficina->descripcion }}</td>
                <td> <strong>publicado : </strong> <br>{{ $oficina->created_at }}</td>
                <td class="table-action">
                    {{-- <a href="{{ route('ver.usuario',$usuario->id_usuario) }}"class="action-icon text-primary rounded">  
                        <i class="mdi mdi-account-eye" title="Visualizar"></i>
                    </a> --}}
                    <a href="javascript: void(0);" class="action-icon text-info rounded editar_oficina" data-id-oficina="{{ $oficina->id_oficina }}"> 
                        <i class="mdi mdi-notebook-edit" title="Editar Categoria"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_oficina" data-id-oficina="{{ $oficina->id_oficina }}">
                        <i class="mdi mdi-notebook-remove" title="Eliminar Categoria"></i>
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>