import Layout from "@/Layouts/Layout";
import CategoriaForm from "@/Components/Categoria/CategoriaForm";


function CategoriaCreate({categoria}) {
  return (
    <Layout>
        <CategoriaForm categoria={categoria} />
    </Layout>
  )
}

export default CategoriaCreate