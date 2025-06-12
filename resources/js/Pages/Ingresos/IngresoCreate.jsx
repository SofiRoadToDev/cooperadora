import Layout from "@/Layouts/Layout";
import IngresoForm from "../../Components/Ingreso/IngresoForm";

function IngresoCreate({conceptos, ingreso}) {
  return (
    <Layout>
        <IngresoForm conceptos={conceptos} ingreso={ingreso}/>
    </Layout>
  )
}

export default IngresoCreate