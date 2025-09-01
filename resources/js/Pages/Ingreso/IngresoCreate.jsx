import Layout from "@/Layouts/Layout";
import IngresoForm from "@/Components/Ingreso/IngresoForm";


function IngresoCreate({ingresos}) {
  return (
    <Layout>
        <IngresoForm  ingresos = {ingresos}/>
    </Layout>
  )
}

export default IngresoCreate