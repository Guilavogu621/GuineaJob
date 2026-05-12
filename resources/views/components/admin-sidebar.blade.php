<div class="flex flex-col w-64 bg-[#0F6E56] h-screen fixed left-0 top-0 shadow-lg">
    <!-- Logo Space -->
    <div class="flex items-center justify-center h-20 border-b border-[#085041] px-4">
        <div class="flex items-center gap-2">
            <div class="flex items-center justify-center bg-white rounded-[8px] w-8 h-8 shrink-0">
                <span class="text-[#0F6E56] font-bold text-sm">GJ</span>
            </div>
            <span class="text-white font-bold text-xl tracking-tight">GuinéaJob</span>
        </div>
    </div>

    <!-- Navigation Links (Section 7.2 du CDC) -->
    <nav class="flex-grow py-6 px-4 space-y-2 overflow-y-auto">
        <p class="text-[#1D9E75] text-xs font-bold uppercase mb-4 px-2">Espace Administration</p>
        
        <a href="{{ route('admin.users.index') }}" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.users.*') ? 'bg-[#085041]' : 'hover:bg-[#085041]' }} transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="font-medium text-base">Utilisateurs</span>
        </a>

        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg {{ request()->routeIs('admin.dashboard') ? 'bg-[#085041]' : 'hover:bg-[#085041]' }} transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
            <span class="font-medium text-base">Entreprises</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium text-base">Contrats</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
            <span class="font-medium text-base">Recrutement</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"></path></svg>
            <span class="font-medium text-base">Appels d'offres</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
            <span class="font-medium text-base">Statistiques</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path></svg>
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="font-medium text-base">Paramètres</span>
        </a>
    </nav>

    <!-- Logout -->
    <div class="p-4 border-t border-[#085041]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-white rounded-lg hover:bg-[#993C1D] transition-colors text-left font-medium text-base">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span>Déconnexion</span>
            </button>
        </form>
    </div>
</div>
