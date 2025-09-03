import Layout from '@/Layouts/Layout'
import EgresoForm from '@/Components/Egreso/EgresoForm'


function EgresoCreate({categorias, egreso}) {
  return (
   <Layout>
        <EgresoForm categorias={categorias} egreso={egreso} />
   </Layout>
  )
}

export default EgresoCreate