<!DOCTYPE html>
<html>
<head>
    <title>Reporte de Uso de Puertas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #333;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }
        .header p {
            text-align: left;
            margin: 0 50px;
        }
        .container {
            margin: 20px 50px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .employee-section {
            margin-bottom: 30px;
            page-break-inside: avoid;
        }
        .employee-name {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 10px;
            background-color: #eee;
            padding: 5px;
        }
        .date-section {
            margin-bottom: 10px;
            background-color: #ddd;
            padding: 5px;
            font-weight: bold;
        }
        .link {
            color: #3490dc;
            text-decoration: none;
        }
        .footer {
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 30px;
            font-size: 10px;
            padding: 10px 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid #ddd;
        }
        .footer .page-number:before {
            content: "Página " counter(page);
        }
        @page {
            margin: 30px;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2>Reporte de asistencias</h2>
        <p>Periodo de: {{ $fechaInicio }} a {{ $fechaFin }}</p>
        <p>Fecha de consulta: {{ $fechaConsulta }} | Usuario de consulta: {{ $usuario }}</p>
    </div>

    <div class="container">
        @foreach($usoPuertas as $empleado => $registros)
            <div class="employee-section">
                <div class="employee-name">NOMBRE: {{ $empleado }}</div>
                @php
                    $currentDate = '';
                @endphp
                @foreach($registros as $registro)
                    @if($currentDate != Carbon\Carbon::parse($registro->Fecha)->toDateString())
                        @if($currentDate != '')
                            </table>
                        @endif
                        <div class="date-section">FECHA: {{ Carbon\Carbon::parse($registro->Fecha)->toDateString() }}</div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Puerta</th>
                                    <th>Tipo</th>
                                    <th>Fecha y Hora</th>
                                    <th>URL de la Imagen</th>
                                    <th>URL de Google Maps</th>
                                </tr>
                            </thead>
                            <tbody>
                    @php
                        $currentDate = Carbon\Carbon::parse($registro->Fecha)->toDateString();
                    @endphp
                    @endif
                                <tr>
                                    <td>{{ $registro->NombrePuerta }}</td>
                                    <td>{{ $registro->Tipo }}</td>
                                    <td>{{ $registro->Fecha }}</td>
                                    <td><a href="{{ asset('https://pactral.com/PuntoAcceso/public/' . $registro->img) }}" class="link" target="_blank">Ver imagen</a></td>
                                    <td><a href="https://www.google.com/maps/search/?api=1&query={{ $registro->latitude }},{{ $registro->longitud }}" class="link" target="_blank">Ver mapa</a></td>
                                </tr>
                @endforeach
                            </tbody>
                        </table>
            </div>
        @endforeach
    </div>

    <div class="footer">
        <p>Esta página fue tomada del sistema Punto Acceso</p>
        <p><span class="page-number"></span> | Hora de descarga: {{ $fechaConsulta }}</p>
    </div>

    <script type="text/php">
        if ( isset($pdf) ) { 
            $pdf->page_text(270, 770, "Página {PAGE_NUM} de {PAGE_COUNT}", null, 10);
        }
    </script>
</body>
</html>
