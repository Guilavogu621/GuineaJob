<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'GuinéaJob') }}</title>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased text-gray-900">
        <div class="min-h-screen bg-gray-100 flex">
            
            <!-- Sidebars basées sur le rôle (Section 7 CDC) -->
            @if(Auth::user()->isAdmin())
                <x-admin-sidebar />
            @elseif(Auth::user()->isEmployeur())
                <x-employer-sidebar />
            @elseif(Auth::user()->isEmploye())
                <x-employee-sidebar />
            @endif

            <!-- Main Content Area -->
            <div class="flex-1 {{ (Auth::user()->isAdmin() || Auth::user()->isEmployeur() || Auth::user()->isEmploye()) ? 'ml-64' : '' }}">
                
                <!-- On n'affiche la Top Nav que pour ceux qui n'ont pas de Sidebar -->
                @if(!Auth::user()->isAdmin() && !Auth::user()->isEmployeur() && !Auth::user()->isEmploye())
                    @include('layouts.navigation')
                @else
                    <!-- Top bar minimaliste pour les espaces Dashboard -->
                    <div class="h-20 bg-white border-b border-gray-200 flex items-center justify-end px-8 sticky top-0 z-10">
                        <div class="flex items-center gap-4">
                            <span class="text-sm font-medium text-gray-600">{{ Auth::user()->full_name }}</span>
                            <div class="w-10 h-10 rounded-full bg-[#0F6E56] flex items-center justify-center text-white font-bold uppercase">
                                {{ substr(Auth::user()->prenom, 0, 1) }}{{ substr(Auth::user()->nom, 0, 1) }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm border-b border-gray-100">
                        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    </body>
</html>
