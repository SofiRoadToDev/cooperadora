import React, { useState } from "react";
import { Link, useForm } from "@inertiajs/react";
import Dialog from '@/Components/Dialog';

function IngresoList({ ingresos = [] }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedIngreso, setSelectedIngreso] = useState(null);
    const [searchNumber, setSearchNumber] = useState('');
    const { delete: destroy } = useForm();

    const handleDeleteClick = (ingreso) => {
        setSelectedIngreso(ingreso);
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (selectedIngreso?.id) {
            destroy(`/ingresos/${selectedIngreso.id}`);
        }
        setDialogOpen(false);
        setSelectedIngreso(null);
    };

    const formatDate = (dateString) => {
        const date = new Date(dateString);
        return date.toLocaleDateString('es-ES', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
    };

    // Filtrar ingresos por número/ID
    const filteredIngresos = ingresos.filter(ingreso => {
        if (!searchNumber) return true;
        return ingreso.id.toString().includes(searchNumber);
    });

    return (
        <>
        {/* Filtro de búsqueda */}
        <div className="flex justify-end mb-3">
            <label htmlFor="searchNumber" className="text-leafdarkest font-medium mr-2">
                Buscar por número:
            </label>
            <input
                id="searchNumber"
                type="text"
                placeholder="Ingrese número"
                value={searchNumber}
                onChange={(e) => setSearchNumber(e.target.value)}
                className="border border-slate-600 px-3 py-1 rounded focus:outline-none focus:border-leafdarkest"
            />
            {searchNumber && (
                <button
                    onClick={() => setSearchNumber('')}
                    className="text-leafdarkest hover:text-red-500 ml-2"
                    title="Limpiar búsqueda"
                >
                    <i className="fas fa-times"></i>
                </button>
            )}
        </div>

        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3">Número</th>
                    <th className="px-4 py-3 ">Fecha</th>
                    <th className="px-4 py-3">Alumno</th>
                    <th className="px-4 py-3">Conceptos</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {filteredIngresos &&
                    filteredIngresos.map((ingreso) => (
                        <tr className="border border-slate-600 bg-leaflighest" key={ingreso.id}>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.id}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {formatDate(ingreso.fecha)}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.alumno ? `${ingreso.alumno.apellido}, ${ingreso.alumno.nombre}` : ingreso.alumno_id}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {ingreso.conceptos && ingreso.conceptos.length > 0
                                    ? ingreso.conceptos.map(concepto => concepto.nombre).join(', ')
                                    : 'Sin conceptos'
                                }
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                ${ingreso.importe_total}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="grid grid-cols-2 gap-2">
                                    <Link href={`/ingresos/${ingreso.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500"></i>
                                    </Link>
                                    <button
                                        onClick={() => handleDeleteClick(ingreso)}
                                        className="ml-2"
                                    >
                                        <i className="fa-solid fa-trash text-red-500 hover:text-red-600"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    ))}
            </tbody>
        </table>

        <Dialog
            isOpen={dialogOpen}
            onClose={() => setDialogOpen(false)}
            title="Confirmar eliminación"
            message={selectedIngreso ? `¿Estás seguro de que deseas eliminar el ingreso del alumno "${selectedIngreso.alumno.apellido}, ${selectedIngreso.alumno.nombre}"? Esta acción no se puede deshacer.` : ''}
            onConfirm={handleDeleteConfirm}
            confirmText="Eliminar"
            cancelText="Cancelar"
        />
        </>
    );
}

export default IngresoList;
