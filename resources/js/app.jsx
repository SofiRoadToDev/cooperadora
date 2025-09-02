import "../css/app.css";
import { createInertiaApp } from "@inertiajs/react";
import { createRoot } from "react-dom/client";

createInertiaApp({
    resolve: (name) => {
        //console.log("🔍 Intentando resolver:", name);
        
        const pages = import.meta.glob("./Pages/**/*.jsx", { eager: true });
        //console.log("📁 Páginas disponibles:", Object.keys(pages));
        
        const fullPath = `./Pages/${name}.jsx`;
        //console.log("🎯 Buscando ruta:", fullPath);
        
        const page = pages[fullPath];
        //console.log("📄 Página encontrada:", page);
        
        if (page) {
            //console.log("✅ Componente default:", page.default);
            return page.default;
        } else {
            //console.error("❌ No se encontró la página:", fullPath);
            //console.log("📋 Rutas disponibles:", Object.keys(pages));
            return null;
        }
    },
    setup({ el, App, props }) {
        createRoot(el).render(<App {...props} />);
    },
});