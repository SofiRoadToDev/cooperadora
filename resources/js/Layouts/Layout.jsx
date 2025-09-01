import Nav from "@/Components/Nav";
import Hero from "../Components/Hero";

export default function Layout({ children }) {
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
