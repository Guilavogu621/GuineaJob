<x-app-layout>
    <div class="py-12 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-[1750px] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h2 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">
                        Réponses : <span class="text-[#0F6E56]">{{ $appel->titre }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium mt-1">{{ $propositions->count() }} proposition(s) reçue(s) pour ce marché.</p>
                </div>
                <a href="{{ route('employer.appels.index') }}" class="px-6 py-3 bg-white text-slate-600 font-black text-[15px] uppercase tracking-widest rounded-2xl shadow-sm border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour
                </a>
            </div>

            <div class="grid grid-cols-1 gap-8">
                @forelse($propositions as $proposition)
                    <div class="bg-white rounded-[2.5rem] p-8 lg:p-10 shadow-sm border border-slate-100 relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-slate-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-700 -z-10"></div>

                        <div class="flex flex-col lg:flex-row justify-between gap-10">
                            <div class="flex-grow min-w-0">
                                <div class="flex items-center gap-6 mb-6">
                                    <div class="w-16 h-16 bg-[#0F6E56]/5 text-[#0F6E56] rounded-2xl flex items-center justify-center font-black text-2xl font-outfit shadow-inner shrink-0">
                                        {{ substr($proposition->prestataire->raison_sociale, 0, 1) }}
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xl font-black text-[#2C2C2A] font-outfit leading-tight">{{ $proposition->prestataire->raison_sociale }}</h4>
                                        <p class="text-[15px] text-slate-400 uppercase font-black tracking-[0.15em] mt-1">{{ $proposition->prestataire->secteur }}</p>
                                    </div>
                                </div>
                                <div class="bg-slate-50 p-6 lg:p-8 rounded-[2rem] border border-slate-100 relative">
                                    <div class="absolute -top-3 left-8 px-4 py-1 bg-white border border-slate-100 rounded-full text-[9px] font-black uppercase tracking-widest text-slate-400">Message d'accompagnement</div>
                                    <p class="text-sm text-slate-600 italic leading-relaxed font-medium">"{{ $proposition->message_accompagnement ?? 'Aucun message particulier n\'a été joint à cette proposition.' }}"</p>
                                </div>
                            </div>

                            <div class="lg:w-80 flex flex-col justify-between pt-8 lg:pt-0 lg:pl-10 lg:border-l border-slate-50">
                                <div class="space-y-6">
                                    <div class="bg-[#0F6E56]/5 p-5 rounded-2xl border border-[#0F6E56]/10">
                                        <div class="text-[9px] font-black text-[#0F6E56] uppercase tracking-widest mb-1">Offre Financière</div>
                                        <div class="text-2xl font-black text-[#2C2C2A] font-outfit">{{ number_format($proposition->montant_propose, 0, ',', ' ') }} <span class="text-xs">GNF</span></div>
                                    </div>
                                    <div class="px-5">
                                        <div class="text-[9px] font-black text-slate-400 uppercase tracking-widest mb-1">Délai proposé</div>
                                        <div class="text-base font-black text-[#2C2C2A]">{{ $proposition->delai_execution }}</div>
                                    </div>
                                </div>

                                <div class="mt-10 space-y-4">
                                    <a href="{{ asset('storage/' . $proposition->document_proposition) }}" target="_blank" class="flex items-center justify-center gap-3 w-full py-4 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#0F6E56]/10 hover:bg-black hover:-translate-y-1 transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        Télécharger l'offre
                                    </a>
                                    @php
                                        $proposalStatusClass = match($proposition->statut) {
                                            \App\Models\PropositionOffre::STATUS_PENDING => 'badge-pending',
                                            \App\Models\PropositionOffre::STATUS_UNDER_REVIEW => 'badge-info',
                                            \App\Models\PropositionOffre::STATUS_ACCEPTED => 'badge-active',
                                            \App\Models\PropositionOffre::STATUS_REJECTED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $proposalStatusLabel = match($proposition->statut) {
                                            \App\Models\PropositionOffre::STATUS_PENDING => 'En attente',
                                            \App\Models\PropositionOffre::STATUS_UNDER_REVIEW => 'En examen',
                                            \App\Models\PropositionOffre::STATUS_ACCEPTED => 'Retenue',
                                            \App\Models\PropositionOffre::STATUS_REJECTED => 'Rejetée',
                                            default => ucfirst(str_replace('_', ' ', $proposition->statut)),
                                        };
                                    @endphp
                                    <div class="flex items-center justify-center">
                                        <span class="badge {{ $proposalStatusClass }}">
                                            {{ $proposalStatusLabel }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-32 bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1l1 1h5l1-1h1m-1 4h.01M9 16h.01M13 16h.01M17 16h.01M9 12h.01M13 12h.01M17 12h.01"></path></svg>
                        </div>
                        <p class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Aucune proposition pour le moment</p>
                        <p class="text-slate-400 font-medium mt-2 text-sm">Les offres des prestataires s'afficheront ici au fur et à mesure.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
