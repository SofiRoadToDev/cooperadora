import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Dialog from '@/Components/Dialog';

function CategoriaList({ categorias = []}) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedCategoria, setSelectedCategoria] = useState(null);
    const [currentPage, setCurrentPage] = useState(1);
    const [itemsPerPage] = useState(15);
    const { delete: destroy } = useForm();

    const handleDeleteClick = (categoria) => {
        setSelectedCategoria(categoria);
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (selectedCategoria?.id) {
            destroy(`/categorias/${selectedCategoria.id}`);
        }
        setDialogOpen(false);
        setSelectedCategoria(null);
    };

    // Paginación
    const indexOfLastItem = currentPage * itemsPerPage;
    const indexOfFirstItem = indexOfLastItem - itemsPerPage;
    const currentCategorias = categorias.slice(indexOfFirstItem, indexOfLastItem);
    const totalPages = Math.ceil(categorias.length / itemsPerPage);

    const handlePageChange = (pageNumber) => {
        setCurrentPage(pageNumber);
    };

    return (
        <>
        <table className="mt-5">
            <thead>
                <tr className="table-header">
                    <th className="px-4 py-3 ">Nombre</th>
                    <th className="px-4 py-3">Descripción</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {currentCategorias.length > 0 &&
                    currentCategorias.map((categoria) => (

                        <tr key={categoria.id} className="border border-slate-600 bg-leaflighest">
                            <td className="px-4 py-2 border border-slate-600">
                                {categoria.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                               {categoria.descripcion || '-'}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="flex gap-2">
                                    <Link href={`/categorias/${categoria.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500 hover:text-green-600"></i>
                                    </Link>
                                    <button
                                        onClick={() => handleDeleteClick(categoria)}
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
                Mostrando {indexOfFirstItem + 1}-{Math.min(indexOfLastItem, categorias.length)} de {categorias.length} registros
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
            message={selectedCategoria ? `¿Estás seguro de que deseas eliminar la categoría "${selectedCategoria.nombre}"? Esta acción no se puede deshacer.` : ''}
            onConfirm={handleDeleteConfirm}
            confirmText="Eliminar"
            cancelText="Cancelar"
        />
        </>
    );
}

export default CategoriaList;