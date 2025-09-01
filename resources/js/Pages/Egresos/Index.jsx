import Layout from "@/Layouts/Layout";
import EgresoList from "@/Components/Egreso/EgresoList";

function Egreso() {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="egresos/create">Nuevo</Link>
                </button>
                 <EgresoList />
            </div>      
        </Layout>
    );
}

export default Egreso;
