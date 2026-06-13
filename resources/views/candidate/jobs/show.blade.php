<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        
        <div class="mb-6">
            <a href="{{ route('candidate.jobs.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0F6E56] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour aux offres
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                
                {{-- Header Card --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100 relative overflow-hidden">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <div class="w-20 h-20 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-center text-3xl font-black text-[#0F6E56] shadow-sm shrink-0">
                            {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                        </div>
                        <div class="flex-1">
                            <h1 class="text-2xl font-bold text-gray-900 mb-2">
                                {{ $offre->titre }}
                            </h1>
                            <div class="flex flex-wrap items-center gap-4 text-sm font-medium text-gray-500">
                                <span class="text-[#0F6E56] font-bold">{{ $offre->entreprise->raison_sociale }}</span>
                                <span class="w-1.5 h-1.5 rounded-full bg-gray-300"></span>
                                <div class="flex items-center gap-1.5">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                    {{ $offre->lieu }}
                                </div>
                            </div>
                        </div>
                        
                        <div class="shrink-0 w-full md:w-auto mt-4 md:mt-0">
                            @if($candidatureExistante)
                                <div class="px-6 py-3 bg-[#E1F5EE] text-[#0F6E56] font-bold text-sm rounded-xl text-center border border-[#0F6E56]/20">
                                    ✓ Candidature envoyée
                                </div>
                            @else
                                <a href="{{ route('candidate.jobs.apply', $offre) }}" class="block w-full md:w-auto px-8 py-3 bg-[#0F6E56] text-white text-center font-bold text-sm rounded-xl shadow-lg shadow-[#0F6E56]/20 hover:bg-[#0A5A45] hover:-translate-y-0.5 transition-all">
                                    Postuler
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- Description Card --}}
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-gray-100">
                    <h3 class="text-[15px] font-bold text-gray-900 uppercase tracking-wider mb-6 flex items-center gap-3">
                        Description du Poste
                        <div class="flex-1 h-px bg-gray-100"></div>
                    </h3>
                    <div class="text-gray-600 text-[15px] leading-relaxed whitespace-pre-line">
                        {{ $offre->description }}
                    </div>

                    @if($offre->competences_requises)
                        <h3 class="text-[15px] font-bold text-gray-900 uppercase tracking-wider mt-10 mb-6 flex items-center gap-3">
                            Compétences & Profil
                            <div class="flex-1 h-px bg-gray-100"></div>
                        </h3>
                        <div class="bg-[#F1EFE8]/50 p-6 rounded-xl border border-gray-100 text-gray-700 leading-relaxed italic">
                            {{ $offre->competences_requises }}
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Info Card -->
                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                    <h4 class="text-[13px] font-bold text-gray-400 uppercase tracking-wider mb-6">Détails de l'offre</h4>
                    
                    <div class="space-y-5">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#F1EFE8] rounded-xl flex items-center justify-center text-[#2C2C2A]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Contrat</p>
                                <p class="text-sm font-bold text-gray-900">{{ $offre->type_contrat }}</p>
                            </div>
                        </div>

                        @if($offre->salaire_range)
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#E1F5EE] rounded-xl flex items-center justify-center text-[#0F6E56]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Rémunération</p>
                                <p class="text-sm font-bold text-gray-900">{{ $offre->salaire_range }} <span class="text-xs text-gray-500 font-medium">GNF</span></p>
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 bg-[#FCEBEB] rounded-xl flex items-center justify-center text-[#993C1D]">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider mb-0.5">Date Limite</p>
                                <p class="text-sm font-bold text-gray-900">{{ $offre->date_expiration ? \Carbon\Carbon::parse($offre->date_expiration)->format('d M Y') : 'Non définie' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Company Card -->
                <div class="bg-gray-50 rounded-2xl p-6 border border-gray-100">
                    <h4 class="text-[13px] font-bold text-gray-400 uppercase tracking-wider mb-4">L'Entreprise</h4>
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-lg font-bold text-[#0F6E56] shadow-sm">
                            {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                        </div>
                        <div>
                            <p class="text-[15px] font-bold text-gray-900 leading-tight">{{ $offre->entreprise->raison_sociale }}</p>
                            <p class="text-xs text-[#0F6E56] font-semibold mt-0.5">{{ $offre->entreprise->secteur }}</p>
                        </div>
                    </div>
                    <p class="text-[13px] text-gray-500 leading-relaxed">
                        {{ $offre->entreprise->description ?? 'Entreprise partenaire GuinéaJob.' }}
                    </p>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
