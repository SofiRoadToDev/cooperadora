<table class="mt-5">
    <thead>
        <tr class="table-header" >
            <th class="px-4 py-3 ">Fecha</th>
            <th class="px-4 py-3">Alumno</th>
            <th class="px-4 py-3">Importe</th>
            <th class="px-4 py-3">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @isset($ingresos)
            @foreach ($ingresos as $ingreso )
                <tr class="border border-slate-600 bg-leaflighest">
                    <td class="px-4 py-2 border border-slate-600">{{$ingreso->fecha}}</td>
                    <td class="px-4 py-2 border border-slate-600">
                        {{$ingreso->alumno ? $ingreso->alumno->apellido . ', ' . $ingreso->alumno->nombre : 'Sin alumno'}}
                    </td>
                    <td class="px-4 py-2 border border-slate-600">${{number_format($ingreso->importe_total, 2)}}</td>
                    <td class="px-4 py-2 border border-slate-600">
                        <div class="flex gap-2">
                            <a href="{{route('ingresos.edit', $ingreso->id)}}"
                               class="bg-leafdarkest text-white px-2 py-1 rounded hover:bg-leafsecond"
                               title="Editar ingreso">
                                <i class="fas fa-edit"></i> Editar
                            </a>

                            <form action="{{route('ingresos.destroy', $ingreso->id)}}" method="POST"
                                  class="inline" onsubmit="return confirm('¿Estás seguro de eliminar este ingreso?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="bg-red-600 text-white px-2 py-1 rounded hover:bg-red-700"
                                        title="Eliminar ingreso">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
        @endisset
    </tbody>
</table>