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
            fontFamily: {
                sans: ["Inter", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                gray: {
                    50: '#F1EFE8',
                    100: '#F1EFE8',
                    200: '#e5e3dc',
                    300: '#d3d1c7',
                    400: '#b5b4aa',
                    500: '#888780',
                    600: '#6b6a64',
                    700: '#4e4d49',
                    800: '#2C2C2A',
                    900: '#2C2C2A',
                },
                // Jetons de conception officiels
                primary: "#0F6E56",
                dark: "#2C2C2A",
                accent: "#1D9E75",
                "light-green": "#E1F5EE",
                danger: "#993C1D",
                warning: "#BA7517",
                info: "#185FA5",

                // Mappage de compatibilité pour aligner le reste de l'application
                "guinea-user": "#185FA5",
                "guinea-entreprise": "#0F6E56",
                "guinea-employe": "#185FA5",
                "guinea-paie": "#BA7517",
                "guinea-conge": "#993C1D",
                "guinea-ao": "#0F6E56",
                "guinea-notif": "#BA7517",

                "guinea-green": {
                    DEFAULT: "#0F6E56",
                    light: "#1D9E75",
                    pale: "#E1F5EE",
                },
                "guinea-gold": {
                    DEFAULT: "#BA7517",
                    pale: "#FAEEDA",
                },
                "guinea-red": {
                    DEFAULT: "#993C1D",
                    pale: "#FCEBEB",
                },
                "guinea-gray": {
                    dark: "#2C2C2A",
                    medium: "#888780",
                    warm: "#F1EFE8",
                },
            },
            borderRadius: {
                none: "0",
                sm: "4px",
                DEFAULT: "8px",
                md: "8px",
                lg: "8px",
                xl: "12px",
                "2xl": "20px",
                "3xl": "20px",
                full: "9999px",
            },
        },
    },

    plugins: [forms],
};
