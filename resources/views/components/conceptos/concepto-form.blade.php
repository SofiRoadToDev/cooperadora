<form action="{{route('conceptos.store')}}" class="flex bg-leaflighest flex-col p-5 shadow-md w-1/2 h-1/2 mb-5" method="POST">
    @csrf
    <h3 class="text-center py-4 text-white text-xl bg-leafdarkest mb-4">Nuevo Concepto</h3>

    <div class="grid grid-cols-2  grid-rows-1 gap-3">
        <label for="nombre" class="mx-auto">Nombre</label>
        <input type="text" class="my-2 border border-slate-600 p-1" name="nombre" >
        <label for="importe" class="mx-auto">Importe</label>
        <input type="text" class="my-2 border border-slate-600 p-1" name="importe" >      
    </div>  
    <button class="leaf-btn-main mt-4" type="submit">Enviar</button>
</form>
@vite('resources/js/main.js')

