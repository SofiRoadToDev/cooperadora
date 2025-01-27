<form action="{{route('ingresos.store')}}" class="flex flex-col bg-leaflighest p-5 shadow-md w-1/2 mb-5" method="POST">
    @csrf
    @isset($egreso)
        @method('PUT')
    @endisset
    <h3 class="form-header">Nuevo Egreso</h3>

    <div class="grid grid-cols-3 grid-rows-1 gap-3">
        <label for="fecha">Fecha</label>
        <label for="hora">Hora</label>
        <label for="categoria">Categoria</label>
       
        <input type="date" class="my-2 border border-slate-600 p-1" name="fecha"  value="{{old('fecha', $egreso->fecha ?? now()->format('Y-m-d'))}}"> 
        <input type="datetime"  class="my-2 border border-slate-600 p-1" name="hora" disabled value="{{old('hora', $ingreso->hora ?? now()->format('H:i'))}}">
        <select name="categoria" id="categoria" class="border my-2 border-slate-600 bg-white px-2  ">
            <option value="">Talleres</option>       
        </select>  
        <label for="concepto">Concepto</label>
        <label for="concepto">Tipo comprobante</label>
        <label for="concepto">Número comprobante</label>
        <input type="text" class="my-2 border border-slate-600 p-1" >
        <select name="concepto" id="concepto" class="border my-2 border-slate-600 bg-white px-2 ">
            <option value="">Ticket</option>
            <option value="">Factura</option>
            <option value="">Remito</option> 
            <option value="">Nota</option> 
            <option value="">Presupuesto</option>
            <option value="">Otro</option>     
        </select> 
        <input type="text" class="my-2 border border-slate-600 p-1" >
        <label for="concepto">Importe</label>
        <label for="concepto" class="col-span-2">Solicitante</label>
        <input type="text" class="my-2 border border-slate-600 p-1" >
        <input type="text" class="my-2 border border-slate-600 p-1 col-span-2" >
    </div>
    <div class="grid grid-cols-3 grid-rows-1 gap-2">
        <label for="concepto">Empresa</label>
        <label for="concepto" class="col-span-2">Observaciones</label>
        <input type="text" class="my-2 border border-slate-600 p-1 h-1/3" >
        <textarea type="text"  rows="3"class="my-2 border col-span-2 border-slate-600 p-1"></textarea>
    </div>
    <button class="leaf-btn-main" type="submit">Enviar</button>
</form>
@vite('resources/js/main.js')

<button class="bg-red-500  text-white py-2 " id="quitar" type="button" hidden>Quitar</button>  