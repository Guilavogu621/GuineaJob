<div class="flex flex-col h-full bg-[#0F6E56] text-white">
    <!-- En-tête / Profil Admin -->
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
                {{ substr(Auth::user()->prenom ?? 'A', 0, 1) }}
            </div>
            <div class="min-w-0">
                <div class="text-[15px] font-bold text-white truncate leading-none mb-1.5 uppercase">{{ Auth::user()->prenom ?? 'Admin' }}</div>
                <div class="text-[15px] text-[#E1F5EE]/80 uppercase tracking-wider font-medium leading-none">Administrateur</div>
            </div>
        </div>
    </div>

    <!-- Liens de navigation -->
    <nav class="flex-grow p-4 space-y-6 overflow-y-auto hide-scrollbar">
        <div>
            <span class="text-[15px] uppercase text-[#E1F5EE]/60 font-semibold tracking-wider mb-3 block px-3">Administration</span>
            <div class="space-y-1">
                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('admin.dashboard') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Entreprises
                </a>

                <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('admin.users.*') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.109A11.386 11.386 0 0110.089 21m-5.34-2.236a9.337 9.337 0 014.121-.952 9.38 9.38 0 012.625.372M2.25 18v-.003a4.125 4.125 0 017.533-2.493M12 9.75a3.75 3.75 0 100-7.5 3.75 3.75 0 000 7.5zm4.5 1.5a3.5 3.5 0 100-7 3.5 3.5 0 000 7zM4.5 11.25a3.5 3.5 0 100-7 3.5 3.5 0 000 7z" /></svg>
                    Utilisateurs
                </a>

                <a href="{{ route('admin.contracts.index') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('admin.contracts.*') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z" /></svg>
                    Contrats
                </a>
            </div>
        </div>

        <div>
            <span class="text-[15px] uppercase text-[#E1F5EE]/60 font-semibold tracking-wider mb-3 block px-3">Outils</span>
            <div class="space-y-1">
                <a href="{{ route('admin.statistics') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium transition-all {{ request()->routeIs('admin.statistics') ? 'bg-[#E1F5EE] text-[#0F6E56] shadow-sm' : 'text-[#E1F5EE] hover:bg-white/10 hover:text-white' }}">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10.5 6a7.5 7.5 0 107.5 7.5h-7.5V6z" /><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 10.5H21A7.5 7.5 0 0013.5 3v7.5z" /></svg>
                    Rapports
                </a>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-[15px] font-medium text-[#E1F5EE] hover:bg-white/10 hover:text-white transition-all">
                    <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 011.37.49l1.296 2.247a1.125 1.125 0 01-.26 1.43l-1.003.828c-.293.241-.438.613-.43.992a7.723 7.723 0 010 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 01-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 01-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 01-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 01-1.369-.49l-1.297-2.247a1.125 1.125 0 01.26-1.43l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 010-.255c.007-.378-.138-.75-.43-.991l-1.004-.827a1.125 1.125 0 01-.26-1.43l1.297-2.247a1.125 1.125 0 011.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.645-.869L9.594 3.94zM12 15a3 3 0 100-6 3 3 0 000 6z" /></svg>
                    Paramètres
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
