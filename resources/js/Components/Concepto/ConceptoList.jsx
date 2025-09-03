import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Dialog from '@/Components/Dialog';

function ConceptoList({ conceptos = []}) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedConcepto, setSelectedConcepto] = useState(null);
    const { delete: destroy } = useForm();

    const handleDeleteClick = (concepto) => {
        setSelectedConcepto(concepto);
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (selectedConcepto?.id) {
            destroy(`/conceptos/${selectedConcepto.id}`);
        }
        setDialogOpen(false);
        setSelectedConcepto(null);
    };
    return (
        <>
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Nombre</th>
                    <th className="px-4 py-3">Importe</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {conceptos.length > 0 &&
                    conceptos.map((concepto) => (

                        <tr key={concepto.id} className="border border-slate-600 bg-leaflighest">
                            <td className="px-4 py-2 border border-slate-600">
                                {concepto.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                               ${concepto.importe}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="flex gap-2">
                                    <Link href={`/conceptos/${concepto.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500 hover:text-green-600"></i>
                                    </Link>
                                    <button 
                                        onClick={() => handleDeleteClick(concepto)}
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
            message={selectedConcepto ? `¿Estás seguro de que deseas eliminar el concepto "${selectedConcepto.nombre}"? Esta acción no se puede deshacer.` : ''}
            onConfirm={handleDeleteConfirm}
            confirmText="Eliminar"
            cancelText="Cancelar"
        />
        </>
    );
}

export default ConceptoList;
