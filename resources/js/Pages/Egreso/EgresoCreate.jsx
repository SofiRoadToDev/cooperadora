import Layout from '@/Layouts/Layout'
import EgresoForm from '@/Components/Egreso/EgresoForm'


function EgresoCreate({egresos}) {
  return (
   <Layout>
        <EgresoForm egresos = {egresos}/>
   </Layout>
  )
}

export default EgresoCreate