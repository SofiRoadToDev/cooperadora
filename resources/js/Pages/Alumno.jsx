import Layout from "@/Layouts/Layout";
import AlumnoList from "@/Components/Alumno/AlumnoList";

export default function Alumno({ alumnos }) {
    return (
        <Layout>
            <AlumnoList alumnos={alumnos} />
        </Layout>
    );
}
