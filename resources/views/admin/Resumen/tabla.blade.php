<table id="alternative-page-datatable" class="table table-striped nowrap w-100 tablaActGeneral"> 
    <thead>
        <tr>
            <th>N°</th>
            <th>Usuario</th>
            <th>Actividad</th>
            <th>Descripción</th> 
            <th>Fecha Reg.</th>
            <th>Estado</th>
            <th>FechaDoc.</th>
        </tr>
    </thead>

    <tbody>
        @foreach ($actGeneral as $index => $bitacora)
            <tr>
                <td><strong>{{ $index + 1 }}</strong></td>
                <td>{{ $bitacora->Usuario }}</td>
                <td>{{ $bitacora->Incidencia }}</td>
                <td>{{ $bitacora->Descripción }}</td> <!-- Descripción -->
                <td><strong>Registrado : </strong><br>{{ $bitacora->Fecha_reg }}</td>
                <td>
                    {{-- {{ $bitacora->Estado }} --}}
                    <h5 style="margin: 0px 0 !important;">
                        <span class="badge {{ getEstadoClase($bitacora->Estado) }}"> 
                            <i class="{{ getEstadoIcono($bitacora->Estado) }}"></i> 
                            {{ getEstadoNombre($bitacora->Estado) }}
                        </span>
                    </h5>
                </td>
                <td><strong>Atendido : </strong><br>{{ $bitacora->Fecha_aten }}</td>
            </tr>
        @endforeach
    </tbody>
</table>