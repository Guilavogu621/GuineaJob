<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GuinéaJob') }} | Authentification</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-medium { font-weight: 500; }
    </style>
</head>
<body class="h-full bg-[#F1EFE8] text-[#2C2C2A] selection:bg-[#1D9E75]/20 selection:text-[#0F6E56]">
    <div class="min-h-screen flex">
        <!-- LEFT SIDE (Formulaire) -->
        <div class="w-full lg:w-1/2 bg-white border-r border-[#D3D1C7]/60 flex flex-col py-8 px-6 sm:px-12 lg:px-20 overflow-y-auto">
            <!-- Logo -->
            <div class="mb-10 lg:mb-14">
                <a href="{{ url('/') }}" class="inline-flex items-center gap-3">
                    <x-application-logo />
                </a>
                <p class="text-[15px] text-[#888780] mt-2">
                    Plateforme de gestion des contrats de travail en Guinée
                </p>
            </div>

            <!-- Form Slot -->
            <div class="w-full max-w-[420px] mx-auto flex-1 flex flex-col justify-center">
                {{ $slot }}
            </div>

            <!-- Footer Links -->
            <div class="mt-10 lg:mt-14 flex flex-col text-sm text-[#888780]">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4 text-[15px] pt-6 border-t border-[#D3D1C7]/50">
                    <span>© {{ date('Y') }} GuinéaJob. Tous droits réservés.</span>
                    <div class="flex gap-4">
                        <a href="#" class="hover:text-[#0F6E56] transition-colors">Confidentialité</a>
                        <a href="#" class="hover:text-[#0F6E56] transition-colors">Conditions</a>
                        <a href="/" class="hover:text-[#0F6E56] transition-colors">Retour au site</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT SIDE (Visuel) -->
        <div class="hidden lg:flex w-1/2 relative overflow-hidden flex-col justify-end p-12 lg:p-16">
            <!-- Background Image -->
            <div class="absolute inset-0 w-full h-full">
                <img src="{{ asset('images/auth-bg.png') }}" class="w-full h-full object-cover" style="object-position: center center;" alt="Plateforme GuinéaJob">
                <!-- Neutral dark gradient overlay for text contrast -->
                <div class="absolute inset-0" style="background: linear-gradient(to bottom, rgba(0,0,0,0.1) 0%, rgba(0,0,0,0.85) 100%);"></div>
            </div>

            <!-- Content (Overlay) -->
            <div class="relative z-10 w-full max-w-xl">
                <!-- Badge -->
                <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-[#1D9E75] text-[#1D9E75] text-sm font-medium mb-12 bg-[#05190F]/40 backdrop-blur-sm">
                    <span class="relative flex h-2 w-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-[#1D9E75] opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-[#1D9E75]"></span>
                    </span>
                    Plateforme RH n°1 en Guinée
                </div>

                <!-- Avatars -->
                <div class="flex items-center gap-4 mb-8">
                    <div class="flex -space-x-3">
                        <div class="w-10 h-10 rounded-full bg-[#1D9E75] flex items-center justify-center text-white text-xs font-medium border-2 border-[#2C2C2A]">MK</div>
                        <div class="w-10 h-10 rounded-full bg-[#BA7517] flex items-center justify-center text-white text-xs font-medium border-2 border-[#2C2C2A]">AB</div>
                        <div class="w-10 h-10 rounded-full bg-[#993C1D] flex items-center justify-center text-white text-xs font-medium border-2 border-[#2C2C2A]">SW</div>
                        <div class="w-10 h-10 rounded-full bg-[#0F6E56] flex items-center justify-center text-white text-xs font-medium border-2 border-[#2C2C2A]">FD</div>
                        <div class="w-10 h-10 rounded-full bg-[#1D9E75] flex items-center justify-center text-white text-xs font-medium border-2 border-[#2C2C2A]">+</div>
                    </div>
                    <div class="text-white/90 text-base font-medium">
                        Rejoignez 12 000+ professionnels
                    </div>
                </div>

                <h2 class="text-5xl text-white font-medium leading-[1.15] tracking-tight mb-5">
                    Centralisez vos RH.<br>
                    <span class="text-[#1D9E75]">Développez votre entreprise.</span>
                </h2>

                <p class="text-[rgba(255,255,255,0.6)] text-lg leading-relaxed max-w-lg mb-12">
                    Rejoignez des milliers de professionnels et d'entreprises qui ont choisi GuinéaJob pour simplifier le recrutement et la gestion des talents.
                </p>

                <!-- Bottom Stat Cards -->
                <div class="grid grid-cols-3 gap-4">
                    <div class="rounded-xl p-6 backdrop-blur-md" style="background: rgba(255,255,255,0.08) !important; border: 0.5px solid rgba(255,255,255,0.12) !important; box-shadow: none !important;">
                        <div class="text-white text-3xl font-medium mb-1">12K+</div>
                        <div class="text-white/60 text-sm">Talents actifs</div>
                    </div>
                    <div class="rounded-xl p-6 backdrop-blur-md" style="background: rgba(255,255,255,0.08) !important; border: 0.5px solid rgba(255,255,255,0.12) !important; box-shadow: none !important;">
                        <div class="text-white text-3xl font-medium mb-1">3 500+</div>
                        <div class="text-white/60 text-sm">Entreprises</div>
                    </div>
                    <div class="rounded-xl p-6 backdrop-blur-md" style="background: rgba(255,255,255,0.08) !important; border: 0.5px solid rgba(255,255,255,0.12) !important; box-shadow: none !important;">
                        <div class="text-white text-3xl font-medium mb-1">98%</div>
                        <div class="text-white/60 text-sm">Satisfaction</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
