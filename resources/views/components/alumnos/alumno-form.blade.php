<form action="{{ isset($alumno->id) ? route('alumnos.update', $alumno->id) : route('alumnos.store') }}"  class="flex flex-col p-6 bg-leaflighest shadow-md w-1/2" method="POST">
    
    @csrf
    @isset($alumno->id)
        @method('PUT')
    @endisset
    
    <h3 class="text-center py-4 text-xl text-white p-3 bg-leafdarkest mb-4">{{isset($alumno->dni) ? 'Actualizar alumno' : 'Crear alumno'}}</h3>
    <label for="apellido">Apellido</label>
    <input type="text" placeholder="apellido" class="my-2 border border-slate-600 p-1" name="apellido" value="{{old('apellido', $alumno->apellido ?? '')}}">

    <label for="nombre">Nombre</label>
    <input type="text" placeholder="nombre" class="my-2 border border-slate-600 p-1" name="nombre" value="{{old('nombre', $alumno->nombre ?? '')}}">

    <label for="dni">DNI</label>
    <input type="text" placeholder="dni" class="my-2 border border-slate-600 p-1 w-1/2" name="dni" value = "{{old('dni', $alumno->dni ?? '')}}">

    <label for="curso">Curso</label>
    <select name="curso" id="curso" class="w-1/2 py-1 border border-slate-600 bg-white p-2" >
        @foreach ($cursos as $curso) 
            <option value="{{$curso->codigo}}"
                {{$curso->codigo}} 
                >
            </option>            
        @endforeach
    </select>
    <button class="leaf-btn-main mt-5" type="submit">{{isset($alumno->dni) ? 'Actualizar' : 'Crear'}}</button>
</form>