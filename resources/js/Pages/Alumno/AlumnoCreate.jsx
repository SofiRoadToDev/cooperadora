import Layout from "@/Layouts/Layout";
import AlumnoForm from "@/Components/Alumno/AlumnoForm";

export default function AlumnoCreate({ cursos, alumno }) {
    return (
        <Layout>
            <AlumnoForm cursos={cursos} alumno={alumno} />
        </Layout>
    );
}
