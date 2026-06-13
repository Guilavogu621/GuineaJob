<div class="flex flex-col h-full bg-[#0F6E56] text-white">
    <!-- En-tête / Profil Candidat -->
    <div class="p-5 border-b border-white/10 relative overflow-hidden">
        <!-- Bande décorative -->
        <div class="absolute top-0 left-0 right-0 h-1 flex">
            <div class="h-full flex-1 bg-[#993C1D]"></div>
            <div class="h-full flex-1 bg-[#BA7517]"></div>
            <div class="h-full flex-1 bg-[#1D9E75]"></div>
        </div>
        <!-- Cercle décoratif -->
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
        <div class="flex items-center gap-4 relative z-10 mt-1">
            <div class="w-10 h-10 rounded-lg bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-medium text-sm font-outfit uppercase shadow-sm">
                {{ substr(Auth::user()->prenom ?? Auth::user()->nom ?? 'U', 0, 1) }}
            </div>
            <div class="min-w-0">
                <div class="text-[15px] font-bold text-white truncate leading-none mb-1.5 uppercase">{{ Auth::user()->prenom ?? Auth::user()->nom ?? 'Utilisateur' }}</div>
                <div class="text-[15px] text-[#E1F5EE]/80 uppercase tracking-wider font-medium leading-none">{{ Auth::user()->hasRole('prestataire') ? 'Prestataire' : 'Candidat' }}</div>
            </div>
        </div>
    </div>

    <!-- Liens de navigation -->
    <nav class="flex-grow p-4 space-y-6 overflow-y-auto hide-scrollbar">
        <div>
            <span class="text-[15px] uppercase text-[#E1F5EE]/60 font-semibold tracking-wider mb-3 block px-3">Mon Espace</span>
            <div class="space-y-1">
                <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Tableau de bord
                </a>

                <a href="{{ route('profile.edit') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('profile.edit') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" /></svg>
                    Mon Profil / CV
                </a>
                
                <a href="{{ route('candidate.jobs.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('candidate.jobs.*') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    Trouver un emploi
                </a>
            </div>
        </div>
    </nav>

    <!-- Déconnexion -->
    <div class="p-4 border-t border-white/10">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 text-[15px] font-medium text-[#FCEBEB] hover:bg-white/10 hover:text-white rounded-xl transition-all border-none">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6a2.25 2.25 0 00-2.25 2.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15M12 9l-3 3m0 0l3 3m-3-3h12.75" /></svg>
                Déconnexion
            </button>
        </form>
    </div>
</div>
