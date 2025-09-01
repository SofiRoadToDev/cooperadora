import { Link } from "@inertiajs/react";

function Nav() {
    return (
        <div className="flex px-3 pt-3 shadow-md bg-leafdarkest text-white text-center">
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
                        <a href="/#">Informes</a>
                        <Link href="/informes">Informes</Link>
                    </li>
                </ul>
            </nav>
        </div>
    );
}

export default Nav;
