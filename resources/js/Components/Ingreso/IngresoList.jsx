import React from "react";
import { Link, router } from "@inertiajs/react";

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
                        <tr className="border border-slate-600 bg-leaflighest" key={ingreso.id}>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.fecha}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.alumno ? `${ingreso.alumno.apellido}, ${ingreso.alumno.nombre}` : ingreso.alumno_id}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.importe_total}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="grid grid-cols-2 gap-2">
                                    <Link href={`/ingresos/${ingreso.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500"></i>
                                    </Link>
                                    <button
                                        onClick={() => {
                                            if (confirm('¿Estás seguro de eliminar este ingreso?')) {
                                                router.delete(`/ingresos/${ingreso.id}`);
                                            }
                                        }}
                                        className="ml-2"
                                    >
                                        <i className="fa-solid fa-trash text-red-500"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ))}
            </tbody>
        </table>
    );
}

export default IngresoList;
