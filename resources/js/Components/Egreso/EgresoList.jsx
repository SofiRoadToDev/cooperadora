
import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Dialog from '@/Components/Dialog';

function EgresoList({ egresos = [] }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedEgreso, setSelectedEgreso] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage] = useState(15);
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

    // Paginación
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentEgresos = egresos.slice(indexOfFirstItem, indexOfLastItem);
    const totalPages = Math.ceil(egresos.length / itemsPerPage);

    const handlePageChange = (pageNumber) => {
        setCurrentPage(pageNumber);
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
                {currentEgresos.length > 0 &&
                    currentEgresos.map((egreso) => (
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

        {/* Información de paginación */}
        <div className="flex justify-between items-center mt-4">
            <div className="text-sm text-leafdarkest">
                Mostrando {indexOfFirstItem + 1}-{Math.min(indexOfLastItem, egresos.length)} de {egresos.length} registros
            </div>

            {/* Controles de paginación */}
            {totalPages > 1 && (
                <div className="flex space-x-2">
                    <button
                        onClick={() => handlePageChange(currentPage - 1)}
                        disabled={currentPage === 1}
                        className={`px-3 py-1 rounded ${
                            currentPage === 1
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : 'bg-leafmedium text-white hover:bg-leafdarkest'
                        }`}
                    >
                        Anterior
                    </button>

                    {Array.from({ length: totalPages }, (_, i) => i + 1).map(page => (
                        <button
                            key={page}
                            onClick={() => handlePageChange(page)}
                            className={`px-3 py-1 rounded ${
                                currentPage === page
                                    ? 'bg-leafdarkest text-white'
                                    : 'bg-leaflight text-leafdarkest hover:bg-leafmedium hover:text-white'
                            }`}
                        >
                            {page}
                        </button>
                    ))}

                    <button
                        onClick={() => handlePageChange(currentPage + 1)}
                        disabled={currentPage === totalPages}
                        className={`px-3 py-1 rounded ${
                            currentPage === totalPages
                                ? 'bg-gray-300 text-gray-500 cursor-not-allowed'
                                : 'bg-leafmedium text-white hover:bg-leafdarkest'
                        }`}
                    >
                        Siguiente
                    </button>
                </div>
            )}
        </div>

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
