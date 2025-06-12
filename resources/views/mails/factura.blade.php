<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprobante de Pago</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        leaflight: '#f0f9f0',
                        leaflighest: '#f8fdf8',
                        leafdarkest: '#2d4a2d',
                        leafsecond: '#4a5d4a'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-leaflight p-5">
    <div class="max-w-2xl mx-auto bg-leaflighest border-2 border-leafsecond rounded-lg overflow-hidden shadow-lg">
        <!-- Header -->
        <div class="bg-leafdarkest text-white p-6 flex items-center justify-center gap-6">
            <div class="w-16 h-16 bg-white bg-opacity-20 rounded flex items-center justify-center text-xs text-gray-300">
                LOGO
            </div>
            <div class="text-center">
                <h1 class="text-2xl font-bold">EET 3107</h1>
                <h2 class="text-lg font-normal">Juana Azurduy de Padilla</h2>
            </div>
        </div>

        <!-- Content -->
        <div class="p-8">
            <!-- Información del Comprobante -->
            <div class="mb-8">
                <h3 class="bg-leafsecond text-white px-4 py-3 rounded mb-4 text-lg font-semibold">
                    Comprobante de Pago - Cooperadora
                </h3>
                <div class="grid grid-cols-2 gap-4 mb-6">
                    <div class="bg-white p-4 border border-slate-400 rounded">
                        <div class="font-bold text-leafdarkest text-sm mb-1">Fecha</div>
                        <div class="text-gray-800 text-base">{{ $ingreso->fecha ?? 'N/A' }}</div>
                    </div>
                    <div class="bg-white p-4 border border-slate-400 rounded">
                        <div class="font-bold text-leafdarkest text-sm mb-1">Hora</div>
                        <div class="text-gray-800 text-base">{{ $ingreso->hora ?? 'N/A' }}</div>
                    </div>
                    <div class="bg-white p-4 border border-slate-400 rounded">
                        <div class="font-bold text-leafdarkest text-sm mb-1">Alumno</div>
                        <div class="text-gray-800 text-base">{{ $ingreso->alumno->nombre ?? 'N/A' }} {{ $ingreso->alumno->apellido ?? '' }}</div>
                    </div>
                    <div class="bg-white p-4 border border-slate-400 rounded">
                        <div class="font-bold text-leafdarkest text-sm mb-1">Comprobante N°</div>
                        <div class="text-gray-800 text-base">#{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</div>
                    </div>
                </div>
            </div>

            <!-- Conceptos -->
            <div class="mb-8">
                <h3 class="bg-leafsecond text-white px-4 py-3 rounded mb-4 text-lg font-semibold">
                    Detalle de Conceptos
                </h3>
                <div class="bg-white border border-slate-400 rounded overflow-hidden">
                    <table class="w-full">
                        <thead>
                            <tr class="bg-leafsecond text-white">
                                <th class="px-4 py-3 text-left text-sm font-semibold">Concepto</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Cantidad</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Precio Unit.</th>
                                <th class="px-4 py-3 text-left text-sm font-semibold">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($ingreso->conceptos ?? false)
                                @foreach($ingreso->conceptos as $concepto)
                                    <tr class="border-b border-gray-200 last:border-b-0">
                                        <td class="px-4 py-3 text-gray-800">{{ $concepto->nombre ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-gray-800">{{ $concepto->pivot->cantidad ?? 'N/A' }}</td>
                                        <td class="px-4 py-3 text-gray-800">${{ number_format($concepto->importe ?? 0, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-800">${{ number_format($concepto->pivot->total_concepto ?? 0, 2) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="px-4 py-6 text-center text-gray-500">
                                        No hay conceptos registrados
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Total -->
            <div class="bg-leaflight border-2 border-leafsecond rounded-lg p-6 text-center">
                <div class="text-lg text-leafdarkest font-bold mb-2">TOTAL A PAGAR</div>
                <div class="text-4xl text-leafdarkest font-bold">${{ number_format($ingreso->importe_total ?? 0, 2) }}</div>
            </div>
        </div>

        <!-- Footer -->
        <div class="bg-leaflight text-center py-5 text-gray-600 text-sm border-t border-gray-300">
            Este comprobante fue generado automáticamente.<br>
            Para consultas, dirigirse a la administración de la cooperadora.
        </div>
    </div>
</body>
</html>