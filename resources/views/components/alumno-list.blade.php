<table class="mt-5">
    <thead>
        <tr class="table-header" >
            <th class="px-4 py-3 ">Apellido</th>
            <th class="px-4 py-3">Nombre</th>
            <th class="px-4 py-3">DNI</th>
            <th class="px-4 py-3">Curso</th>
            <th class="px-4 py-3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @isset($alumnos)
            @foreach ($alumnos as $alumno )
                <tr class="border border-slate-600 bg-leaflighest">
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->apellido}}</td>
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->nombre}}</td>
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->dni}}</td>
                    <td class="px-4 py-2 border border-slate-600">curso</td>
                    <td class="px-4 py-2 border border-slate-600">
                        <div class="grid grid-cols-2 gap-2">
                            <a href="{{route('alumnos.edit', $alumno->id)}}">
                                <i class="fa-solid fa-pen-to-square text-green-500"></i>
                            </a>   
                            <form action="{{route('alumnos.destroy', $alumno->id)}}" class="ml-2" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit">
                                        <i class="fa-solid fa-trash text-red-500"></i>
                                </button>
                                
                            </form>                     
                        </div>           
                    </td>
                </tr>
            @endforeach
        @endisset
    </tbody>
</table>