<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'GuinéaJob') }} | Espace</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body { font-family: 'Inter', system-ui, sans-serif; }
        .font-medium { font-weight: 500; }
    </style>
</head>
<body class="min-h-screen bg-[#F1EFE8] text-[#2C2C2A]">
    @php
        $user = Auth::user();
        $activeRole = null;
        $displayRole = 'Utilisateur';

        if ($user) {
            if ($user->hasRole('admin')) {
                $activeRole = 'admin';
                $displayRole = 'Administrateur';
            } elseif ($user->hasRole('employeur')) {
                $activeRole = 'employeur';
                $displayRole = 'Employeur';
            } elseif ($user->hasRole('employe')) {
                $activeRole = 'employe';
                $displayRole = 'Employé';
            } elseif ($user->hasRole('candidat')) {
                $activeRole = 'candidat';
                $displayRole = 'Candidat';
            } elseif ($user->hasRole('prestataire')) {
                $activeRole = 'prestataire';
                $displayRole = 'Prestataire';
            }
        }

        $hasSidebar = in_array($activeRole, ['admin', 'employeur', 'employe', 'candidat', 'prestataire'], true);
    @endphp

    <div x-data="{ sidebarOpen: false }" class="min-h-screen flex relative">
        @if($hasSidebar)
            <!-- Sidebar Desktop -->
            <aside class="hidden lg:block w-72 lg:w-80 shrink-0 border-r border-[#0F6E56] bg-[#0F6E56]">
                @if($activeRole === 'admin')
                    <x-admin-sidebar />
                @elseif($activeRole === 'employeur')
                    <x-employer-sidebar />
                @elseif($activeRole === 'employe')
                    <x-employee-sidebar />
                @elseif($activeRole === 'candidat' || $activeRole === 'prestataire')
                    <x-candidate-sidebar />
                @endif
            </aside>

            <!-- Sidebar Mobile (Drawer) -->
            <div x-show="sidebarOpen" 
                 class="fixed inset-0 z-50 flex lg:hidden" 
                 style="display: none;"
                 role="dialog" 
                 aria-modal="true">
                <!-- Overlay -->
                <div x-show="sidebarOpen"
                     x-transition:enter="transition-opacity ease-linear duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition-opacity ease-linear duration-300"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     @click="sidebarOpen = false"
                     class="fixed inset-0 bg-[#2C2C2A]/60 backdrop-blur-sm"></div>

                <!-- Panel -->
                <div x-show="sidebarOpen"
                     x-transition:enter="transition ease-in-out duration-300 transform"
                     x-transition:enter-start="-translate-x-full"
                     x-transition:enter-end="translate-x-0"
                     x-transition:leave="transition ease-in-out duration-300 transform"
                     x-transition:leave-start="translate-x-0"
                     x-transition:leave-end="-translate-x-full"
                     class="relative flex w-full max-w-xs flex-1 flex-col bg-[#0F6E56] pt-5 pb-4">
                    
                    <div class="absolute top-2 right-2">
                        <button type="button" 
                                @click="sidebarOpen = false"
                                class="flex h-10 w-10 items-center justify-center rounded-full text-white bg-[#0A5A45] hover:bg-[#084837] focus:outline-none">
                            <span class="sr-only">Fermer la barre</span>
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="flex-1 h-0 overflow-y-auto mt-8">
                        @if($activeRole === 'admin')
                            <x-admin-sidebar />
                        @elseif($activeRole === 'employeur')
                            <x-employer-sidebar />
                        @elseif($activeRole === 'employe')
                            <x-employee-sidebar />
                        @elseif($activeRole === 'candidat' || $activeRole === 'prestataire')
                            <x-candidate-sidebar />
                        @endif
                    </div>
                </div>
            </div>
        @endif

        <div class="flex-1 min-w-0 flex flex-col">
            <header class="h-16 bg-white border-b border-[#D3D1C7]/70 px-6 flex items-center justify-between gap-4">
                <div class="flex items-center gap-4">
                    @if($hasSidebar)
                        <button type="button" 
                                @click="sidebarOpen = true"
                                class="lg:hidden p-2 -ml-2 text-[#2C2C2A] hover:text-[#0F6E56] transition-colors focus:outline-none rounded-lg"
                                aria-label="Ouvrir le menu">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    @endif

                    @if(!$hasSidebar)
                        <a href="{{ url('/') }}" class="flex items-center gap-2">
                            <x-application-logo />
                        </a>
                        <nav class="hidden md:flex items-center gap-5 text-[15px] font-medium text-[#888780]">
                            <a href="{{ route('jobboard.index') }}" class="hover:text-[#0F6E56] transition-colors">Offres d'emploi</a>
                            <a href="{{ route('appels.public.index') }}" class="hover:text-[#0F6E56] transition-colors">Marchés B2B</a>
                            <a href="{{ route('dashboard') }}" class="hover:text-[#0F6E56] transition-colors">Mon espace</a>
                        </nav>
                    @else
                        <div class="flex items-center gap-2 text-sm font-medium text-[#2C2C2A]">
                            <div class="w-8 h-8 rounded-lg bg-[#0F6E56] text-white flex items-center justify-center text-[15px] font-medium">GJ</div>
                            <span>GuinéaJob</span>
                        </div>
                    @endif
                </div>

                @auth
                    <div class="flex items-center gap-3">
                        <div class="hidden sm:flex flex-col leading-tight text-right">
                            <span class="text-[15px] font-medium text-[#2C2C2A]">{{ $user->full_name }}</span>
                            <span class="text-[15px] text-[#888780]">{{ $displayRole }}</span>
                        </div>
                        <div class="w-9 h-9 rounded-full bg-[#E1F5EE] text-[#0F6E56] flex items-center justify-center font-medium text-[15px]">
                            {{ strtoupper(substr($user->prenom ?? $user->nom ?? 'U', 0, 1)) }}
                        </div>
                        <div class="hidden sm:flex items-center gap-2">
                            <a href="{{ route('profile.edit') }}" class="btn btn-outline btn-sm">Profil</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-sm">Déconnexion</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </header>

            <main class="flex-1 overflow-y-auto">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
