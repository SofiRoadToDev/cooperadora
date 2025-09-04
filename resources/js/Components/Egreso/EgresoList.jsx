
import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Dialog from '@/Components/Dialog';

function EgresoList({ egresos = [] }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedEgreso, setSelectedEgreso] = useState(null);
    const { delete: destroy } = useForm();

    const handleDeleteClick = (egreso) => {
        setSelectedEgreso(egreso);
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (selectedEgreso?.id) {
            destroy(`/egresos/${selectedEgreso.id}`);
        }
        setDialogOpen(false);
        setSelectedEgreso(null);
    };

    return (
        <>
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3">Fecha</th>
                    <th className="px-4 py-3">Concepto</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">Solicitante</th>
                    <th className="px-4 py-3">Categoría</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {egresos.length > 0 &&
                    egresos.map((egreso) => (
                        <tr key={egreso.id} className="border border-slate-600 bg-leaflighest">
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.fecha}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.concepto}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                ${egreso.importe}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.solicitante}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {egreso.categoria ? egreso.categoria.nombre : 'Sin categoría'}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="flex gap-2">
                                    <Link href={`/egresos/${egreso.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500 hover:text-green-600"></i>
                                    </Link>
                                    <button 
                                        onClick={() => handleDeleteClick(egreso)}
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
            message={selectedEgreso ? `¿Estás seguro de que deseas eliminar el egreso "${selectedEgreso.concepto}"? Esta acción no se puede deshacer.` : ''}
            onConfirm={handleDeleteConfirm}
            confirmText="Eliminar"
            cancelText="Cancelar"
        />
        </>
    );
}

export default EgresoList;
