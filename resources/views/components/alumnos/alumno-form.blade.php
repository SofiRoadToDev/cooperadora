<form action="{{route('alumnos.store')}}" class="flex flex-col p-5 shadow-md w-1/2" method="POST">
    @csrf
    <h3 class="text-center py-4">Crear nuevo alumno</h3>
    <label for="apellido">Apellido</label>
    <input type="text" placeholder="apellido" class="my-2 border border-slate-600 p-1" name="apellido">

    <label for="nombre">Nombre</label>
    <input type="text" placeholder="nombre" class="my-2 border border-slate-600 p-1" name="nombre">

    <label for="dni">DNI</label>
    <input type="text" placeholder="dni" class="my-2 border border-slate-600 p-1 w-1/2" name="dni">

    <label for="curso">Curso</label>
    <select name="curso" id="curso" class="w-1/2 py-1 border border-slate-600 bg-white p-2">
        @foreach ($cursos as $curso) 
            <option value="{{$curso->codigo}}">{{$curso->codigo}}</option>
        @endforeach
    </select>
    <button class="bg-slate-900 text-white w-1/4 mx-auto py-2 my-4" type="submit">Enviar</button>
</form>