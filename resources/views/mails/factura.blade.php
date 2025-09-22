<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Pago</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto+Mono&display=swap');
        body { font-family: 'Roboto Mono', monospace; }
    </style>
</head>
<body class="bg-white p-5">
    <div class="max-w-md mx-auto bg-white border border-gray-300 rounded">
        <!-- Header -->
        <div class="bg-black text-white p-4 text-center">
            <h1 class="text-xl font-bold">RECIBO DE PAGO</h1>
            <h2 class="text-sm">EET 3107 - Juana Azurduy de Padilla</h2>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Información del Recibo -->
        <div class="p-4 border-b border-gray-300">
            <div class="flex justify-between mb-2">
                <span class="font-bold">Fecha:</span>
                <span>{{ $ingreso->fecha ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-bold">Hora:</span>
                <span>{{ $ingreso->hora ?? 'N/A' }}</span>
            </div>
            <div class="flex justify-between mb-2">
                <span class="font-bold">Alumno:</span>
                <span>{{ $ingreso->alumno->nombre ?? 'N/A' }} {{ $ingreso->alumno->apellido ?? '' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="font-bold">Recibo N°:</span>
                <span>#{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>

            <!-- Conceptos -->
        <div class="p-4 border-b border-gray-300">
            <h3 class="font-bold mb-2 text-center">DETALLE DE CONCEPTOS</h3>
            @if($ingreso->conceptos ?? false)
                @foreach($ingreso->conceptos as $concepto)
                    <div class="flex justify-between mb-1">
                        <span>{{ $concepto->nombre ?? 'N/A' }}</span>
                        <span>${{ number_format($concepto->pivot->total_concepto ?? 0, 2) }}</span>
                    </div>
                @endforeach
            @else
                <div class="text-center text-gray-500">No hay conceptos registrados</div>
            @endif
        </div>

            <!-- Total -->
        <div class="p-4 text-center">
            <div class="text-lg font-bold mb-1">TOTAL</div>
            <div class="text-2xl font-bold">${{ number_format($ingreso->importe_total ?? 0, 2) }}</div>
        </div>

        <!-- Footer -->
        <div class="bg-gray-100 text-center p-3 text-xs border-t border-gray-300">
            Recibo generado automáticamente
        </div>
    </div>
</body>
</html>