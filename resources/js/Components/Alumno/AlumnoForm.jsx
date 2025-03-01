import { useForm } from "@inertiajs/react";

function AlumnoForm({ cursos }) {
    const { data, setData, post, errors, processing } = useForm({
        apellido: "",
        nombre: "",
        dni: "",
        curso: "",
    });

    const submit = (e) => {
        e.preventDefault();
        post("/alumnos");
    };

    return (
        <form
            onSubmit={submit}
            className="flex flex-col p-6 bg-leaflighest shadow-md w-1/2"
            method="POST"
        >
            <h3 className="text-center py-4 text-xl text-white p-3 bg-leafdarkest mb-4">
                Crear nuevo alumno
            </h3>
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
                value={data.curso}
                id="curso"
                className="w-1/2 py-1 border border-slate-600 bg-white p-2"
                onChange={(e) => setData("curso", e.target.value)}
            >
                {cursos.map((curso) => (
                    <option value={curso.id}>{curso.codigo}</option>
                ))}
            </select>
            <button
                className="leaf-btn-main mt-5"
                type="submit"
                disabled={processing}
            >
                Enviar
            </button>
        </form>
    );
}

export default AlumnoForm;
