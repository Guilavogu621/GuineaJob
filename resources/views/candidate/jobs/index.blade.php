<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        
        {{-- Header Area --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Offres d'emploi</h1>
                <p class="text-[15px] text-gray-500 mt-2">
                    Découvrez les offres actives et postulez directement depuis votre espace.
                </p>
            </div>
            
            {{-- Search & Filters --}}
            <div class="mt-4 md:mt-0 w-full md:w-auto">
                <form action="{{ route('candidate.jobs.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}" 
                            placeholder="Titre, mots-clés..." 
                            class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:ring-[#0F6E56] focus:border-[#0F6E56] sm:text-sm transition-colors">
                    </div>
                    
                    <select name="type" class="block w-full sm:w-40 py-2 pl-3 pr-10 border border-gray-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-[#0F6E56] focus:border-[#0F6E56] sm:text-sm">
                        <option value="">Tous les types</option>
                        <option value="CDI" {{ request('type') == 'CDI' ? 'selected' : '' }}>CDI</option>
                        <option value="CDD" {{ request('type') == 'CDD' ? 'selected' : '' }}>CDD</option>
                        <option value="Stage" {{ request('type') == 'Stage' ? 'selected' : '' }}>Stage</option>
                        <option value="Prestation" {{ request('type') == 'Prestation' ? 'selected' : '' }}>Prestation</option>
                    </select>
                    
                    <button type="submit" class="inline-flex justify-center items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-lg text-white bg-[#0F6E56] hover:bg-[#0A5A45] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#0F6E56] transition-colors">
                        Rechercher
                    </button>
                    
                    @if(request()->anyFilled(['search', 'type']))
                        <a href="{{ route('candidate.jobs.index') }}" class="inline-flex justify-center items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 transition-colors">
                            Réinitialiser
                        </a>
                    @endif
                </form>
            </div>
        </div>

        {{-- Grille des offres --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($offres as $offre)
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col hover:border-[#0F6E56]/30 transition-colors duration-300 group relative">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center gap-3">
                            <div class="w-12 h-12 rounded-xl bg-[#E1F5EE] text-[#0F6E56] flex items-center justify-center font-bold text-lg">
                                {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                            </div>
                            <div>
                                <h3 class="text-[#2C2C2A] font-bold text-[15px]">{{ $offre->entreprise->raison_sociale }}</h3>
                                <p class="text-[#888780] text-xs font-medium">{{ $offre->lieu }}</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 bg-[#F1EFE8] text-[#2C2C2A] text-xs font-semibold rounded-md border border-[#D3D1C7]/50">
                            {{ $offre->type_contrat }}
                        </span>
                    </div>

                    <h4 class="text-lg font-semibold text-gray-900 mb-2 leading-tight group-hover:text-[#0F6E56] transition-colors">
                        {{ $offre->titre }}
                    </h4>

                    @if($offre->salaire_range)
                        <div class="flex items-center gap-1.5 text-sm font-medium text-[#0F6E56] mb-4 bg-[#E1F5EE]/50 w-max px-2 py-1 rounded-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            {{ $offre->salaire_range }}
                        </div>
                    @else
                        <div class="mb-4"></div> <!-- Espacement si pas de salaire -->
                    @endif

                    <div class="mt-auto flex items-center justify-between pt-4 border-t border-gray-100">
                        <span class="text-xs text-[#888780] font-medium">Posté {{ $offre->created_at->diffForHumans() }}</span>
                        
                        <div class="flex gap-2">
                            <a href="{{ route('candidate.jobs.show', $offre) }}" class="text-sm font-semibold text-[#0F6E56] hover:text-[#0A5A45] hover:underline transition-all">
                                Voir détails &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full py-16 flex flex-col items-center justify-center text-center bg-white rounded-2xl border border-dashed border-gray-300">
                    <svg class="w-12 h-12 text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <h3 class="text-lg font-medium text-gray-900 mb-1">Aucune offre trouvée</h3>
                    <p class="text-sm text-gray-500">Essayez d'ajuster vos critères de recherche.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($offres->hasPages())
            <div class="mt-8">
                {{ $offres->links() }}
            </div>
        @endif
        
    </div>
</x-app-layout>
