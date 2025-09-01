import Layout from "@/Layouts/Layout";
import IngresoList from "@/Components/Ingreso/IngresoList";
import { Link } from "@inertiajs/react";
function Ingreso() {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
            <IngresoList />
            </div>
             
        </Layout>
    );
}

export default Ingreso;
