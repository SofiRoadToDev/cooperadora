import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import ConceptoList from "@/Components/Concepto/ConceptoList";

function Concepto({conceptos}) {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="conceptos/create">Nuevo</Link>
                </button>
                <ConceptoList conceptos={conceptos} />
            </div>
        </Layout>
    );
}

export default Concepto;
