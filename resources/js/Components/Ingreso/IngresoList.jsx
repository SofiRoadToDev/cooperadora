import React from "react";

function IngresoList({ ingresos = [] }) {
    return (
        <table class="mt-5">
            <thead>
                <tr class="table-header">
                    <th class="px-4 py-3 ">Fecha</th>
                    <th class="px-4 py-3">Alumno</th>
                    <th class="px-4 py-3">Importe</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {ingresos &&
                    ingresos.map((ingreso) => (
                        <tr class="border border-slate-600">
                            <td class="px-4 py-2 border border-slate-600">
                                {ingreso.fecha}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                {ingreso.alumno_id}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                {ingreso.importe}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                curso
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                acciones
                            </td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default IngresoList;
