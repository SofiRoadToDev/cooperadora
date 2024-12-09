<form action="{{route('ingresos.store')}}" class="flex flex-col p-5 shadow-md w-1/2" method="POST">
    @csrf
    <h3 class="text-center py-4">Agregar Ingreso</h3>

    <div class="grid grid-cols-2 gap-3">
        <label for="fecha">Fecha</label>
        <label for="hora">Hora</label>
        <input type="date" class="my-2 border border-slate-600 p-1" name="fecha" disabled> 
        <input type="datetime"  class="my-2 border border-slate-600 p-1" name="hora" disabled>
        <div class="flex flex-col">
            <label for="dni">DNI</label>
        <input type="text" placeholder="dni" class="my-2 border border-slate-600 p-1 w-1/2" name="dni">
        </div>
        
        <button class="bg-slate-900 text-white w-1/4 mx-auto py-2 my-4" type="submit">Nuevo</button>
    </div>
    <label for="alumno">Alumno encontrado</label>
    <input type="text" name="alumno">
 
     <button class="bg-slate-900 text-white  mx-auto py-1 px-2 mt-2" type="submit">Agregar Concepto</button>
    <div class="grid grid-cols-4 grid-rows-2 gap-x-1 mt-3 " id="concepto_div">
           
            <label for="concepto" class="">Concepto</label>
             <label for="importe_concepto"class="">Importe</label>
            <label for="total_concepto" class="">total concepto</label>
            <label for="">borrar</label>

            <select name="concepto" id="conceptos" class="border  border-slate-600 bg-white px-2  ">
                <option value="">hjjhgh</option>       
            </select>          
            <input type="text" disabled name="importe_concepto" id="importe_concepto" class=" border  border-slate-600">           
            <input type="text" disabled name="total_concepto" id="total_concepto" class=" border  border-slate-600" >
            <button class="bg-red-500  text-white  py-2" type="button">Quitar</button>        
    </div>

    <label for="total" class="mx-auto mt-3">Total</label>
    <input type="text" disabled name="total" class="w-1/2 mx-auto">
    <button class="bg-slate-900 text-white w-1/4 mx-auto py-2 my-4" type="submit">Enviar</button>
</form>