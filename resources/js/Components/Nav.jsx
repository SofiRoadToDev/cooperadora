import { Link, router, usePage } from "@inertiajs/react";

function Nav() {
    const { auth } = usePage().props;

    const logout = () => {
        router.post('/logout');
    };

    return (
        <div className="flex justify-between px-3 pt-3 shadow-md bg-leafdarkest text-white text-center">
            <nav>
                <ul className="flex space-x-4">
                    <li className="hover:bg-leafmedium p-3">
                        <Link href="/alumnos">Alumnos</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3">
                        <Link href="/ingresos">Ingresos</Link>
                    </li>
                    <li className="hover:bg-leafmedium  p-3">
                        <Link href="/egresos">Egresos</Link>
                    </li>
                    <li className="hover:bg-leafmedium  p-3">
                        <Link href="/conceptos">Conceptos</Link>
                    </li>
                    <li className="hover:bg-leafmedium  p-3">
                        <Link href="/informes">Informes</Link>
                    </li>
                </ul>
            </nav>

            {auth?.user && (
                <div className="flex items-center space-x-4">
                    <span className="text-leaflight">Hola, {auth.user.name}</span>
                    <button
                        onClick={logout}
                        className="hover:bg-leafmedium p-3 bg-leafsecond rounded"
                    >
                        Cerrar Sesión
                    </button>
                </div>
            )}
        </div>
    );
}

export default Nav;
