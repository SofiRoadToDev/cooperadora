<form action="{{route('ingresos.store')}}" class="flex flex-col p-5 shadow-md w-1/2" method="POST">
    @csrf
    <h3 class="text-center py-4">Agregar Ingreso</h3>

    <div class="grid grid-cols-2 gap-3">
        <label for="fecha">Fecha</label>
        <label for="hora">Hora</label>
        <input type="date" class="my-2 border border-slate-600 p-1" name="fecha" disabled> 
        <input type="datetime"  class="my-2 border border-slate-600 p-1" name="hora" disabled>
    </div>
   

    <label for="dni">DNI</label>
    <input type="text" placeholder="dni" class="my-2 border border-slate-600 p-1 w-1/2" name="dni">

    <label for="alumno">Alumno encontrado</label>
    <input type="text" name="alumno">

    <div class="grid grid-cols-3 gap-2 my-3 " id="concepto_div">
        <label for="concepto">Concepto</label>
        <label for="importe_concepto">Importe</label>
        <label for="total_concepto">total concepto</label>
        <select name="concepto" id="conceptos" class="w-1/2 py-1 border border-slate-600 bg-white p-2">
            <option value="">hjjhgh</option>       
        </select>
        <input type="text" disabled name="importe_concepto" id="importe_concepto" class="my-2">
        <input type="text" disabled name="total_concepto" id="total_concepto" class="my-2">
    </div>

    <button class="bg-slate-900 text-white w-1/4 mx-auto py-2 my-4" type="submit">Enviar</button>
</form>