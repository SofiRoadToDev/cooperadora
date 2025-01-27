<form action="{{isset($ingreso->id) ? route('ingresos.update', $ingreso->id) : route('ingresos.store')}}" class="flex flex-col p-5  bg-leaflighest shadow-md w-full mb-5" method="POST">
    @csrf
    @isset($ingreso->id)
        @method('PUT')
    @endisset
    <h3 class="form-header">Agregar Ingreso</h3>

    <div class="grid grid-cols-2 gap-3">
        <label for="fecha">Fecha</label>
        <label for="hora">Hora</label>
        <input type="date" class="my-2 border border-slate-600 p-1" name="fecha" readonly value="{{now()->format('Y-m-d')}}"> 
        <input type="datetime"  class="my-2 border border-slate-600 p-1" name="hora" readonly value="{{now()->format('H:i')}}">
        <div class="flex flex-col">
            <label for="dni">DNI</label>
        <input type="text" placeholder="dni" class="my-2 border border-slate-600 p-1 w-full" name="dni" id="dni">
        </div>
        <div class="grid grid-cols-2 gap-1">
            <button class="bg-leafdarkest text-white w-1/2 mt-8  mb-1" type="button"><a href="{{route('alumnos.create')}}" >Nuevo</a></button>
            <button class="bg-leafdarkest text-white w-1/2  mt-8 mb-1" type="button" id="buscarAlumno-btn"><a href="" >Buscar</a></button>
 
        </div>
    </div>
    <input type="text" name ="alumno_id" id="alumno_id" hidden>
    <label for="alumno">Alumno encontrado</label>
    <input type="text" name="alumno" class="p-1 border border-slate-600" id="alumnoInput">
    <label for="email">Email</label>
    <input type="email" name="email" class="p-1 border border-slate-600">
 
     <button class="bg-leafdarkest text-white  mx-auto py-1 px-2 mt-2" type="button" id="addConcepto">Agregar Concepto</button>
    <div id="concepto-container">
        <div class="grid grid-cols-4 gap-x-1 mt-3 " id="concepto-block">
            
                <label for="concepto" class="">Concepto</label>
                <label for="importe_concepto"class="">Cantidad</label>
                <label for="total_concepto" class="">total concepto</label>
                <label for="">borrar</label>

                <select name="conceptos[]" id="conceptos" class="border  border-slate-600 bg-white px-2  ">
                    @foreach ($conceptos as $concepto )
                        <option value="{{$concepto->id}}">{{$concepto->nombre}}</option>
                    @endforeach
                           
                </select>
                <input type="text" name="concepto_id"  id ="concepto_id" hidden>          
                <input type="text"  name="importe_concepto" id="importe_concepto" class=" border  border-slate-600">           
                <input type="text"  name="total_concepto" id="total_concepto" class=" border  border-slate-600" >
                      
        </div>
    </div>
    <label for="total" class="mx-auto mt-3">Total</label>
    <input type="text"  name="importe_total" class="w-1/2 mx-auto border border-slate-600 p-1">
    <div class="grid grid-cols-3 gap-4 mt-3">               
            <a href="{{route('mails.factura')}} " class="mx-auto mt-2" >
                <i class="fas fa-envelope  text-leafdarkest text-5xl"></i>
            </a>
        
        <button class="bg-leafsecond text-white py-2 my-4" type="submit">Enviar</button>
       
            <a href="{{route('pdfs.factura')}}" class="mx-auto mt-2">
                 <i class="fas fa-print text-leafdarkest text-6xl"></i> 
            </a>        
    </div>
    
</form>
@vite('resources/js/main.js')

<button class="bg-red-500  text-white py-2 " id="quitar" type="button" hidden>Quitar</button>  