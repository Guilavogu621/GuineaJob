<x-public-layout>
    <!-- Job Header Hero -->
    <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-20 overflow-hidden bg-white border-b border-slate-50">
        <div class="absolute top-0 right-0 -z-10 w-1/3 h-full bg-gradient-to-bl from-slate-50 to-white rounded-bl-[200px]"></div>
        
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-24 h-24 bg-white rounded-[2rem] border border-slate-100 flex items-center justify-center text-4xl font-black text-[#0F6E56] shadow-xl shadow-slate-200/50 shrink-0">
                        {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                    </div>
                    <div class="text-center md:text-left">
                        <h1 class="text-3xl lg:text-5xl font-black text-[#2C2C2A] font-outfit tracking-tight leading-tight mb-3">
                            {{ $offre->titre }}
                        </h1>
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-4">
                            <span class="text-xl font-bold text-[#0F6E56]">{{ $offre->entreprise->raison_sociale }}</span>
                            <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                            <div class="flex items-center gap-2 text-slate-400 font-bold text-sm uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $offre->lieu }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="w-full md:w-auto">
                    <a href="{{ route('jobboard.apply', $offre) }}" class="block w-full px-12 py-5 bg-[#0F6E56] text-white text-center font-black text-sm uppercase tracking-[0.2em] rounded-2xl shadow-2xl shadow-[#0F6E56]/30 hover:bg-[#0A5A45] hover:-translate-y-1 transition-all">
                        Postuler maintenant
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="py-16 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <a href="{{ route('jobboard.index') }}" class="inline-flex items-center gap-3 text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:text-[#0F6E56] transition-colors group">
                    <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-[#0F6E56] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </div>
                    Retour aux offres
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Colonne Principale -->
                <div class="lg:col-span-2 space-y-10">
                    <div class="bg-white rounded-[2.5rem] p-10 lg:p-12 shadow-sm border border-slate-100">
                        <div class="prose prose-slate max-w-none">
                            <div class="mb-12">
                                <h3 class="text-[15px] font-black text-slate-400 uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                                    Description du Poste
                                    <span class="flex-grow h-px bg-slate-50"></span>
                                </h3>
                                <div class="text-slate-600 text-lg leading-relaxed font-medium whitespace-pre-line">
                                    {{ $offre->description }}
                                </div>
                            </div>

                            @if($offre->competences_requises)
                            <div>
                                <h3 class="text-[15px] font-black text-[#0F6E56] uppercase tracking-[0.3em] mb-6 flex items-center gap-4">
                                    Compétences & Profil
                                    <span class="flex-grow h-px bg-[#E1F5EE]"></span>
                                </h3>
                                <div class="bg-[#E1F5EE]/30 p-8 rounded-[2rem] border border-[#E1F5EE] text-slate-700 font-bold leading-relaxed italic">
                                    {{ $offre->competences_requises }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne Latérale -->
                <div class="space-y-8">
                    <!-- Recap Card -->
                    <div class="bg-[#0F6E56] rounded-[2.5rem] p-10 text-white shadow-2xl relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/5 rounded-full group-hover:scale-150 transition-transform duration-700"></div>
                        
                        <h4 class="text-[15px] font-black text-white/40 uppercase tracking-[0.2em] mb-8">Détails de l'offre</h4>
                        
                        <div class="space-y-8">
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#0F6E56]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-white/30 uppercase tracking-widest leading-none mb-1">Contrat</p>
                                    <p class="text-base font-black font-outfit">{{ $offre->type_contrat }}</p>
                                </div>
                            </div>

                            @if($offre->salaire_range)
                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#BA7517]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-white/30 uppercase tracking-widest leading-none mb-1">Rémunération</p>
                                    <p class="text-base font-black font-outfit">{{ $offre->salaire_range }} <span class="text-[15px] text-white/40">GNF</span></p>
                                </div>
                            </div>
                            @endif

                            <div class="flex items-center gap-5">
                                <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-[#993C1D]">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-[9px] font-black text-white/30 uppercase tracking-widest leading-none mb-1">Date Limite</p>
                                    <p class="text-base font-black font-outfit">{{ $offre->date_expiration ? \Carbon\Carbon::parse($offre->date_expiration)->format('d M Y') : 'Non définie' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Company Info Card -->
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100 group">
                        <h4 class="text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] mb-8">L'Entreprise</h4>
                        <div class="flex items-center gap-4 mb-6">
                            <div class="w-12 h-12 bg-slate-50 rounded-xl flex items-center justify-center text-xl font-black text-[#0F6E56] group-hover:bg-[#0F6E56] group-hover:text-white transition-all">
                                {{ substr($offre->entreprise->raison_sociale, 0, 1) }}
                            </div>
                            <div>
                                <p class="text-lg font-black text-[#2C2C2A] font-outfit leading-none">{{ $offre->entreprise->raison_sociale }}</p>
                                <p class="text-[15px] text-[#0F6E56] font-black uppercase tracking-widest mt-1">{{ $offre->entreprise->secteur }}</p>
                            </div>
                        </div>
                        <p class="text-sm text-slate-500 leading-relaxed font-medium italic border-l-2 border-slate-100 pl-4 py-2">
                            {{ $offre->entreprise->description ?? 'Entreprise partenaire GuinéaJob engagée pour l\'excellence.' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
