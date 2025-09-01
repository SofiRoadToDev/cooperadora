import React from "react";

function IngresoList({ ingresos = [] }) {
    return (
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Fecha</th>
                    <th className="px-4 py-3">Alumno</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {ingresos &&
                    ingresos.map((ingreso) => (
                        <tr className="border border-slate-600">
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.fecha}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.alumno_id}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.importe}
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

export default IngresoList;
