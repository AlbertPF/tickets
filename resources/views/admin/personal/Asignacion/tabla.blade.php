<table id="alternative-page-datatable" class="table table-striped nowrap w-100">
    <thead>
        <tr>
            <th>Personal</th>
            <th>Oficina</th>
            <th>Año</th>
            <th>Estado</th>
            <th>Fecha</th>
            {{-- <th>Opciones</th> --}}
        </tr>
    </thead>

    <tbody>
        @foreach ($ofiPersonals as $ofiPersonal)
            <tr>
                <td>{{ $ofiPersonal->personal->nombre }} {{ $ofiPersonal->personal->apellidoPaterno }}</td>
                <td>{{ $ofiPersonal->oficina->nombre }}</td>
                <td>{{ $ofiPersonal->anio }}</td>
                <td>
                    @if($ofiPersonal->estado == 1)
                        <h5 style="margin: 0px 0 !important;"><span class="badge badge-success-lighten"><i class="mdi mdi-check-circle"></i> Activo</span></h5>
                    @else
                        <h5 style="margin: 0px 0 !important;"><span class="badge badge-danger-lighten"><i class="mdi mdi-cancel"></i> Inactivo</span></h5>
                    @endif
                </td>
                <td>{{ $ofiPersonal->created_at }}</td>
                {{-- <td class="table-action">
                    <a href="javascript: void(0);" class="action-icon text-info rounded editarAsig_personal"
                        data-id-personal="{{ $ofiPersonal->id_personal }}"> 
                        <i class="mdi mdi-account-edit" title="Editar"></i>
                    </a>
                    <a href="javascript: void(0);" class="action-icon text-danger rounded eliminar_personal"
                        data-id-personal="{{ $ofiPersonal->id_personal }}">
                        <i class="mdi mdi-account-multiple-remove" title="Eliminar"></i>
                    </a>
                </td> --}}
            </tr>
        @endforeach
    </tbody>

</table>