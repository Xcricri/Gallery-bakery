import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            colors: {
                "custom-dark": "#212121",
                "costum-gray": "#3b3b3b",
                "custom-s-dark": "#121212",
            },
            fontFamily: {
                sans: ["Cinzel", ...defaultTheme.fontFamily.serif],
            },
        },
    },

    plugins: [forms],
};
