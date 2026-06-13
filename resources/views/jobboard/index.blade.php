<x-public-layout>
    <!-- Hero Section Premium pour Emplois -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-24 overflow-hidden bg-white border-b border-slate-50">
        <!-- Décorations d'arrière-plan cohérentes avec welcome -->
        <div class="absolute top-0 right-0 -z-10 w-1/3 h-full bg-gradient-to-bl from-[#F1EFE8] to-white rounded-bl-[200px]"></div>
        <div class="absolute -top-10 -right-10 w-64 h-64 bg-[#0F6E56] rounded-full blur-[90px] opacity-10 -z-10"></div>
        
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#0F6E56]/10 text-[#0F6E56] text-[15px] font-black uppercase tracking-[0.2em] rounded-full mb-6 border border-[#0F6E56]/20">
                    <span class="w-2 h-2 rounded-full bg-[#0F6E56] animate-pulse"></span>
                    Portail Carrière National 🇬🇳
                </span>
                <h1 class="text-4xl lg:text-6xl font-black text-[#2C2C2A] leading-[1.1] tracking-tight mb-6">
                    Trouvez votre futur <span class="text-[#0F6E56]">Emploi</span>
                </h1>
                <p class="text-xl text-gray-500 font-medium leading-relaxed max-w-2xl">
                    Explorez les meilleures opportunités professionnelles en Guinée. Des centaines d'offres qualifiées vous attendent.
                </p>
            </div>
        </div>
    </section>

    <div class="py-16 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Barre de Recherche Premium (Style SaaS) -->
            <!-- Barre de Recherche Premium (Style SaaS) -->
            <div class="-mt-28 relative z-20 mb-20">
                <form action="{{ route('jobboard.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-4 bg-white p-3 rounded-[2rem] shadow-[0_20px_50px_rgba(11,23,54,0.1)] border border-slate-100 backdrop-blur-sm">
                    
                    <!-- Search Input -->
                    <div class="relative w-full lg:w-[400px] group">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400 group-focus-within:text-[#0F6E56] transition-colors">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Métier, titre ou mot-clé..." 
                            class="block w-full pl-11 pr-4 py-3.5 bg-slate-50/50 border-none rounded-xl text-sm font-bold text-[#2C2C2A] placeholder:text-slate-400 focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300">
                        <button type="submit" class="hidden"></button>
                    </div>

                    <!-- Right Side Toolbar -->
                    <div class="flex items-center gap-3 overflow-x-auto pb-2 lg:pb-0 hide-scrollbar shrink-0 px-2 lg:px-0">
                        
                        <!-- View Toggles -->
                        <div class="flex items-center bg-slate-50 border border-slate-100 rounded-xl p-1 gap-1 shadow-sm hidden sm:flex shrink-0">
                            <button type="button" class="p-2 bg-white text-slate-700 shadow-sm rounded-lg"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M4 3a2 2 0 100 4h12a2 2 0 100-4H4zM4 9a2 2 0 100 4h12a2 2 0 100-4H4zM4 15a2 2 0 100 4h12a2 2 0 100-4H4z"></path></svg></button>
                            <button type="button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg></button>
                            <button type="button" class="p-2 text-slate-400 hover:text-slate-600 hover:bg-slate-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M12 1.586l-4 4v12.828l4-4V1.586zM3.707 3.293A1 1 0 002 4v10a1 1 0 00.293.707L6 18.414V5.586L3.707 3.293zM17.707 5.293L14 1.586v12.828l2.293 2.293A1 1 0 0018 16V6a1 1 0 00-.293-.707z" clip-rule="evenodd"></path></svg></button>
                        </div>

                        <!-- Sort Button -->
                        <div class="relative group shrink-0">
                            <select name="sort" onchange="this.form.submit()" class="appearance-none block w-full pl-9 pr-8 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 focus:ring-2 focus:ring-[#0F6E56]/20 transition-all cursor-pointer shadow-sm">
                                <option value="">Trier: Récents</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12"></path></svg>
                            </div>
                        </div>

                        <!-- Filter Button -->
                        <div class="relative group shrink-0">
                            <select name="type" onchange="this.form.submit()" class="appearance-none block w-full pl-9 pr-8 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 focus:ring-2 focus:ring-[#0F6E56]/20 transition-all cursor-pointer shadow-sm">
                                <option value="">Tous les contrats</option>
                                <option value="CDI" {{ request('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                                <option value="CDD" {{ request('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="Stage" {{ request('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                                <option value="Prestation" {{ request('type') == 'Prestation' ? 'selected' : '' }}>Prestation</option>
                            </select>
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                            </div>
                        </div>

                        <!-- Bouton Exporter -->
                        <button type="button" class="flex items-center gap-2 px-4 py-3 bg-slate-50 border border-slate-100 rounded-xl text-sm font-bold text-slate-600 hover:bg-slate-100 transition-colors shadow-sm whitespace-nowrap shrink-0">
                            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                            Exporter
                        </button>

                        @if(request()->anyFilled(['search', 'type']))
                            <a href="{{ route('jobboard.index') }}" class="p-3 bg-[#FCEBEB] text-[#993C1D] hover:bg-[#FCEBEB] border border-[#FCEBEB] rounded-xl transition-all shadow-sm shrink-0" title="Réinitialiser">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            <!-- Grille des Offres -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($offres as $offre)
                    <div class="group bg-white rounded-[2.5rem] border border-slate-100 p-8 shadow-sm hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 flex flex-col h-full relative overflow-hidden">
                        <!-- Effet de hover décoratif -->
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-[#0F6E56]/5 rounded-full scale-0 group-hover:scale-100 transition-transform duration-700"></div>
                        
                        <div class="flex justify-between items-start mb-8 relative z-10">
                            <div class="w-14 h-14 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center text-2xl font-black text-[#0F6E56] shadow-sm group-hover:bg-[#0F6E56] group-hover:text-white transition-colors duration-300">
                                {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                            </div>
                            <span class="px-4 py-1.5 bg-[#0F6E56]/5 text-[#0F6E56] text-[15px] font-black uppercase tracking-[0.15em] rounded-xl border border-[#0F6E56]/10">
                                {{ $offre->type_contrat }}
                            </span>
                        </div>
                        
                        <div class="flex-grow relative z-10">
                            <h3 class="text-2xl font-black text-[#2C2C2A] font-outfit leading-tight mb-2 group-hover:text-[#0F6E56] transition-colors line-clamp-2">
                                {{ $offre->titre }}
                            </h3>
                            <p class="text-sm font-bold text-slate-500 mb-6 flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-slate-300"></span>
                                {{ $offre->entreprise->raison_sociale }}
                            </p>
                            
                            <div class="flex flex-wrap gap-4 mb-8">
                                <div class="flex items-center gap-2 px-3 py-1.5 bg-slate-50 rounded-lg text-xs font-black text-slate-600 uppercase tracking-tighter">
                                    <svg class="w-3.5 h-3.5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $offre->lieu }}
                                </div>
                                @if($offre->salaire_range)
                                    <div class="flex items-center gap-2 px-3 py-1.5 bg-[#E1F5EE] rounded-lg text-xs font-black text-[#0F6E56] uppercase tracking-tighter">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $offre->salaire_range }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="pt-6 border-t border-slate-50 flex items-center justify-between mt-auto relative z-10">
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-[0.2em]">Posté {{ $offre->created_at->diffForHumans() }}</span>
                            <a href="{{ route('jobboard.show', $offre) }}" class="inline-flex items-center gap-2 text-[15px] font-black text-[#0F6E56] uppercase tracking-[0.2em] group/btn">
                                Détails
                                <div class="w-8 h-8 bg-[#0F6E56]/10 text-[#0F6E56] rounded-full flex items-center justify-center group-hover/btn:translate-x-1 transition-all">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-32 flex flex-col items-center justify-center text-center bg-white rounded-[3rem] border-2 border-dashed border-slate-100 shadow-inner">
                        <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center text-slate-200 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <p class="text-slate-400 font-black uppercase tracking-[0.2em] text-sm">Aucune offre trouvée</p>
                        <p class="text-slate-400 font-medium mt-2">Essayez d'autres mots-clés ou filtres.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination Premium -->
            @if($offres->hasPages())
                <div class="mt-20 flex justify-center">
                    {{ $offres->links() }}
                </div>
            @endif
        </div>
    </div>
</x-public-layout>
