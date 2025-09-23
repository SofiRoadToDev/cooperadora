<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recibo</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            background-size: contain; /* Para asegurar que el escudo se vea completo */
            opacity: 0.1;
            filter: grayscale(100%);
            z-index: 0;
        }
    </style>

</head>
<body>
    <div id="recibo" class="grid grid-cols-4 border border-black min-h-[500px] mx-auto my-2 w-1/2 ">
        <div class="col-1 flex flex-col items-center bg-blue-100 p-5">
            <p class="text-center font-semibold ">EET3107</p>
            <p class="text-center mb-6 font-semibold">Juana Azurduy de Padilla</p>
            <img src="/images/escudo.png" alt="Escudo">
            <p class="text-center mb-6 font-semibold">Comprobante Nº</p>
            <p class="text-center mb-6 font-semibold">{{ str_pad($ingreso->id ?? 0, 6, '0', STR_PAD_LEFT) }}</p>
        </div>
        <div id="cuerpo" class="relative col-span-3 border-l border-black bg-white p-5 flex flex-col">
            <div class="relative z-10 flex flex-col h-full">
                <p class="text-center text-2xl mb-5 font-bold">Comprobante de Aporte a Cooperadora Escolar</p>
                <p class="text-right mb-5 text-lg">Salta, {{ $ingreso->fecha ? \Carbon\Carbon::parse($ingreso->fecha)->locale('es')->translatedFormat('d \d\e F \d\e Y') : 'N/A' }}</p>
                <p class="text-left mb-5 text-lg">Recibí de {{ $ingreso->alumno->apellido ?? 'N/A' }} {{ $ingreso->alumno->nombre ?? '' }}</p>
                <p class="text-left mb-5 text-lg">la suma de {{ $ingreso->importe_total ?? 'N/A' }}</p>
                <p class="text-left mb-5 text-lg">En concepto de {{ $ingreso->concepto[0]->nombre ?? 'N/A' }}</p>
                <div id="bottom" class=" border-black p-2 flex justify-between px-7 mt-auto">
                    <p class="text-left mb-5 text-lg">Son ${{ $ingreso->importe_total ?? 'N/A' }}</p>
                    <p class="text-left mb-5 text-lg ">Firma</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>