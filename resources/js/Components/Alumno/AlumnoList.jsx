import { useState } from 'react';
import { Link, useForm } from '@inertiajs/react';
import Dialog from '@/Components/Dialog';

function AlumnoList({ alumnos = [] }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [selectedAlumno, setSelectedAlumno] = useState(null);
    const { delete: destroy } = useForm();

    const handleDeleteClick = (alumno) => {
        setSelectedAlumno(alumno);
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (selectedAlumno?.id) {
            destroy(`/alumnos/${selectedAlumno.id}`);
        }
        setDialogOpen(false);
        setSelectedAlumno(null);
    };

    return (
        <>
        <table className="mt-5">
            <thead>
                <tr  className="table-header">
                    <th className="px-4 py-3 ">Apellido</th>
                    <th className="px-4 py-3">Nombre</th>
                    <th className="px-4 py-3">DNI</th>
                    <th className="px-4 py-3">Curso</th>
                    <th className="px-4 py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                {alumnos.length > 0 &&
                    alumnos.map((alumno) => (
                        <tr key={alumno.id} className="border border-slate-600 bg-leaflighest">
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.apellido}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.nombre}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.dni}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                {alumno.curso ? alumno.curso.nombre : 'Sin curso'}
                            </td>
                            <td className="px-4 py-2 border border-slate-600">
                                <div className="flex gap-2">
                                    <Link href={`/alumnos/${alumno.id}/edit`}>
                                        <i className="fa-solid fa-pen-to-square text-green-500 hover:text-green-600"></i>
                                    </Link>
                                    <button 
                                        onClick={() => handleDeleteClick(alumno)}
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
            message={selectedAlumno ? `¿Estás seguro de que deseas eliminar al alumno ${selectedAlumno.nombre} ${selectedAlumno.apellido}? Esta acción no se puede deshacer.` : ''}
            onConfirm={handleDeleteConfirm}
            confirmText="Eliminar"
            cancelText="Cancelar"
        />
        </>
    );
}

export default AlumnoList;
