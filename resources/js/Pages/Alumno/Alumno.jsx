import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import AlumnoList from "@/Components/Alumno/AlumnoList";

export default function Alumno({ alumnos }) {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="alumnos/create">Nuevo</Link>
                </button>
                <AlumnoList alumnos={alumnos} />
            </div>
        </Layout>
    );
}
