import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'guinea-user': '#534AB7',       // Violet - Utilisateurs
                'guinea-entreprise': '#0F6E56', // Vert - Entreprise & Contrat
                'guinea-employe': '#185FA5',    // Bleu - Employé, OffreEmploi, Candidature
                'guinea-paie': '#BA7517',       // Or - FichePaie
                'guinea-conge': '#D4537E',      // Rose - Congé
                'guinea-ao': '#639922',         // Vert clair - AppelOffres
                'guinea-notif': '#D85A30',      // Orange - Notification
                // Conserver l'existant pour la rétrocompatibilité (Contrat existant)
                'guinea-green': {
                    DEFAULT: '#0F6E56',
                    light: '#1D9E75',
                    pale: '#E1F5EE',
                },
                'guinea-gold': {
                    DEFAULT: '#BA7517',
                    pale: '#FAEEDA',
                },
                'guinea-red': {
                    DEFAULT: '#993C1D',
                    pale: '#FCEBEB',
                },
                'guinea-gray': {
                    dark: '#2C2C2A',
                    medium: '#888780',
                    warm: '#F1EFE8',
                }
            }
        },
    },

    plugins: [forms],
};
