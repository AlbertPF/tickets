<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Tickets | Asistencia Técnica - Gobierno Regional Apurímac</title>
    <link rel="shortcut icon" href="{{ public_path('Images/Gore/PNG - GOREAPU  (Vertical).png') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 110px 40px 60px 40px;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 120px;
            text-align: center;
        }

        .footer {
            position: fixed;
            bottom: 0px;
            left: 0px;
            right: 0px;
            height: 60px;
            font-size: 11px;
            line-height: 1.2;
            background-color: white;
        }


        .content {
            margin-top: 10px;
        }


        .header img.logo-left {
            margin-right: 0px;
        }

        .header img.logo-right {
            margin-left: 0px;
        }

        .header h3 {
            font-size: 16px;
            margin: 0;
        }

        .header p.lvl-1 {
            font-size: 13px;
            margin: 2px 0;
        }

        .header p.lvl-2 {
            font-size: 11px;
            margin: 2px 0;
        }

        .header p.motto {
            font-size: 11px;
            font-style: italic;
            margin: 6px 0 0 0;
        }

        .line-blue {
            width: 40%;
            height: 2px;
            background-color: #007bff;
            margin: 4px auto;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-left {
            width: 60%;
            text-align: left;
            padding-right: 10px;
        }

        .footer-separator {
            width: 1px;
            background-color: #0e73df;
        }

        .footer-right {
            width: 39%;
            text-align: right;
            padding-left: 10px;
        }

        .section {
            margin-top: 10px;
            padding: 0px 20px;
            border: 1px solid #e0e0e0;
            border-radius: 6px;
            background-color: #f9f9f9;
        }

        .section h4.section-title {
            text-align: center;
            margin-bottom: 15px;
            font-size: 14px;
            text-transform: uppercase;
        }

        .section h4 {
            font-size: 15px;
            text-align: center;
            text-transform: uppercase;
            margin-bottom: 15px;
            color: #0a4a94;
            border-bottom: 2px solid #0a4a94;
            padding-bottom: 5px;
        }

        .label {
            font-weight: bold;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .value {
            margin-left: 10px;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table {
            width: 100%;
        }

        td {
            vertical-align: middle;
        }

        table td {
            padding: 6px 10px;
            vertical-align: top;
            border-bottom: 1px solid #ddd;
        }

        table tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        .label {
            font-weight: bold;
            color: #333;
            width: 35%;
            white-space: nowrap;
        }

        .value {
            color: #444;
        }

        .titulo-principal {
            font-size: 18px;
            font-weight: bold;
            margin: 0;
        }

        .subtitulo-1 {
            font-size: 12px;
            margin: 2px 0;
        }

        .subtitulo-2 {
            font-size: 10px;
            margin: 2px 0;
        }

        .linea-azul {
            width: 60%;
            height: 2px;
            background-color: #0a4a94;
            margin: 6px auto;
        }

        .linea-azul-footer {
            background-color: #0a4a94;
            width: 2px;
            height: 80%;  
            padding: 0;
        }

        .motto {
            font-size: 9px;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header">
        <table width="100%">
            <tr>
                <td style="width: 20%; text-align: left;">
                    <img class="logo-left" src="{{ public_path('Images/Gore/PNG - PERU.png') }}" height="80">
                </td>

                <td style="width: 60%; text-align: center;">
                    <h2 class="titulo-principal">GOBIERNO REGIONAL DE APURÍMAC</h2>
                    <p class="subtitulo-1">Gerencia de Planeamiento, Presupuesto y Acondicionamiento Territorial</p>
                    <p class="subtitulo-2">Sub Gerencia de Desarrollo Institucional, Estadística e Informática</p>

                    <div class="linea-azul"></div>

                    <p class="motto">“Año de la recuperación y consolidación de la economía peruana”</p>
                </td>

                <td style="width: 20%; text-align: right;">
                    <img class="logo-right" src="{{ public_path('Images/Gore/PNG - GORE ANTIGUO.png') }}" height="80">
                </td>
            </tr>
        </table>
    </div>


    <div class="section">
        <h4 class="section-title">Datos del Ticket</h4>
        <table>
            <tr>
                <td><span class="label">Código Ticket:</span></td>
                <td>{{ strtoupper($ticketsAsig->ticket->id_ticket) }}</td>
            </tr>
            <tr>
                <td><span class="label">Tipo de Incidencia:</span></td>
                <td>{{ $ticketsAsig->ticket->soporte->nombre }}</td>
            </tr>
            <tr>
                <td><span class="label">Descripción:</span></td>
                <td>{!! nl2br(e($ticketsAsig->ticket->descripcion)) !!}</td>
            </tr>
            <tr>
                <td><span class="label">Estado:</span></td>
                <td>{{ $ticketsAsig->ticket->getEstadoNombre() }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Datos del Personal</h4>
        <table>
            <tr>
                <td><span class="label">Nombres y Apellidos:</span></td>
                <td>{{ $ticketsAsig->ticket->oficinaPersonal->personal->nombre }} {{ $ticketsAsig->ticket->oficinaPersonal->personal->apellidoMaterno }} {{ $ticketsAsig->ticket->oficinaPersonal->personal->apellidoMaterno }}</td>
            </tr>
            <tr>
                <td><span class="label">Teléfono:</span></td>
                <td>{{ $ticketsAsig->ticket->oficinaPersonal->personal->telefono }}</td>
            </tr>
            <tr>
                <td><span class="label">Oficina:</span></td>
                <td>{{ $ticketsAsig->ticket->oficinaPersonal->oficina->nombre }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Fechas</h4>
        <table>
            <tr>
                <td><span class="label">Fecha de Envío:</span></td>
                <td>{{ \Carbon\Carbon::parse($ticketsAsig->ticket->fecha_env)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><span class="label">Fecha de Asignación:</span></td>
                <td>{{ \Carbon\Carbon::parse($ticketsAsig->fecha_asig)->format('d/m/Y H:i') }}</td>
            </tr>
            <tr>
                <td><span class="label">Fecha de Finalización:</span></td>
                <td>{{ \Carbon\Carbon::parse($ticketsAsig->fecha_fin)->format('d/m/Y H:i') }}</td>
            </tr>
        </table>
    </div>

    <div class="section">
        <h4>Datos del Usuario Informático</h4>
        <table>
            <tr>
                <td><span class="label">Nombres y Apellidos:</span></td>
                <td>{{ $ticketsAsig->usuario->nombre }} {{ $ticketsAsig->usuario->apellidoPaterno }} {{ $ticketsAsig->usuario->apellidoMaterno }}</td>
            </tr>
            <tr>
                <td><span class="label">Informe del Usuario Informático:</span></td>
                <td>{!! nl2br(e($ticketsAsig->descripcion)) !!}</td>
            </tr>
        </table>
    </div>

    <div class="footer">
        <table width="100%" style="border-collapse: collapse; font-size: 11px;">
            <tr>

                <td style="width: 70%; text-align: left; padding-right: 10px;">
                    <strong>Generado por el Sistema de Tickets | Asistencia Técnica <br> Unidad Informática</strong>
                </td>

                <td class="linea-azul-footer"></td>

                <td style="width: 29%; text-align: right; padding-left: 10px;">
                    <img src="{{ public_path('Images/Gore/PNG - GOREAPU  (Horizontal).png') }}" height="50">
                </td>
            </tr>
        </table>
    </div>

</body>
</html>