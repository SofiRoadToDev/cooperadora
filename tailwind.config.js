import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.jsx",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                leafdarkest: "#1A2902",
                leafsecond: "#344C11",
                leafmedium: "#778D45",
                leaflight: "#AEC09A",
                leafxtralight: "#AEC670",
                leaflighest: "#ebfff5",
            },
        },
    },
    plugins: [],
};
