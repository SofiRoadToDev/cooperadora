import Layout from "@/Layouts/Layout";
import ConceptoForm from "@/Components/Concepto/ConceptoForm";


function ConceptoCreate({concepto}) {
  return (
    <Layout>
        <ConceptoForm concepto={concepto} />
    </Layout>
  )
}

export default ConceptoCreate