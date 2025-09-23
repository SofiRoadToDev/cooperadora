@php
function numeroATexto($numero) {
    $numero = floatval($numero);
    $entero = intval($numero);
    $decimales = intval(($numero - $entero) * 100);

    $unidades = array('', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve');
    $especiales = array('diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve');
    $decenas = array('', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa');
    $centenas = array('', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos');

    if ($entero == 0) return 'cero';

    $texto = '';

    // Miles
    if ($entero >= 1000) {
        $miles = intval($entero / 1000);
        if ($miles == 1) {
            $texto .= 'mil ';
        } else {
            $texto .= convertirCentenas($miles, $unidades, $especiales, $decenas, $centenas) . ' mil ';
        }
        $entero = $entero % 1000;
    }

    // Centenas, decenas y unidades
    $texto .= convertirCentenas($entero, $unidades, $especiales, $decenas, $centenas);

    return trim($texto);
}

function convertirCentenas($numero, $unidades, $especiales, $decenas, $centenas) {
    $texto = '';

    // Centenas
    if ($numero >= 100) {
        $c = intval($numero / 100);
        if ($numero == 100) {
            $texto .= 'cien ';
        } else {
            $texto .= $centenas[$c] . ' ';
        }
        $numero = $numero % 100;
    }

    // Decenas y unidades
    if ($numero >= 20) {
        $d = intval($numero / 10);
        $u = $numero % 10;
        if ($u == 0) {
            $texto .= $decenas[$d] . ' ';
        } else {
            $texto .= $decenas[$d] . ' y ' . $unidades[$u] . ' ';
        }
    } elseif ($numero >= 10) {
        $texto .= $especiales[$numero - 10] . ' ';
    } elseif ($numero > 0) {
        $texto .= $unidades[$numero] . ' ';
    }

    return $texto;
}
@endphp

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo de Cooperadora - Imprimir</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
    <style>
        #cuerpo::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('/images/escudo.png');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.1;
            filter: grayscale(100%);
            z-index: 0;
        }

        .print-hidden {
            display: none;
        }

        @media print {
            .no-print {
                display: none !important;
            }

            .print-hidden {
                display: block !important;
            }

            body {
                margin: 0;
                padding: 0;
            }
        }

        .btn-print {
            background: linear-gradient(135deg, #10b981, #059669);
            transition: all 0.3s ease;
        }

        .btn-print:hover {
            background: linear-gradient(135deg, #059669, #047857);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.4);
        }

        .btn-capture {
            background: linear-gradient(135deg, #3b82f6, #2563eb);
            transition: all 0.3s ease;
        }

        .btn-capture:hover {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(59, 130, 246, 0.4);
        }
    </style>
</head>
<body class="bg-gray-50 min-h-screen p-8">
    <div class="max-w-7xl mx-auto">
        <!-- Botones de acción -->
        <div class="mb-6 flex gap-4 justify-center no-print">
            <button onclick="capturarYImprimir()" class="btn-capture text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
               Imprimir
            </button>
            <button onclick="window.close()" class="bg-green-500 hover:bg-green-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <a href="{{ route('ingresos.email', $ingreso) }}">Enviar email</a>
            </button>
            <button onclick="window.close()" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-3 rounded-lg font-semibold flex items-center gap-2">
                <i class="fas fa-times"></i>
                Cerrar
            </button>
        </div>

        <!-- Recibo -->
        <div id="recibo" class="grid grid-cols-4 border border-black min-h-[500px] mx-auto my-2 w-3/4 bg-white shadow-lg">
            <div class="col-1 flex flex-col items-center bg-blue-100 p-5">
                <p class="text-center font-semibold">EET3107</p>
                <p class="text-center mb-6 font-semibold">Juana Azurduy de Padilla</p>
                <img src="/images/escudo.png" alt="Escudo" class="mb-4">
                <p class="text-center mb-6 font-semibold">Comprobante Nº</p>
                <p class="text-center mb-6 font-semibold">{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div id="cuerpo" class="relative col-span-3 border-l border-black bg-white p-5 flex flex-col">
                <div class="relative z-10 flex flex-col h-full">
                    <p class="text-center text-2xl mb-5 font-bold">Comprobante de Aporte a Cooperadora Escolar</p>
                    <p class="text-right mb-5 text-lg">Salta, {{ $ingreso->fecha ? \Carbon\Carbon::parse($ingreso->fecha)->locale('es')->translatedFormat('d \d\e F \d\e Y') : 'N/A' }}</p>
                    <p class="text-left mb-5 text-lg">Recibí de {{ $ingreso->alumno->apellido ?? 'N/A' }} {{ $ingreso->alumno->nombre ?? '' }}</p>
                    <p class="text-left mb-5 text-lg">DNI: {{ $ingreso->alumno->dni ?? 'N/A' }}</p>
                    <p class="text-left mb-5 text-lg">la suma de {{ numeroATexto($ingreso->importe_total ?? 0, 2, ',', '.') }} pesos </p>

                    @if($ingreso->conceptos && $ingreso->conceptos->count() > 0)
                        <p class="text-left mb-3 text-lg">En concepto de:</p>
                        <div class="mb-5">
                            @foreach($ingreso->conceptos as $concepto)
                                <p class="text-left text-base">
                                    • {{ $concepto->nombre }} (Cant: {{ $concepto->pivot->cantidad }}) - ${{ number_format($concepto->pivot->total_concepto ?? 0, 2, ',', '.') }}
                                </p>
                            @endforeach
                        </div>
                    @else
                        <p class="text-left mb-5 text-lg">En concepto de: Aporte general</p>
                    @endif

                    <div id="bottom" class="border-t border-black p-2 flex justify-between px-7 mt-auto">
                        <div>
                            <p class="text-left mb-3 text-lg">Son <strong>$ {{ $ingreso->importe_total ?? 0 }}</strong></p>
                            @if($ingreso->email)
                                <p class="text-left text-sm">Email: {{ $ingreso->email }}</p>
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

        <!-- Información adicional (solo visible en pantalla) -->
        <div class="mt-6 text-center text-gray-600 no-print">
            <p class="text-sm">
                <i class="fas fa-info-circle"></i>
                Usa "Imprimir Directamente" para imprimir todo o "Capturar e Imprimir" para capturar solo el recibo
            </p>
        </div>
    </div>

    <script>

        async function capturarYImprimir() {
            try {
                const recibo = document.getElementById('recibo');

                // Configuración para html2canvas
                const canvas = await html2canvas(recibo, {
                    scale: 2, // Mayor calidad
                    useCORS: true,
                    allowTaint: true,
                    backgroundColor: '#ffffff',
                    width: recibo.offsetWidth,
                    height: recibo.offsetHeight
                });

                // Crear nueva ventana para imprimir
                const printWindow = window.open('', '_blank');
                const imgData = canvas.toDataURL('image/png');

                printWindow.document.write(`
                    <html>
                        <head>
                            <title>Imprimir Recibo</title>
                            <style>
                                body {
                                    margin: 0;
                                    padding: 20px;
                                    display: flex;
                                    justify-content: center;
                                    align-items: center;
                                    min-height: 100vh;
                                }
                                img {
                                    max-width: 100%;
                                    height: auto;
                                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                                }
                                @media print {
                                    body { padding: 0; }
                                    img {
                                        max-width: none;
                                        width: 100%;
                                        box-shadow: none;
                                    }
                                }
                            </style>
                        </head>
                        <body>
                            <img src="${imgData}" alt="Recibo">
                        </body>
                    </html>
                `);

                printWindow.document.close();

                // Esperar a que cargue la imagen y luego imprimir
                printWindow.onload = function() {
                    setTimeout(() => {
                        printWindow.print();
                        printWindow.close();
                    }, 500);
                };

            } catch (error) {
                console.error('Error capturando el recibo:', error);
                alert('Error al capturar el recibo. Intenta con "Imprimir Directamente".');
            }
        }
    </script>
</body>
</html>