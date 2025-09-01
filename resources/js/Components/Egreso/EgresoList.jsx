

function EgresoList({ egresos = []}) {
    return (
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Fecha</th>
                    <th className="px-4 py-3">concepto</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">solicitante</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {egresos &&
                    egresos.map((egreso) => (
                        <tr className="border border-slate-600">
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.fecha}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.concepto.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.importe}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                curso
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                acciones
                            </td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default EgresoList;
