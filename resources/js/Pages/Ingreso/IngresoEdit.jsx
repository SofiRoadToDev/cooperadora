import Layout from "@/Layouts/Layout";
import IngresoForm from "@/Components/Ingreso/IngresoForm";


function IngresoEdit({conceptos, ingreso}) {
  return (
    <Layout>
        <IngresoForm conceptos={conceptos} ingreso={ingreso}/>
    </Layout>
  )
}

export default IngresoEdit