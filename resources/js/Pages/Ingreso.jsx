import Layout from "@/Layouts/Layout";
import IngresoList from "@/Components/Ingreso/IngresoList";
import { Link } from "@inertiajs/react";

function Ingreso({ingresos}) {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
                { ingresos.length > 0 ? 
                    <IngresoList  ingresos={ingresos}/> :
                     <span>No hay ingresos registrados</span>
                }
                
            </div>
        </Layout>
    );
}

export default Ingreso;
