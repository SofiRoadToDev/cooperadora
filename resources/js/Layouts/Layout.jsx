import Nav from "@/Components/Nav";

export default function Layout({ children }) {
    return (
        <>
            <Nav />
<<<<<<< HEAD
            <main className="bg-leaflight  flex justify-center h-screen">
                {children}
=======
            <main className="bg-leaflight  min-h-screen">
                <div className="w-full  p-4 flex justify-center">
                    {children}
                </div>
>>>>>>> 1ba139bfe203a2faec68059d7f328d06fa1533f9
            </main>
        </>
    );
}
