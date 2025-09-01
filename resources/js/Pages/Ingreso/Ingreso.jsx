import Layout from "@/Layouts/Layout";
import IngresoList from "@/Components/Ingreso/IngresoList";
import { Link } from "@inertiajs/react";
<<<<<<< HEAD:resources/js/Pages/Ingreso/Ingreso.jsx
function Ingreso() {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
            <IngresoList />
            </div>
             
=======

function Ingreso({ingresos}) {
    return (
        <Layout>
<<<<<<< HEAD
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
                { ingresos.length > 0 ? 
                    <IngresoList  ingresos={ingresos}/> :
                     <span>No hay ingresos registrados</span>
                }
                
            </div>
=======
             <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="ingresos/create">Nuevo</Link>
                </button>
            <IngresoList />
>>>>>>> refs/remotes/origin/main
>>>>>>> 1ba139bfe203a2faec68059d7f328d06fa1533f9:resources/js/Pages/Ingreso.jsx
        </Layout>
    );
}

export default Ingreso;
