import Nav from "@/Components/Nav";

export default function Layout({ children }) {
    return (
        <>
            <Nav />
            <main className="bg-leaflight  flex justify-center h-screen">
                {children}
            </main>
        </>
    );
}
