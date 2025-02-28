import React from "react";

function EgresoList({ egresos }) {
    return (
        <table class="mt-5">
            <thead>
                <tr class="table-header">
                    <th class="px-4 py-3 ">Fecha</th>
                    <th class="px-4 py-3">concepto</th>
                    <th class="px-4 py-3">Importe</th>
                    <th class="px-4 py-3">solicitante</th>
                    <th class="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {egresos &&
                    egresos.map((egreso) => (
                        <tr class="border border-slate-600">
                            <td class="px-4 py-2 border border-slate-600">
                                {$egreso.fecha}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                {$egreso.concepto.nombre}
                            </td>
                            <td class="px-4 py-2 border border-slate-600">
                                {$egreso.importe}
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

export default EgresoList;
