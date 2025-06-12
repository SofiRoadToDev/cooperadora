import Nav from "@/Components/Nav";

export default function Layout({ children }) {
    return (
        <>
            <Nav />
            <main className="bg-leaflight  min-h-screen">
                <div className="w-full  p-4 flex justify-center">
                    {children}
                </div>
            </main>
        </>
    );
}
