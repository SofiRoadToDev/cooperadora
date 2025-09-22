import { Link, router, usePage } from "@inertiajs/react";
import { useState } from 'react';

function Nav() {
    const { auth } = usePage().props;
    const [isOpen, setIsOpen] = useState(false);

    const logout = () => {
        router.post('/logout');
    };

    return (
        <div className="flex flex-col md:flex-row md:justify-between px-3 pt-3 shadow-md bg-leafdarkest text-white">
            <div className="flex justify-between items-center w-full md:w-auto">
                <button
                    onClick={() => setIsOpen(!isOpen)}
                    className="md:hidden text-white focus:outline-none focus:ring-2 focus:ring-white p-2 rounded"
                >
                    <svg className="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path strokeLinecap="round" strokeLinejoin="round" strokeWidth="2" d={isOpen ? "M6 18L18 6M6 6l12 12" : "M4 6h16M4 12h16M4 18h16"}></path>
                    </svg>
                </button>
                {auth?.user && (
                    <span className="md:hidden text-leaflight mr-4">Hola, {auth.user.name}</span>
                )}
            </div>

            <nav className={`${isOpen ? 'block' : 'hidden'} md:block w-full md:w-auto`}>
                <ul className="flex flex-col md:flex-row md:space-x-4 space-y-2 md:space-y-0 mt-2 md:mt-0">
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/alumnos">Alumnos</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/ingresos">Ingresos</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/egresos">Egresos</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/conceptos">Conceptos</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/categorias">Categorías</Link>
                    </li>
                    <li className="hover:bg-leafmedium p-3 rounded md:rounded-none">
                        <Link href="/informes">Informes</Link>
                    </li>
                </ul>
            </nav>

            {auth?.user && (
                <div className={`${isOpen ? 'flex' : 'hidden'} md:flex flex-col md:flex-row items-center space-y-2 md:space-y-0 md:space-x-4 mt-2 md:mt-0 w-full md:w-auto`}>
                    <span className="hidden md:block text-leaflight">Hola, {auth.user.name}</span>
                    <button
                        onClick={logout}
                        className="hover:bg-leafmedium p-3 bg-leafsecond rounded w-full md:w-auto"
                    >
                        Cerrar Sesión
                    </button>
                </div>
            )}
        </div>
    );
}

export default Nav;