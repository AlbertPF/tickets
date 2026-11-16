<table id="basic-datatable" class="table table-striped nowrap w-100 tablaAsig">
    <thead>
        <tr>
            <th>Personal</th>
            <th>Oficina</th>
            <th>Año</th>
            <th>Estado</th>
            <th>Fecha</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($ofiPersonals as $ofiPersonal)
            <tr>
                <td>{{ $ofiPersonal->personal->nombre }} {{ $ofiPersonal->personal->apellidoPaterno }} {{ $ofiPersonal->personal->apellidoMaterno }}</td>
                <td>{{ $ofiPersonal->oficina->nombre }}</td>
                <td>{{ $ofiPersonal->anio }}</td>
                <td>
                    @if($ofiPersonal->estado == 1)
                        <h5 style="margin: 0px 0 !important;"><span class="badge badge-success-lighten"><i class="mdi mdi-check-circle"></i> Activo</span></h5>
                    @else
                        <h5 style="margin: 0px 0 !important;"><span class="badge badge-danger-lighten"><i class="mdi mdi-cancel"></i> Inactivo</span></h5>
                    @endif
                </td>
                <td>
                    {{ \Carbon\Carbon::parse($ofiPersonal->created_at)->format('d/m/Y') }}<br>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($ofiPersonal->created_at)->format('H:i:s') }}</small>
                </td>
            </tr>
        @endforeach
    </tbody>

</table>