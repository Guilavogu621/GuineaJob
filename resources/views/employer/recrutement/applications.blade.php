<x-app-layout>
    <div class="py-6">
        <div class="max-w-[1750px] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6 mb-12">
                <div>
                    <h2 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">
                        Candidatures : <span class="text-[#0F6E56]">{{ $offre->titre }}</span>
                    </h2>
                    <p class="text-slate-500 font-medium mt-1">{{ $candidatures->count() }} candidat(s) ont postulé à cette offre.</p>
                </div>
                <a href="{{ route('employer.recrutement.index') }}" class="px-6 py-3 bg-white text-slate-600 font-black text-[15px] uppercase tracking-widest rounded-2xl shadow-sm border border-slate-100 hover:bg-slate-50 hover:-translate-y-1 transition-all flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour aux offres
                </a>
            </div>

            <div class="space-y-8">
                @forelse($candidatures as $candidature)
                    <div class="bg-white/40 backdrop-blur-md rounded-[2.5rem] shadow-sm border border-white/50 p-8 lg:p-10 relative overflow-hidden group">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-slate-50 rounded-full scale-0 group-hover:scale-100 transition-transform duration-700 -z-10"></div>

                        <div class="flex flex-col lg:flex-row justify-between gap-10">
                            <!-- Infos Candidat -->
                            <div class="flex gap-6 min-w-0 flex-1">
                                <div class="w-16 h-16 bg-[#0F6E56]/5 rounded-2xl flex items-center justify-center text-[#0F6E56] font-black text-2xl font-outfit shadow-inner shrink-0">
                                    {{ substr($candidature->user->nom, 0, 1) }}
                                </div>
                                <div class="min-w-0">
                                    <h4 class="text-xl font-black text-[#2C2C2A] font-outfit leading-tight">{{ $candidature->user->full_name }}</h4>
                                    <p class="text-sm font-bold text-slate-500 mt-1">{{ $candidature->user->email }}</p>

                                    <div class="mt-6 flex flex-wrap gap-3">
                                        <a href="{{ asset('storage/' . $candidature->cv_path) }}" target="_blank" class="px-5 py-2 bg-white/60 text-slate-700 rounded-xl text-[15px] font-black uppercase tracking-widest hover:bg-[#0F6E56] hover:text-white transition-all flex items-center gap-2 border border-white/40 hover:border-[#0F6E56] hover:shadow-lg hover:shadow-[#0F6E56]/20">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                            Voir le CV
                                        </a>
                                        @if($candidature->lettre_motivation_path)
                                            <a href="{{ asset('storage/' . $candidature->lettre_motivation_path) }}" target="_blank" class="px-5 py-2 bg-white/60 text-slate-700 rounded-xl text-[15px] font-black uppercase tracking-widest hover:bg-[#0F6E56] hover:text-white transition-all flex items-center gap-2 border border-white/40 hover:border-[#0F6E56] hover:shadow-lg hover:shadow-[#0F6E56]/20">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                                Lettre de Motiv.
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Commentaire -->
                            <div class="flex-grow max-w-xl">
                                <label class="block text-[15px] font-black text-slate-500 uppercase tracking-widest mb-3">Message du candidat</label>
                                <div class="text-sm text-slate-700 italic bg-white/50 p-5 rounded-2xl border border-white/40 leading-relaxed">
                                    {{ $candidature->commentaire_candidat ?? 'Le candidat n\'a pas laissé de message particulier.' }}
                                </div>
                            </div>

                            <!-- Action Statut -->
                            <div class="w-full lg:w-72 pt-6 lg:pt-0 lg:pl-10 lg:border-l border-white/20">
                                <form action="{{ route('employer.recrutement.update-status', $candidature) }}" method="POST" class="space-y-4">
                                    @csrf @method('PATCH')
                                    <div>
                                        <label class="block text-[15px] font-black text-slate-500 uppercase tracking-widest mb-3">État du recrutement</label>
                                        <select name="statut" class="block w-full py-3.5 pl-4 pr-10 text-xs font-black uppercase tracking-widest border-none focus:ring-2 focus:ring-[#0F6E56]/20 rounded-2xl bg-white/50 border border-white/40 transition-all cursor-pointer text-slate-700">
                                            <option value="{{ \App\Models\Candidature::STATUS_PENDING }}" {{ $candidature->statut == \App\Models\Candidature::STATUS_PENDING ? 'selected' : '' }}>⌛ En attente</option>
                                            <option value="{{ \App\Models\Candidature::STATUS_RETAINED }}" {{ $candidature->statut == \App\Models\Candidature::STATUS_RETAINED ? 'selected' : '' }}>⭐ Retenu (Short-list)</option>
                                            <option value="{{ \App\Models\Candidature::STATUS_INTERVIEW }}" {{ $candidature->statut == \App\Models\Candidature::STATUS_INTERVIEW ? 'selected' : '' }}>📞 Entretien</option>
                                            <option value="{{ \App\Models\Candidature::STATUS_HIRED }}" {{ $candidature->statut == \App\Models\Candidature::STATUS_HIRED ? 'selected' : '' }}>🤝 Embauché</option>
                                            <option value="{{ \App\Models\Candidature::STATUS_REJECTED }}" {{ $candidature->statut == \App\Models\Candidature::STATUS_REJECTED ? 'selected' : '' }}>❌ Rejeté</option>
                                        </select>
                                    </div>
                                    <button type="submit" class="w-full py-4 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#0F6E56]/10 hover:bg-black hover:-translate-y-1 transition-all">
                                        Mettre à jour
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-32 bg-white rounded-[3rem] border-2 border-dashed border-slate-100">
                        <div class="w-20 h-20 bg-slate-50 text-slate-200 rounded-full flex items-center justify-center mx-auto mb-6">
                            <svg class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <p class="text-sm font-black text-slate-400 uppercase tracking-[0.2em]">Aucune candidature pour le moment</p>
                        <p class="text-slate-400 font-medium mt-2 text-sm">Les candidatures s'afficheront ici dès qu'un talent aura postulé.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
