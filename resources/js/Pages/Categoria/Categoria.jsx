import Layout from "@/Layouts/Layout";
import { Link } from "@inertiajs/react";
import CategoriaList from "@/Components/Categoria/CategoriaList";

function Categoria({categorias}) {
    return (
        <Layout>
            <div className="flex flex-col">
                <button className="bg-black text-white py-2 px-3 rounded-sm mt-3 w-1/2 mx-auto">
                    <Link href="categorias/create">Nuevo</Link>
                </button>
                {categorias.length > 0 ? <CategoriaList categorias={categorias} /> :
                    <span>No hay categorías registradas</span>
                }

            </div>
        </Layout>
    );
}

export default Categoria;