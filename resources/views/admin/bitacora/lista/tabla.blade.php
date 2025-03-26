<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaListBitacora">
    <thead>
        <tr>
            <th>N°</th>
            <th>Perosnal</th>
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
        @foreach ($listBitacoras as $listBitacora)
            <tr>
                <td><strong>{{ $loop->iteration }}</strong> </td>
                <td>{{ $listBitacora->usuario->nombre }} {{ $listBitacora->usuario->apellidoPaterno }} {{ $listBitacora->usuario->apellidoMaterno }}</td>
                <td>{{ $listBitacora->actividad->nombre }}</td>
                <td>{{ $listBitacora->doc_ref }}</td>
                <td><strong>Registrado : </strong> <br>{{ $listBitacora->fecha_reg }}</td>
                <td>
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ $listBitacora->getEstadoClase() }}"> <!-- Usando el método de estado -->
                            <i class="{{ $listBitacora->getEstadoIcono() }}"></i> {{ $listBitacora->getEstadoNombre() }}
                        </span>
                    </h5>
                </td>
                <td>{{ $listBitacora->doc_aten }}</td>
                <td> <strong>Atendido : </strong> <br>{{ $listBitacora->fecha_aten }}</td>
                <td class="table-action">
                    <a href="javascript: void(0);"class="action-icon text-primary rounded ver_actividad" data-id-actividad="{{ $listBitacora->id_bitacora }}">  
                        <i class="mdi mdi-file-eye" title="Visualizar"></i>
                    </a> 
                </td>
            </tr>
        @endforeach
    </tbody>

</table>