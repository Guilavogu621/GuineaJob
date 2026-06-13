<style>
    :root {
        --navbar-bg: rgba(255, 255, 255, 0.85);
        --navbar-text: #2C2C2A;
        --navbar-text-muted: #888780;
        --navbar-accent: #0F6E56;
        --navbar-accent-hover: #0A5A45;
        --navbar-border: rgba(15, 110, 86, 0.1);
        --navbar-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
        --navbar-shadow-scrolled: 0 10px 30px -10px rgba(15, 110, 86, 0.15);
    }

    .saas-navbar {
        background-color: var(--navbar-bg);
        backdrop-filter: blur(16px);
        -webkit-backdrop-filter: blur(16px);
        border-bottom: 1px solid var(--navbar-border);
        transition: all 0.3s ease-in-out;
    }

    .saas-navbar.is-scrolled {
        box-shadow: var(--navbar-shadow-scrolled);
        background-color: rgba(255, 255, 255, 0.95);
        border-bottom-color: transparent;
    }

    /* Utilitaires pour les délais d'animation */
    .delay-100 { transition-delay: 100ms; }
    .delay-150 { transition-delay: 150ms; }
    .delay-200 { transition-delay: 200ms; }
</style>

<nav x-data="{
        scrolled: false,
        mobileMenuOpen: false,
        activeDropdown: null,
        toggleDropdown(name) {
            this.activeDropdown = (this.activeDropdown === name) ? null : name;
        },
        closeDropdowns() {
            this.activeDropdown = null;
        }
    }"
    @scroll.window="scrolled = (window.pageYOffset > 10)"
    @keydown.escape.window="closeDropdowns(); mobileMenuOpen = false"
    :class="{ 'is-scrolled': scrolled }"
    class="saas-navbar fixed top-0 inset-x-0 z-50 h-[56px] md:h-[64px] lg:h-[72px] flex items-center font-inter"
    role="navigation"
    aria-label="Navigation Principale">

    <div class="max-w-[1280px] mx-auto w-full px-4 sm:px-6 lg:px-8 flex justify-between items-center h-full">

        <!-- 1. Logo -->
        <div class="flex-shrink-0 flex items-center">
            <a href="{{ url('/') }}" class="flex items-center gap-2 group outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56] rounded-lg">
                <div class="bg-[#0F6E56] w-8 h-8 lg:w-9 lg:h-9 rounded-xl flex items-center justify-center shadow-lg shadow-[#0F6E56]/20 group-hover:scale-105 transition-transform duration-300">
                    <span class="text-white font-black text-sm lg:text-base font-outfit">GJ</span>
                </div>
                <span class="text-xl lg:text-2xl font-black tracking-tighter text-[#2C2C2A] font-outfit">Guinéa<span class="text-[#0F6E56]">Job</span></span>
            </a>
        </div>

        <!-- 2. Navigation Principale (Desktop) -->
        <div class="hidden lg:flex items-center gap-1 h-full" @click.away="closeDropdowns()">

            <!-- Item: Produit (Mega Menu) -->
            <div class="relative h-full flex items-center" @mouseenter="activeDropdown = 'produit'" @mouseleave="setTimeout(() => { if(activeDropdown === 'produit') activeDropdown = null }, 200)">
                <button @click="toggleDropdown('produit')" class="px-4 py-2 text-[15px] font-bold text-[#2C2C2A] hover:text-[#0F6E56] rounded-lg transition-colors flex items-center gap-1 outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" :aria-expanded="activeDropdown === 'produit'">
                    Produit
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': activeDropdown === 'produit'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Mega Menu -->
                <div x-show="activeDropdown === 'produit'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute top-[calc(100%-8px)] left-1/2 -translate-x-1/2 w-[800px] bg-white rounded-2xl shadow-xl border border-slate-100 p-6 z-50 cursor-default"
                     style="display: none;"
                     role="menu">
                    <div class="grid grid-cols-3 gap-8">
                        <div>
                            <h3 class="text-[15px] font-black uppercase tracking-widest text-slate-400 mb-4 px-2">Pour les Entreprises</h3>
                            <ul class="space-y-1">
                                <li>
                                    <a href="#" class="flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors group outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">
                                        <div class="w-10 h-10 rounded-lg bg-[#E1F5EE] text-[#0F6E56] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-[#2C2C2A] group-hover:text-[#0F6E56] transition-colors">Recrutement</div>
                                            <div class="text-xs text-slate-500 font-medium mt-0.5">Trouvez les meilleurs talents rapidement.</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors group outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">
                                        <div class="w-10 h-10 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-[#2C2C2A] group-hover:text-blue-600 transition-colors">Gestion des contrats</div>
                                            <div class="text-xs text-slate-500 font-medium mt-0.5">Générez et signez vos contrats en ligne.</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div>
                            <h3 class="text-[15px] font-black uppercase tracking-widest text-slate-400 mb-4 px-2">Pour les Candidats</h3>
                            <ul class="space-y-1">
                                <li>
                                    <a href="#" class="flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors group outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">
                                        <div class="w-10 h-10 rounded-lg bg-[#FAEEDA] text-[#BA7517] flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-[#2C2C2A] group-hover:text-[#BA7517] transition-colors">Offres d'emploi</div>
                                            <div class="text-xs text-slate-500 font-medium mt-0.5">Explorez des milliers d'opportunités.</div>
                                        </div>
                                    </a>
                                </li>
                                <li>
                                    <a href="#" class="flex items-start gap-3 p-2 rounded-xl hover:bg-slate-50 transition-colors group outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">
                                        <div class="w-10 h-10 rounded-lg bg-purple-50 text-purple-600 flex items-center justify-center shrink-0 group-hover:scale-105 transition-transform">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-[#2C2C2A] group-hover:text-purple-600 transition-colors">Profil interactif</div>
                                            <div class="text-xs text-slate-500 font-medium mt-0.5">Mettez en avant vos compétences.</div>
                                        </div>
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="bg-slate-50 rounded-xl p-5 border border-slate-100 flex flex-col justify-between">
                            <div>
                                <div class="inline-flex items-center gap-2 px-3 py-1 bg-white border border-slate-200 text-[15px] font-black uppercase tracking-widest rounded-full text-[#0F6E56] mb-4">Nouveauté</div>
                                <h4 class="text-sm font-bold text-[#2C2C2A] mb-2">B2B Opportunities</h4>
                                <p class="text-xs text-slate-500 font-medium leading-relaxed">Découvrez notre nouvel espace dédié aux prestataires de services et appels d'offres.</p>
                            </div>
                            <a href="#" class="text-xs font-bold text-[#0F6E56] hover:text-[#0A5A45] hover:underline mt-4 inline-flex items-center outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56] rounded">En savoir plus →</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Item: Fonctionnalités -->
            <div class="h-full flex items-center">
                <a href="#" class="px-4 py-2 text-[15px] font-bold text-[#2C2C2A] hover:text-[#0F6E56] rounded-lg transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]">Fonctionnalités</a>
            </div>

            <!-- Item: Tarifs -->
            <div class="h-full flex items-center">
                <a href="#" class="px-4 py-2 text-[15px] font-bold text-[#2C2C2A] hover:text-[#0F6E56] rounded-lg transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]">Tarifs</a>
            </div>

            <!-- Item: Ressources (Dropdown) -->
            <div class="relative h-full flex items-center" @mouseenter="activeDropdown = 'ressources'" @mouseleave="setTimeout(() => { if(activeDropdown === 'ressources') activeDropdown = null }, 200)">
                <button @click="toggleDropdown('ressources')" class="px-4 py-2 text-[15px] font-bold text-[#2C2C2A] hover:text-[#0F6E56] rounded-lg transition-colors flex items-center gap-1 outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" :aria-expanded="activeDropdown === 'ressources'">
                    Ressources
                    <svg class="w-3.5 h-3.5 transition-transform duration-200" :class="{'rotate-180': activeDropdown === 'ressources'}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>

                <!-- Dropdown -->
                <div x-show="activeDropdown === 'ressources'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 translate-y-2"
                     class="absolute top-[calc(100%-8px)] left-0 w-64 bg-white rounded-2xl shadow-xl border border-slate-100 p-3 z-50"
                     style="display: none;"
                     role="menu">
                    <ul class="space-y-1">
                        <li><a href="#" class="block px-4 py-2.5 text-sm font-semibold text-[#2C2C2A] hover:bg-slate-50 hover:text-[#0F6E56] rounded-xl transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">Blog</a></li>
                        <li><a href="#" class="block px-4 py-2.5 text-sm font-semibold text-[#2C2C2A] hover:bg-slate-50 hover:text-[#0F6E56] rounded-xl transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">Documentation</a></li>
                        <li><a href="#" class="block px-4 py-2.5 text-sm font-semibold text-[#2C2C2A] hover:bg-slate-50 hover:text-[#0F6E56] rounded-xl transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">API Developers</a></li>
                        <li><a href="#" class="block px-4 py-2.5 text-sm font-semibold text-[#2C2C2A] hover:bg-slate-50 hover:text-[#0F6E56] rounded-xl transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" role="menuitem">Communauté</a></li>
                    </ul>
                </div>
            </div>

            <!-- Item: Contact -->
            <div class="h-full flex items-center">
                <a href="#" class="px-4 py-2 text-[15px] font-bold text-[#2C2C2A] hover:text-[#0F6E56] rounded-lg transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]">Contact</a>
            </div>
        </div>

        <!-- 3. Zone Droite (CTA & Auth) -->
        <div class="hidden lg:flex items-center gap-4">
            <!-- Recherche -->
            <button class="p-2 text-slate-400 hover:text-[#0F6E56] transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56] rounded-full" aria-label="Recherche">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </button>

            @auth
                <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] hover:-translate-y-0.5 transition-all shadow-lg shadow-[#0F6E56]/20 outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#0F6E56]">
                    Mon Espace
                </a>
            @else
                <a href="{{ route('login') }}" class="px-5 py-2.5 bg-white border border-slate-200 text-[#2C2C2A] text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-colors shadow-sm outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]">
                    Connexion
                </a>
                <a href="{{ route('register') }}" class="px-5 py-2.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] hover:-translate-y-0.5 transition-all shadow-lg shadow-[#0F6E56]/20 outline-none focus-visible:ring-2 focus-visible:ring-offset-2 focus-visible:ring-[#0F6E56]">
                    Essai gratuit
                </a>
            @endauth
        </div>

        <!-- Mobile Menu Button -->
        <div class="lg:hidden flex items-center">
            <button @click="mobileMenuOpen = !mobileMenuOpen" class="p-2 text-[#2C2C2A] hover:text-[#0F6E56] transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56] rounded-lg" aria-label="Ouvrir le menu">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
                </svg>
            </button>
        </div>
    </div>

    <!-- 4. Mobile Menu (Slide-in) -->
    <div x-show="mobileMenuOpen" style="display: none;" class="lg:hidden relative z-50">
        <!-- Overlay -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition-opacity ease-linear duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition-opacity ease-linear duration-300"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @click="mobileMenuOpen = false"
             class="fixed inset-0 bg-[#0F6E56]/40 backdrop-blur-sm"></div>

        <!-- Sidebar -->
        <div x-show="mobileMenuOpen"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="translate-x-full"
             class="fixed inset-y-0 right-0 max-w-xs w-full bg-white shadow-2xl flex flex-col">

            <div class="px-6 py-5 border-b border-slate-100 flex items-center justify-between">
                <span class="text-xl font-black tracking-tighter text-[#2C2C2A] font-outfit">Guinéa<span class="text-[#0F6E56]">Job</span></span>
                <button @click="mobileMenuOpen = false" class="p-2 text-slate-400 hover:text-[#0F6E56] rounded-lg transition-colors outline-none focus-visible:ring-2 focus-visible:ring-[#0F6E56]" aria-label="Fermer le menu">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-6">
                <nav class="space-y-6">
                    <div class="space-y-2">
                        <p class="px-2 text-[15px] font-black uppercase tracking-widest text-slate-400">Navigation</p>
                        <a href="#" class="block px-4 py-3 rounded-xl text-base font-bold text-[#2C2C2A] hover:bg-slate-50 transition-colors">Produit</a>
                        <a href="#" class="block px-4 py-3 rounded-xl text-base font-bold text-[#2C2C2A] hover:bg-slate-50 transition-colors">Fonctionnalités</a>
                        <a href="#" class="block px-4 py-3 rounded-xl text-base font-bold text-[#2C2C2A] hover:bg-slate-50 transition-colors">Tarifs</a>
                        <a href="#" class="block px-4 py-3 rounded-xl text-base font-bold text-[#2C2C2A] hover:bg-slate-50 transition-colors">Ressources</a>
                        <a href="#" class="block px-4 py-3 rounded-xl text-base font-bold text-[#2C2C2A] hover:bg-slate-50 transition-colors">Contact</a>
                    </div>
                </nav>
            </div>

            <div class="p-6 border-t border-slate-100 space-y-3">
                @auth
                    <a href="{{ url('/dashboard') }}" class="w-full flex justify-center py-3.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] transition-all shadow-lg shadow-[#0F6E56]/20">Mon Espace</a>
                @else
                    <a href="{{ route('login') }}" class="w-full flex justify-center py-3.5 bg-white border border-slate-200 text-[#2C2C2A] text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-slate-50 transition-colors shadow-sm">Connexion</a>
                    <a href="{{ route('register') }}" class="w-full flex justify-center py-3.5 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-[#0A5A45] transition-all shadow-lg shadow-[#0F6E56]/20">Essai gratuit</a>
                @endauth
            </div>
        </div>
    </div>
</nav>
