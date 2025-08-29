import Layout from "@/Layouts/Layout";
import IngresoList from "@/Components/Ingreso/IngresoList";

function Ingreso() {
    return (
        <Layout>
             <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
            <IngresoList />
        </Layout>
    );
}

export default Ingreso;
