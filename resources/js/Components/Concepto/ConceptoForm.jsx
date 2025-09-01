import { useForm } from "@inertiajs/react";
function ConceptoForm() {
    const { data, setData, errors, processing, post } = useForm({
        nombre: "",
        importe: 0.0,
    });

    const submit = (e) => {
        e.preventDefault();

        post("rutaController");
    };
    return (
        <form
            onSubmit={submit}
            class="flex bg-leaflighest flex-col p-5 shadow-md w-1/2 h-1/2 mb-5"
            method="POST"
        >
            <h3 class="text-center py-4 text-white text-xl bg-leafdarkest mb-4">
                Nuevo Concepto
            </h3>

            <div class="grid grid-cols-2  grid-rows-1 gap-3">
                <label for="nombre" class="mx-auto">
                    Nombre
                </label>
                <input
                    type="text"
                    onChange={(e) => setData("nombre", e.target.value)}
                    value={data.nombre}
                    class="my-2 border border-slate-600 p-1"
                    name="nombre"
                ></input>
                <label for="importe" class="mx-auto">
                    Importe
                </label>
                <input
                    type="text"
                    onChange={(e) => setData("importe", e.target.value)}
                    value={data.importe}
                    class="my-2 border border-slate-600 p-1"
                    name="importe"
                ></input>
            </div>
            <button
                class="leaf-btn-main mt-4"
                type="submit"
                disabled={processing}
            >
                Enviar
            </button>
        </form>
    );
}

export default ConceptoForm;
