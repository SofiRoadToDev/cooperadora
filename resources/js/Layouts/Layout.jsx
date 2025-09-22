import Nav from "@/Components/Nav";
import Hero from "../Components/Hero";
import { usePage, router } from "@inertiajs/react";
import { useEffect } from "react";

export default function Layout({ children }) {
    const { auth } = usePage().props;

    useEffect(() => {
        // Si no hay usuario autenticado, redirigir al login
        if (!auth?.user) {
            router.visit('/login');
        }
    }, [auth]);

    // Si no hay usuario, mostrar un loading o nada mientras redirige
    if (!auth?.user) {
        return (
            <div className="min-h-screen bg-leaflight flex items-center justify-center">
                <div className="text-leafdarkest text-xl">Redirigiendo al login...</div>
            </div>
        );
    }

    return (
        <>
            <Hero/>
            <Nav />
            <main className="bg-leaflight  min-h-screen">
                <div className="w-full  p-4 flex justify-center">
                    {children}
                </div>
            </main>
        </>
    );
}
