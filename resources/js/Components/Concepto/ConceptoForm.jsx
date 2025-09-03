import { useState } from 'react';
import { useForm } from "@inertiajs/react";
import Alert from '../Alert';

function ConceptoForm({ concepto }) {
    const [alert, setAlert] = useState({ show: false, type: '', message: '' });
    const emptyConcepto = {
        nombre: "",
        importe: "",
    };

    const { data, setData, post, put, errors, processing } = useForm(
        concepto ? { ...concepto } : emptyConcepto
    );

    const submit = (e) => {
        e.preventDefault();
        if (concepto) {
            put(`/conceptos/${concepto.id}`, {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Concepto actualizado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al actualizar el concepto'
                    });
                }
            });
        } else {
            post("/conceptos", {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Concepto creado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al crear el concepto'
                    });
                }
            });
        }
    };
    return (
        <form
            onSubmit={submit}
            className="flex bg-leaflighest flex-col p-5 shadow-md w-1/2 h-1/2 mb-5"
            method="POST"
        >
            <h3 className="text-center py-4 text-white text-xl bg-leafdarkest mb-4">
                {concepto ? "Actualizar Concepto" : "Nuevo Concepto"}
            </h3>
            
            <Alert
                type={alert.type}
                message={alert.message}
                show={alert.show}
                onClose={() => setAlert({ show: false, type: '', message: '' })}
            />

            <div className="grid grid-cols-2  grid-rows-1 gap-3">
                <label htmlFor="nombre" className="mx-auto">
                    Nombre
                </label>
                <input
                    type="text"
                    onChange={(e) => setData("nombre", e.target.value)}
                    value={data.nombre}
                    className="my-2 border border-slate-600 p-1"
                    name="nombre"
                ></input>
                <label htmlFor="importe" className="mx-auto">
                    Importe
                </label>
                <input
                    type="number"
                    onChange={(e) => setData("importe", e.target.value)}
                    value={data.importe}
                    className="my-2 border border-slate-600 p-1"
                    name="importe"
                ></input>
            </div>
            <button
                className="leaf-btn-main mt-4"
                type="submit"
                disabled={processing}
            >
                {concepto ? "Actualizar" : "Crear"}
            </button>
        </form>
    );
}

export default ConceptoForm;
