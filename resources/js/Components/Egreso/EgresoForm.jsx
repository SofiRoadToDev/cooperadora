import { useForm } from "@inertiajs/react";

function EgresoForm() {
    const { data, setData, processing, errors, post } = useForm({
        fecha: "",
        hora: "",
        categoria: "",
        concepto: "",
        importe: 0.0,
        solicitente: "",
        empresa: "",
        observaciones: "",
    });
    return (
        <form
            className="flex flex-col bg-leaflighest p-5 shadow-md w-1/2 mb-5"
            method="POST"
        >
            <h3 className="form-header">Nuevo Egreso</h3>

            <div className="grid grid-cols-3 grid-rows-1 gap-3">
                <label for="fecha">Fecha</label>
                <label for="hora">Hora</label>
                <label for="categoria">Categoria</label>

                <input
                    type="date"
                    className="my-2 border border-slate-600 p-1"
                    name="fecha"
                    onChange={(e) => setData("fecha", e.target.value)}
                    value={data.fecha}
                >
                </input>
                <input
                    type="datetime"
                    className="my-2 border border-slate-600 p-1"
                    name="hora"
                    onChange={(e) => setData("hora", e.target.value)}
                    disabled
                    value={data.hora}
                ></input>
                <select
                    name="categoria"
                    id="categoria"
                    onChange={(e) => setData("fecha", e.target.value)}
                    value={data.categoria}
                    className="border my-2 border-slate-600 bg-white px-2  "
                >
                    <option value="">Talleres</option>
                </select>
                <label for="concepto">Concepto</label>
                <label for="concepto">Tipo comprobante</label>
                <label for="concepto">Número comprobante</label>
                <input
                    type="text"
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <select
                    name="concepto"
                    id="concepto"
                    className="border my-2 border-slate-600 bg-white px-2 "
                >
                    <option value="">Ticket</option>
                    <option value="">Factura</option>
                    <option value="">Remito</option>
                    <option value="">Nota</option>
                    <option value="">Presupuesto</option>
                    <option value="">Otro</option>
                </select>
                <input
                    type="text"
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <label for="concepto">Importe</label>
                <label for="concepto" className="col-span-2">
                    Solicitante
                </label>
                <input
                    type="text"
                    value={data.importe}
                    onChange={(e) => setData("importe", e.target.value)}
                    className="my-2 border border-slate-600 p-1"
                ></input>
                <input
                    type="text"
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
                    value={data.empresa}
                    onChange={(e) => setData("empresa", e.target.value)}
                    className="my-2 border border-slate-600 p-1 h-1/3"
                ></input>
                <textarea
                    type="text"
                    rows="3"
                    value={data.observaciones}
                    onChange={(e) => setData("observaciones", e.target.value)}
                    className="my-2 border col-span-2 border-slate-600 p-1"
                ></textarea>
            </div>
            <button className="leaf-btn-main" type="submit" disabled={processing}>
                Enviar
            </button>
        </form>
    );
}

export default EgresoForm;
