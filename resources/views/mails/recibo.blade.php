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
    <title>Comprobante de Cooperadora</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            border: 2px solid #333;
            display: grid;
            grid-template-columns: 1fr 3fr;
        }
        .sidebar {
            background-color: #e6f3ff;
            padding: 20px;
            text-align: center;
            border-right: 2px solid #333;
        }
        .content {
            padding: 20px;
            position: relative;
        }
        .content::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="40" fill="none" stroke="lightgray" stroke-width="2" opacity="0.1"/></svg>');
            background-repeat: no-repeat;
            background-position: center;
            background-size: contain;
            opacity: 0.1;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        .footer {
            border-top: 2px solid #333;
            padding-top: 15px;
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            align-items: end;
        }
        .signature {
            text-align: center;
        }
        .signature-line {
            border-bottom: 2px solid #333;
            width: 200px;
            margin-bottom: 10px;
        }
        h1 { font-size: 24px; margin: 0 0 20px 0; }
        h2 { font-size: 18px; margin: 0 0 10px 0; }
        p { margin: 0 0 10px 0; }
        .amount { font-weight: bold; font-size: 18px; }
        .concept-list { margin: 15px 0; }
        .concept-item { margin: 5px 0; }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>EET3107</h2>
            <h2>Juana Azurduy de Padilla</h2>
            <div style="margin: 20px 0;">
                @php
                    $escudoPath = public_path('images/escudo.png');
                    $escudoBase64 = '';
                    if (file_exists($escudoPath)) {
                        $escudoData = file_get_contents($escudoPath);
                        $escudoBase64 = 'data:image/png;base64,' . base64_encode($escudoData);
                    }
                @endphp
                @if($escudoBase64)
                    <img src="{{ $escudoBase64 }}" alt="Escudo EET3107" style="width: 80px; height: 80px; margin: 0 auto; display: block;">
                @else
                    <div style="width: 80px; height: 80px; background-color: #ddd; margin: 0 auto; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 10px;">
                        ESCUDO
                    </div>
                @endif
            </div>
            <p><strong>Comprobante Nº</strong></p>
            <p style="font-size: 18px; font-weight: bold;">{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</p>
        </div>

        <div class="content">
            <div style="position: relative; z-index: 1;">
                <div class="header">
                    <h1>Comprobante de Aporte a Cooperadora Escolar</h1>
                    <p style="text-align: right; font-size: 16px;">Salta, {{ $ingreso->fecha ? \Carbon\Carbon::parse($ingreso->fecha)->locale('es')->translatedFormat('d \d\e F \d\e Y') : 'N/A' }}</p>
                </div>

                <p>Recibí de <strong>{{ $ingreso->alumno->apellido ?? 'N/A' }} {{ $ingreso->alumno->nombre ?? '' }}</strong></p>
                <p>DNI: <strong>{{ $ingreso->alumno->dni ?? 'N/A' }}</strong></p>
                <p>la suma de <strong>{{ numeroATexto($ingreso->importe_total ?? 0, 2, ',', '.') }} pesos</strong></p>

                @if($ingreso->conceptos && $ingreso->conceptos->count() > 0)
                    <p><strong>En concepto de:</strong></p>
                    <div class="concept-list">
                        @foreach($ingreso->conceptos as $concepto)
                            <div class="concept-item">
                                • {{ $concepto->nombre }} (Cant: {{ $concepto->pivot->cantidad }}) - ${{ number_format($concepto->pivot->total_concepto ?? 0, 2, ',', '.') }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p><strong>En concepto de:</strong> Aporte general</p>
                @endif

                <div class="footer">
                    <div>
                        <p class="amount">Son <strong>$ {{ number_format($ingreso->importe_total ?? 0, 2, ',', '.') }}</strong></p>
                        @if($ingreso->alumno && $ingreso->alumno->email)
                            <p style="font-size: 12px;">Email: {{ $ingreso->alumno->email }}</p>
                        @endif
                    </div>
                    <div class="signature">
                        <div class="signature-line"></div>
                        <p>Firma y Sello</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>