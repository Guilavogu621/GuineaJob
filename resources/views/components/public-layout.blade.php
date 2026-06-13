<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth overflow-x-hidden">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'GuinéaJob') }} | La Plateforme RH et Emploi</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=inter:400,500" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body { font-family: 'Inter', sans-serif; }
            h1, h2, h3, h4, h5, h6 { font-family: 'Inter', sans-serif; }
            .glass-header { backdrop-filter: blur(12px); background: rgba(255, 255, 255, 0.95); }

            /* Animations */
            @keyframes float {
                0% { transform: translateY(0px); }
                50% { transform: translateY(-12px); }
                100% { transform: translateY(0px); }
            }
            .animate-float { animation: float 6s ease-in-out infinite; }
        </style>
    </head>
    <body class="antialiased bg-[#F1EFE8] text-[#2C2C2A] overflow-x-hidden flex flex-col min-h-screen">

        <!-- Navigation -->
        <nav class="fixed w-full z-50 glass-header border-b border-gray-100 transition-all duration-300">
            <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-20">
                    <a href="{{ url('/') }}" class="flex items-center gap-3 group cursor-pointer">
                        <div class="bg-[#0F6E56] w-10 h-10 rounded-xl flex items-center justify-center shadow-lg shadow-[#0F6E56]/20 group-hover:scale-105 transition-transform">
                            <span class="text-white font-black text-xl">GJ</span>
                        </div>
                        <span class="text-2xl font-black tracking-tighter text-[#2C2C2A] hidden sm:block">Guinéa<span class="text-[#0F6E56]">Job</span></span>
                    </a>

                    <div class="hidden lg:flex items-center gap-8">
                        <a href="{{ url('/') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Accueil</a>
                        <a href="{{ url('/#services') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Services</a>
                        <a href="{{ url('/#entreprises') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Entreprises</a>
                        <a href="{{ route('jobboard.index') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Emplois</a>
                        <a href="{{ route('appels.public.index') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Marchés B2B</a>
                        <a href="{{ url('/#contact') }}" class="text-[15px] font-bold text-gray-600 hover:text-[#0F6E56] transition-colors relative after:absolute after:bottom-0 after:left-0 after:w-0 after:h-0.5 after:bg-[#0F6E56] hover:after:w-full after:transition-all">Contact</a>
                    </div>

                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="px-6 py-2.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] shadow-lg shadow-[#0F6E56]/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="hidden sm:block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56] transition-colors">Connexion</a>
                            <a href="{{ route('register') }}" class="px-6 py-2.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] shadow-lg shadow-[#0F6E56]/30 hover:shadow-xl hover:-translate-y-0.5 transition-all">Inscription</a>
                        @endauth

                        <!-- Bouton Mobile Menu -->
                        <button onclick="toggleMobileMenu()" class="lg:hidden p-2 bg-slate-50 border border-slate-100 rounded-xl text-slate-600 hover:text-[#0F6E56] hover:bg-slate-100 transition-all">
                            <svg id="menuIcon" class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Mobile Drawer -->
            <div id="mobileMenu" class="hidden lg:hidden border-t border-gray-100 bg-white/95 backdrop-blur-lg absolute w-full left-0 shadow-xl transition-all duration-300">
                <div class="px-6 py-8 space-y-4">
                    <a href="{{ url('/') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Accueil</a>
                    <a href="{{ url('/#services') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Services</a>
                    <a href="{{ url('/#entreprises') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Entreprises</a>
                    <a href="{{ route('jobboard.index') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Emplois</a>
                    <a href="{{ route('appels.public.index') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Marchés B2B</a>
                    <a href="{{ url('/#contact') }}" onclick="toggleMobileMenu()" class="block text-[15px] font-bold text-gray-700 hover:text-[#0F6E56]">Contact</a>
                    @guest
                        <div class="pt-4 border-t border-gray-100 flex flex-col gap-3">
                            <a href="{{ route('login') }}" class="text-center py-3 border border-gray-200 rounded-xl text-sm font-bold text-gray-700 hover:bg-gray-50">Connexion</a>
                        </div>
                    @endguest
                </div>
            </div>
        </nav>

        <!-- Main Content -->
        <main class="flex-grow pt-20">
            {{ $slot }}
        </main>

        <!-- Footer -->
        <footer id="contact" class="pt-20 pb-10 bg-white border-t border-gray-100 mt-auto">
            <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-12 mb-16">
                    <div class="col-span-1 lg:col-span-1">
                        <div class="flex items-center gap-3 mb-6">
                            <div class="bg-[#0F6E56] w-12 h-12 rounded-2xl flex items-center justify-center shadow-lg shadow-[#0F6E56]/20">
                                <span class="text-white font-black text-xl">GJ</span>
                            </div>
                            <span class="text-3xl font-black tracking-tighter text-[#2C2C2A]">Guinéa<span class="text-[#0F6E56]">Job</span></span>
                        </div>
                        <p class="text-gray-500 font-medium text-sm leading-relaxed mb-8">
                            La plateforme nationale digitale pour la gestion des talents, des contrats et des affaires en République de Guinée.
                        </p>
                    </div>

                    <div>
                        <h4 class="font-black text-[#2C2C2A] mb-8 uppercase tracking-[0.15em] text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#0F6E56]"></span> Nos Services</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ route('jobboard.index') }}" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Recrutement & Talents</a></li>
                            <li><a href="{{ url('/#services') }}" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Gestion RH automatisée</a></li>
                            <li><a href="{{ url('/#entreprises') }}" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Génération de contrats (Signature)</a></li>
                            <li><a href="{{ route('appels.public.index') }}" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Appels d'offres B2B</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-black text-[#2C2C2A] mb-8 uppercase tracking-[0.15em] text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#0F6E56]"></span> L'Entreprise</h4>
                        <ul class="space-y-4">
                            <li><a href="{{ url('/#entreprises') }}" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">À propos de nous</a></li>
                            <li><a href="#" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Témoignages clients</a></li>
                            <li><a href="#" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Conditions d'utilisation (CGU)</a></li>
                            <li><a href="#" class="text-gray-500 hover:text-[#0F6E56] transition-colors font-medium hover:translate-x-1 inline-block">Politique de confidentialité</a></li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="font-black text-[#2C2C2A] mb-8 uppercase tracking-[0.15em] text-sm flex items-center gap-2"><span class="w-2 h-2 rounded-full bg-[#0F6E56]"></span> Contact</h4>
                        <ul class="space-y-6">
                            <li class="flex items-start gap-4 text-gray-500 font-medium">
                                <div class="bg-[#F1EFE8] p-2.5 rounded-xl text-[#0F6E56] shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                                <span class="mt-1">Kaloum, Conakry<br>République de Guinée</span>
                            </li>
                            <li class="flex items-start gap-4 text-gray-500 font-medium">
                                <div class="bg-[#F1EFE8] p-2.5 rounded-xl text-[#0F6E56] shrink-0"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg></div>
                                <span class="mt-1">contact@guineajob.com<br>support@guineajob.com</span>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="pt-8 border-t border-gray-100 flex flex-col md:flex-row justify-between items-center gap-6">
                    <p class="text-sm text-gray-400 font-medium">&copy; {{ date('Y') }} GuinéaJob. Tous droits réservés.</p>
                    <div class="flex gap-4">
                        <a href="#" class="w-10 h-10 rounded-full bg-[#F1EFE8] flex items-center justify-center text-gray-400 hover:bg-[#0F6E56] hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#F1EFE8] flex items-center justify-center text-gray-400 hover:bg-[#0F6E56] hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M19 0h-14c-2.761 0-5 2.239-5 5v14c0 2.761 2.239 5 5 5h14c2.762 0 5-2.239 5-5v-14c0-2.761-2.238-5-5-5zm-11 19h-3v-11h3v11zm-1.5-12.268c-.966 0-1.75-.79-1.75-1.764s.784-1.764 1.75-1.764 1.75.79 1.75 1.764-.783 1.764-1.75 1.764zm13.5 12.268h-3v-5.604c0-3.368-4-3.113-4 0v5.604h-3v-11h3v1.765c1.396-2.586 7-2.777 7 2.476v6.759z"/></svg>
                        </a>
                        <a href="#" class="w-10 h-10 rounded-full bg-[#F1EFE8] flex items-center justify-center text-gray-400 hover:bg-[#0F6E56] hover:text-white transition-all shadow-sm">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 0c-6.627 0-12 5.373-12 12s5.373 12 12 12 12-5.373 12-12-5.373-12-12-12zm3 8h-1.35c-.538 0-.65.221-.65.778v1.222h2l-.209 2h-1.791v7h-3v-7h-2v-2h2v-2.308c0-1.769.931-2.692 3.029-2.692h1.971v3z"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </footer>
        <script>
            function toggleMobileMenu() {
                const menu = document.getElementById('mobileMenu');
                const icon = document.getElementById('menuIcon');

                if (menu.classList.contains('hidden')) {
                    menu.classList.remove('hidden');
                    // Change icon to X
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>';
                } else {
                    menu.classList.add('hidden');
                    // Change icon back to Hamburger
                    icon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>';
                }
            }
        </script>
    </body>
</html>
