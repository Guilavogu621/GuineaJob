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

    <!-- Navigation Links -->
    <nav class="flex-grow py-6 px-4 space-y-2 overflow-y-auto">
        <p class="text-[#1D9E75] text-xs font-bold uppercase mb-2 px-2">Mon Espace Travail</p>
        
        <a href="{{ route('employee.dashboard') }}" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg {{ request()->routeIs('employee.dashboard') ? 'bg-[#085041]' : 'hover:bg-[#085041]' }} transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
            <span class="font-medium text-base">Tableau de bord</span>
        </a>

        <a href="{{ route('employee.contract.show') }}" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg {{ request()->routeIs('employee.contract.show') ? 'bg-[#085041]' : 'hover:bg-[#085041]' }} transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
            <span class="font-medium text-base">Mon Contrat</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            <span class="font-medium text-base">Mes Bulletins</span>
        </a>

        <a href="#" class="flex items-center gap-3 px-4 py-3 text-white rounded-lg hover:bg-[#085041] transition-colors">
            <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="font-medium text-base">Mes Congés</span>
        </a>
    </nav>

    <!-- Logout Space -->
    <div class="p-4 border-t border-[#085041]">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="flex items-center gap-3 w-full px-4 py-3 text-white rounded-lg hover:bg-[#993C1D] transition-colors text-left">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                <span class="font-medium text-base">Déconnexion</span>
            </button>
        </form>
    </div>
</div>
