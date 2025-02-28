function AlumnoList({ alumnos }) {
    return (
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Apellido</th>
                    <th className="px-4 py-3">Nombre</th>
                    <th className="px-4 py-3">DNI</th>
                    <th className="px-4 py-3">Curso</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {alumnos &&
                    alumnos.map((alumno) => (
                        <tr className="border border-slate-600 bg-leaflighest">
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.apellido}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.dni}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                curso
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="grid grid-cols-2 gap-2">
                                    <a href="{{route('alumnos.edit', $alumno->id)}}">
                                        <i className="fa-solid fa-pen-to-square text-green-500"></i>
                                    </a>
                                    <form
                                        action="{{route('alumnos.destroy', $alumno->id)}}"
                                        className="ml-2"
                                        method="POST"
                                    >
                                        <button type="submit">
                                            <i className="fa-solid fa-trash text-red-500"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default AlumnoList;
