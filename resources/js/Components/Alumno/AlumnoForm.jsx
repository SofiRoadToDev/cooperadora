import { useState } from 'react';
import { useForm } from "@inertiajs/react";
import Dialog from '../Dialog';
import Alert from '../Alert';

function AlumnoForm({ cursos, alumno }) {
    const [dialogOpen, setDialogOpen] = useState(false);
    const [alert, setAlert] = useState({ show: false, type: '', message: '' });
    const emtyAlumno = {
        apellido: '',
        nombre: '',
        dni: '',
        curso: '', 
    };

    const { data, setData, post, put, delete: destroy, errors, processing } = useForm(
        alumno ? { ...alumno, curso: alumno.curso || '' } : emtyAlumno
    );

    const submit = (e) => {
        e.preventDefault();
        if (alumno) {
            put(`/alumnos/${alumno.id}`, {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Alumno actualizado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al actualizar el alumno'
                    });
                }
            });
        } else {
            post("/alumnos", {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Alumno creado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al crear el alumno'
                    });
                }
            });
        }
    };

    const handleDeleteClick = () => {
        setDialogOpen(true);
    };

    const handleDeleteConfirm = () => {
        if (alumno?.id) {
            destroy(`/alumnos/${alumno.id}`);
        }
        setDialogOpen(false);
    };

    return (
        
        <form
        
            onSubmit={submit}
            className="flex flex-col p-6 bg-leaflighest shadow-md w-1/2"
            method="POST"
        >
            <h3 className="text-center py-4 text-xl text-white p-3 bg-leafdarkest mb-4">
                {alumno ? "Actualizar alumno" : "Crear alumno"}
            </h3>
            
            <Alert
                type={alert.type}
                message={alert.message}
                show={alert.show}
                onClose={() => setAlert({ show: false, type: '', message: '' })}
            />
            <label htmlFor="apellido">Apellido</label>
            <input
                type="text"
                onChange={(e) => setData("apellido", e.target.value)}
                placeholder="apellido"
                className="my-2 border border-slate-600 p-1"
                name="apellido"
                value={data.apellido}
            ></input>
            {errors.apellido && (
                <p classNameName="text-red-600 font-medium">
                    {" "}
                    {errors.apellido}
                </p>
            )}

            <label htmlFor="nombre">Nombre</label>
            <input
                type="text"
                placeholder="nombre"
                className="my-2 border border-slate-600 p-1"
                name="nombre"
                onChange={(e) => setData("nombre", e.target.value)}
                value={data.nombre}
            ></input>

            <label htmlFor="dni">DNI</label>
            <input
                type="text"
                placeholder="dni"
                className="my-2 border border-slate-600 p-1 w-1/2"
                name="dni"
                onChange={(e) => setData("dni", e.target.value)}
                value={data.dni}
            ></input>

            <label htmlFor="curso">Curso</label>
            <select
            
                name="curso"
                value={data.curso}
                id="curso"
                className="w-1/2 py-1 border border-slate-600 bg-white p-2"
                onChange={(e) => setData("curso", e.target.value)}
            >
                <option value="">Seleccione un curso</option>
                {Array.isArray(cursos) && cursos.length > 0 ? (
                    cursos.map((curso) => (
                        <option key={curso.codigo} value={curso.codigo}>
                            {curso.nombre}
                        </option>
                    ))
                ) : (
                    <option disabled>No hay cursos disponibles</option>
                )}
            </select>
            <button
                className="leaf-btn-main mt-5"
                type="submit"
                disabled={processing}
            >
                {alumno ? "Actualizar" : "Crear"}
            </button>
            
            {alumno?.id && (
                <button
                    type="button"
                    onClick={handleDeleteClick}
                    className="bg-red-500 text-white py-2 px-4 mt-3 rounded hover:bg-red-600"
                >
                    Eliminar Alumno
                </button>
            )}
            
            <Dialog
                isOpen={dialogOpen}
                onClose={() => setDialogOpen(false)}
                title="Confirmar eliminación"
                message={`¿Estás seguro de que deseas eliminar al alumno ${data.nombre} ${data.apellido}? Esta acción no se puede deshacer.`}
                onConfirm={handleDeleteConfirm}
                confirmText="Eliminar"
                cancelText="Cancelar"
            />
        </form>
    );
}

export default AlumnoForm;