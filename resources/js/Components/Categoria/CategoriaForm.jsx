import { useState } from 'react';
import { useForm, router } from "@inertiajs/react";
import Alert from '../Alert';

function CategoriaForm({ categoria }) {
    const [alert, setAlert] = useState({ show: false, type: '', message: '' });
    const emptyCategoria = {
        nombre: "",
        descripcion: "",
    };

    const { data, setData, post, put, errors, processing } = useForm(
        categoria ? { ...categoria } : emptyCategoria
    );

    const submit = (e) => {
        e.preventDefault();
        if (categoria && categoria.id) {
            put(route('categorias.update', categoria.id), {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Categoría actualizada exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al actualizar la categoría'
                    });
                }
            });
        } else {
            post(route('categorias.store'), {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Categoría creada exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al crear la categoría'
                    });
                }
            });
        }
    };
    return (
        <form
            onSubmit={submit}
            className="flex bg-leaflighest flex-col p-5 shadow-md md:w-1/2 h-1/2 mb-5"
            method="POST"
        >
            <h3 className="text-center py-4 text-white text-xl bg-leafdarkest mb-4">
                {categoria && categoria.id ? "Actualizar Categoría" : "Nueva Categoría"}
            </h3>

            <Alert
                type={alert.type}
                message={alert.message}
                show={alert.show}
                onClose={() => setAlert({ show: false, type: '', message: '' })}
            />

            <div className="grid grid-cols-2  grid-rows-2 gap-3">
                <label htmlFor="nombre" className="mx-auto">
                    Nombre
                </label>
                <input
                    type="text"
                    onChange={(e) => setData("nombre", e.target.value)}
                    value={data.nombre}
                    className="my-2 border h-1/3 border-slate-600 p-1"
                    name="nombre"
                ></input>
                <label htmlFor="descripcion" className="mx-auto">
                    Descripción
                </label>
                <textarea
                    onChange={(e) => setData("descripcion", e.target.value)}
                    value={data.descripcion}
                    className="my-2 border border-slate-600 p-1"
                    name="descripcion"
                    rows="3"
                ></textarea>
            </div>
            <button
                className="leaf-btn-main mt-4"
                type="submit"
                disabled={processing}
            >
                {categoria && categoria.id ? "Actualizar" : "Crear"}
            </button>
        </form>
    );
}

export default CategoriaForm;