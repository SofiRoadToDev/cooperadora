<table class="mt-5">
    <thead>
        <tr class="border border-slate-600" >
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
                <tr class="border border-slate-600">
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->apellido}}</td>
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->nombre}}</td>
                    <td class="px-4 py-2 border border-slate-600">{{$alumno->dni}}</td>
                    <td class="px-4 py-2 border border-slate-600">curso</td>
                    <td class="px-4 py-2 border border-slate-600">acciones</td>
                </tr>
            @endforeach
        @endisset
    </tbody>
</table>