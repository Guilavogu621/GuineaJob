<div class="flex flex-col h-full bg-[#0F6E56] text-white">
    <!-- En-tête / Profil Employé -->
    <div class="p-5 border-b border-white/10 relative overflow-hidden">
        <!-- Bande décorative drapeau (CDC) -->
        <div class="absolute top-0 left-0 right-0 h-1 flex">
            <div class="h-full flex-1 bg-[#993C1D]"></div>
            <div class="h-full flex-1 bg-[#BA7517]"></div>
            <div class="h-full flex-1 bg-[#1D9E75]"></div>
        </div>
        <!-- Cercle décoratif -->
        <div class="absolute -right-4 -top-4 w-24 h-24 bg-white/5 rounded-full"></div>
        <div class="flex items-center gap-4 relative z-10 mt-1">
            <div class="w-10 h-10 rounded-lg bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56] font-medium text-sm font-outfit uppercase shadow-sm">
                {{ substr(Auth::user()->prenom ?? 'E', 0, 1) }}
            </div>
            <div class="min-w-0">
                <div class="text-[15px] font-bold text-white truncate leading-none mb-1.5 uppercase">{{ Auth::user()->prenom ?? 'Salarié' }}</div>
                <div class="text-[15px] text-[#E1F5EE]/80 uppercase tracking-wider font-medium leading-none">Employé</div>
            </div>
        </div>
    </div>

    <!-- Liens de navigation -->
    <nav class="flex-grow p-4 space-y-6 overflow-y-auto hide-scrollbar">
        <div>
            <span class="text-[15px] uppercase text-[#E1F5EE]/60 font-semibold tracking-wider mb-3 block px-3">Mon Espace</span>
            <div class="space-y-1">
                <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('employee.dashboard') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Tableau de bord
                </a>

                <a href="{{ route('employee.contract.show') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('employee.contract.show') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Mon Contrat
                </a>

                <a href="{{ route('employee.paie.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('employee.paie.*') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m-3-2.818l.22.058a7.068 7.068 0 011.832 2.541m0 0A7.07 7.07 0 0013.882 15.2m-3.83 3.04a7.07 7.07 0 01-2.541-1.832m0 0A7.07 7.07 0 005.2 13.882m9.47-9.47a7.07 7.07 0 00-1.832-2.541m0 0A7.07 7.07 0 008.8 5.2m3.83-3.04A7.07 7.07 0 0115.172 4m0 0a7.07 7.07 0 012.541 1.832M12 2.25V1.5m0 21v-.75m0-18v18m0-18a7.5 7.5 0 017.5 7.5M12 19.5a7.5 7.5 0 01-7.5-7.5M12 12a3 3 0 100-6 3 3 0 000 6z" /></svg>
                    Mes Bulletins
                </a>

                <a href="{{ route('employee.conges.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('employee.conges.*') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" /></svg>
                    Mes Congés
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
