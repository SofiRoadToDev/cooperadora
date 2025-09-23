<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Cooperadora</title>
    <style>
        /* Estilos CSS para PDFs - Compatible con DOMPDF */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            color: #000;
        }

        /* Grid system */
        .grid {
            display: table;
            width: 100%;
        }

        .grid-cols-4 {
            display: table;
            width: 100%;
        }

        .col-1 {
            display: table-cell;
            width: 25%;
            vertical-align: top;
        }

        .col-span-3 {
            display: table-cell;
            width: 75%;
            vertical-align: top;
        }

        /* Borders */
        .border {
            border: 1px solid #000;
        }

        .border-black {
            border: 1px solid #000;
        }

        .border-l {
            border-left: 1px solid #000;
        }

        /* Backgrounds */
        .bg-blue-100 {
            background-color: #dbeafe;
        }

        .bg-white {
            background-color: #ffffff;
        }

        /* Padding */
        .p-2 {
            padding: 8px;
        }

        .p-5 {
            padding: 20px;
        }

        .px-7 {
            padding-left: 28px;
            padding-right: 28px;
        }

        /* Margins */
        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .my-2 {
            margin-top: 8px;
            margin-bottom: 8px;
        }

        .mb-5 {
            margin-bottom: 20px;
        }

        .mb-6 {
            margin-bottom: 24px;
        }

        .mt-auto {
            margin-top: auto;
        }

        /* Text alignment */
        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        /* Font sizes */
        .text-lg {
            font-size: 18px;
            line-height: 1.4;
        }

        .text-2xl {
            font-size: 24px;
            line-height: 1.3;
        }

        /* Font weight */
        .font-bold {
            font-weight: bold;
        }

        .font-semibold {
            font-weight: 600;
        }

        /* Width */
        .w-1-2 {
            width: 50%;
        }

        /* Height */
        .min-h-500 {
            min-height: 500px;
        }

        /* Flexbox */
        .flex {
            display: flex;
        }

        .flex-col {
            flex-direction: column;
        }

        .items-center {
            align-items: center;
        }

        .justify-between {
            justify-content: space-between;
        }

        .h-full {
            height: 100%;
        }

        /* Position */
        .relative {
            position: relative;
        }

        /* Z-index */
        .z-10 {
            z-index: 10;
        }

        /* Images */
        img {
            max-width: 100%;
            height: auto;
        }

        /* Conceptos table */
        .conceptos-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }

        .conceptos-table th,
        .conceptos-table td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        .conceptos-table th {
            background-color: #f3f4f6;
            font-weight: bold;
        }

        /* Background with watermark */
        #cuerpo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('{{ public_path('escudo.png') }}');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.1;
            filter: grayscale(100%);
            z-index: 0;
        }

        /* Bottom section */
        #bottom {
            border-top: 1px solid #000;
            margin-top: auto;
        }
    </style>
</head>
<body>
    <div class="grid grid-cols-4 border border-black min-h-500 mx-auto my-2 w-1-2">
        <div class="col-1 flex flex-col items-center bg-blue-100 p-5">
            <p class="text-center font-semibold">EET3107</p>
            <p class="text-center mb-6 font-semibold">Juana Azurduy de Padilla</p>
            <img src="{{ public_path('escudo.png') }}" alt="Escudo">
            <p class="text-center mb-6 font-semibold">Comprobante Nº</p>
            <p class="text-center mb-6 font-semibold">{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div id="cuerpo" class="relative col-span-3 border-l border-black bg-white p-5 flex flex-col">
            <div class="relative z-10 flex flex-col h-full">
                <p class="text-center text-2xl mb-5 font-bold">Comprobante de Aporte a Cooperadora Escolar</p>
                <p class="text-right mb-5 text-lg">Salta, {{ $ingreso->fecha ? \Carbon\Carbon::parse($ingreso->fecha)->locale('es')->translatedFormat('d \d\e F \d\e Y') : '' }}</p>
                <p class="text-left mb-5 text-lg">
                    Recibí de <strong>{{ $ingreso->alumno->apellido ?? 'N/A' }}, {{ $ingreso->alumno->nombre ?? '' }}</strong>
                </p>
                <p class="text-left mb-5 text-lg">
                    DNI: <strong>{{ $ingreso->alumno->dni ?? 'N/A' }}</strong>
                </p>
                <p class="text-left mb-5 text-lg">
                    la suma de <strong>${{ number_format($ingreso->importe_total ?? 0, 2, ',', '.') }}</strong>
                </p>

                <!-- Tabla de conceptos -->
                @if($ingreso->conceptos && $ingreso->conceptos->count() > 0)
                <p class="text-left mb-5 text-lg">En concepto de:</p>
                <table class="conceptos-table">
                    <thead>
                        <tr>
                            <th>Concepto</th>
                            <th>Cantidad</th>
                            <th>Precio Unit.</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ingreso->conceptos as $concepto)
                        <tr>
                            <td>{{ $concepto->nombre }}</td>
                            <td>{{ $concepto->pivot->cantidad }}</td>
                            <td>${{ number_format($concepto->importe ?? 0, 2, ',', '.') }}</td>
                            <td>${{ number_format($concepto->pivot->total_concepto ?? 0, 2, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <p class="text-left mb-5 text-lg">En concepto de: <strong>Aporte general</strong></p>
                @endif

                <div id="bottom" class="border-black p-2 flex justify-between px-7 mt-auto">
                    <div>
                        <p class="text-left mb-5 text-lg">
                            Son: <strong>${{ number_format($ingreso->importe_total ?? 0, 2, ',', '.') }} pesos</strong>
                        </p>
                        @if($ingreso->email)
                        <p class="text-left text-lg">Email: {{ $ingreso->email }}</p>
                        @endif
                    </div>
                    <div class="text-center">
                        <p class="text-lg mb-5">_________________________</p>
                        <p class="text-lg">Firma y Sello</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>