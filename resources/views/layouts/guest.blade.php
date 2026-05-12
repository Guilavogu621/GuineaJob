<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GuinéaJob') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-[#085041]">
        <div class="min-h-screen flex flex-col justify-center items-center p-6 bg-[#085041] relative overflow-hidden">
            
            <!-- Fond décoratif aux couleurs de la Guinée (Vert, Or, Rouge) -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute -top-24 -left-24 w-96 h-96 bg-[#0F6E56] rounded-full blur-[120px] opacity-30"></div>
                <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full h-full bg-[#BA7517] rounded-full blur-[150px] opacity-10"></div>
                <div class="absolute -bottom-24 -right-24 w-96 h-96 bg-[#993C1D] rounded-full blur-[120px] opacity-20"></div>
            </div>

            <!-- Carte de connexion -->
            <div class="relative z-10 w-full max-w-[450px] bg-white shadow-2xl rounded-[2rem] overflow-hidden">
                <div class="p-10 md:p-12">
                    <div class="flex justify-center mb-10">
                        <a href="/">
                            <x-application-logo />
                        </a>
                    </div>
                    
                    {{ $slot }}
                </div>
            </div>

            <!-- Footer -->
            <div class="relative z-10 mt-8 text-gray-500 text-xs font-medium uppercase tracking-widest">
                © {{ date('Y') }} GuinéaJob • Plateforme Sécurisée
            </div>
        </div>
    </body>
</html>
