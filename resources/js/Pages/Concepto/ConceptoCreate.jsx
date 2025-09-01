import Layout from "@/Layouts/Layout";
import ConceptoForm from "@/Components/Concepto/ConceptoForm";


function ConceptoCreate({conceptos}) {
  return (
    <Layout>
        <ConceptoForm conceptos={conceptos} />
    </Layout>
  )
}

export default ConceptoCreate