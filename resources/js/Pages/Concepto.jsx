import Layout from "@/Layouts/Layout";
import EgresoList from "@/Components/Concepto/ConceptoList";
import ConceptoList from "../Components/Concepto/ConceptoList";

function Concepto({ conceptos = []}) {
    return (
        <Layout>
            {conceptos.length > 0 ?
                <ConceptoList  conceptos={conceptos}/>:
                <span>No hay conceptos para mostrar</span>
            }           
        </Layout>
    );
}

export default Concepto;
