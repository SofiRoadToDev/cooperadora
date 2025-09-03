import { useState } from 'react';
import { useForm } from "@inertiajs/react";
import Alert from '../Alert';

function EgresoForm({categorias = [], egreso}) {
    const [alert, setAlert] = useState({ show: false, type: '', message: '' });
    
    // Obtener fecha y hora actual solo si no hay egreso
    const now = new Date();
    const fechaActual = now.toLocaleDateString('es-AR'); // dd/mm/yyyy
    const horaActual = now.toTimeString().split(' ')[0].substring(0, 5); // HH:MM

    const emptyEgreso = {
        fecha: fechaActual,
        hora: horaActual,
        categoria_id: "",
        concepto: "",
        importe: "",
        solicitante: "",
        empresa: "",
        tipo_comprobante: "",
        numero_comprobante: "",
        observaciones: "",
    };

    const { data, setData, processing, errors, post, put } = useForm(
        egreso ? { ...egreso } : emptyEgreso
    );

    const submit = (e) => {
        e.preventDefault();
        if (egreso) {
            put(`/egresos/${egreso.id}`, {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Egreso actualizado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al actualizar el egreso'
                    });
                }
            });
        } else {
            post("/egresos", {
                onSuccess: () => {
                    setAlert({
                        show: true,
                        type: 'success',
                        message: 'Egreso creado exitosamente'
                    });
                },
                onError: () => {
                    setAlert({
                        show: true,
                        type: 'error',
                        message: 'Error al crear el egreso'
                    });
                }
            });
        }
    };

    return (
        <form
            onSubmit={submit}
            className="flex flex-col bg-leaflighest p-5 shadow-md w-1/2 mb-5"
            method="POST"
        >
            <h3 className="form-header">{egreso ? "Actualizar Egreso" : "Nuevo Egreso"}</h3>
            
            <Alert
                type={alert.type}
                message={alert.message}
                show={alert.show}
                onClose={() => setAlert({ show: false, type: '', message: '' })}
            />

            <div className="grid grid-cols-3 grid-rows-1 gap-3">
                <label for="fecha">Fecha</label>
                <label for="hora">Hora</label>
                <label for="categoria">Categoria</label>

                <input
                    type="text"
                    placeholder="dd/mm/yyyy"
                    className="my-2 border border-slate-600 p-1"
                    name="fecha"
                    onChange={(e) => setData("fecha", e.target.value)}
                    value={data.fecha}
                >
                </input>
                <input
                    type="time"
                    className="my-2 border border-slate-600 p-1"
                    name="hora"
                    onChange={(e) => setData("hora", e.target.value)}
                    value={data.hora}
                ></input>
                <select
                    name="categoria_id"
                    id="categoria"
                    onChange={(e) => setData("categoria_id", e.target.value)}
                    value={data.categoria_id}
                    className="border my-2 border-slate-600 bg-white px-2"
                >
                    <option value="">Seleccione una categoría</option>
                    {Array.isArray(categorias) && categorias.length > 0 ? (
                        categorias.map((categoria) => (
                            <option key={categoria.id} value={categoria.id}>
                                {categoria.nombre}
                            </option>
                        ))
                    ) : (
                        <option disabled>No hay categorías disponibles</option>
                    )}
                </select>
                <label for="concepto">Concepto</label>
                <label for="concepto">Tipo comprobante</label>
                <label for="concepto">Número comprobante</label>
                <input
                    type="text"
                    name="concepto"
                    value={data.concepto}
                    onChange={(e) => setData("concepto", e.target.value)}
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <select
                    name="tipo_comprobante"
                    id="tipo_comprobante"
                    value={data.tipo_comprobante}
                    onChange={(e) => setData("tipo_comprobante", e.target.value)}
                    className="border my-2 border-slate-600 bg-white px-2 "
                >
                    <option value="">Ticket</option>
                    <option value="factura">Factura</option>
                    <option value="remito">Remito</option>
                    <option value="nota">Nota</option>
                    <option value="presupuesto">Presupuesto</option>
                    <option value="otro">Otro</option>
                </select>
                <input
                    type="text"
                    name="numero_comprobante"
                    value={data.numero_comprobante}
                    onChange={(e) => setData("numero_comprobante", e.target.value)}
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <label for="concepto">Importe</label>
                <label for="concepto" className="col-span-2">
                    Solicitante
                </label>
                <input
                    type="text"
                    name="importe"
                    value={data.importe}
                    onChange={(e) => setData("importe", e.target.value)}
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <input
                    type="text"
                    name="solicitante"
                    value={data.solicitante}
                    onChange={(e) => setData("solicitante", e.target.value)}
                    className="my-2 border border-slate-600 p-1 col-span-2"
                ></input>
            </div>
            <div className="grid grid-cols-3 grid-rows-1 gap-2">
                <label for="concepto">Empresa</label>
                <label for="concepto" className="col-span-2">
                    Observaciones
                </label>
                <input
                    type="text"
                    name="empresa"
                    value={data.empresa}
                    onChange={(e) => setData("empresa", e.target.value)}
                    className="my-2 border border-slate-600 p-1 h-1/3"
                ></input>
                <textarea
                    type="text"
                    name="observaciones"
                    rows="3"
                    value={data.observaciones}
                    onChange={(e) => setData("observaciones", e.target.value)}
                    className="my-2 border col-span-2 border-slate-600 p-1"
                ></textarea>
            </div>
            <button className="leaf-btn-main" type="submit" disabled={processing}>
                {egreso ? "Actualizar" : "Crear"}
            </button>
        </form>
    );
}

export default EgresoForm;
