import Layout from "@/Layouts/Layout";
import AlumnoForm from "@/Components/Alumno/AlumnoForm";

export default function AlumnoCreate({ cursos }) {
    return (
        <Layout>
            <AlumnoForm cursos={cursos} />
        </Layout>
    );
}
