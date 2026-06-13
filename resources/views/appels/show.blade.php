<x-public-layout>
    <!-- Tender Header Hero -->
    <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-20 overflow-hidden bg-white border-b border-slate-50">
        <div class="absolute top-0 right-0 -z-10 w-1/3 h-full bg-gradient-to-bl from-[#E1F5EE]/50 to-white rounded-bl-[200px]"></div>

        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-8">
                <div class="flex flex-col md:flex-row items-center gap-8">
                    <div class="w-24 h-24 bg-white rounded-[2rem] border border-slate-100 flex items-center justify-center text-4xl font-black text-[#0F6E56] shadow-xl shadow-[#E1F5EE]/60 shrink-0">
                        {{ substr($appel->entreprise->raison_sociale, 0, 1) }}
                    </div>
                    <div class="text-center md:text-left">
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-3 mb-3">
                            <span class="px-3 py-1 bg-[#0F6E56]/10 text-[#0F6E56] text-[9px] font-black uppercase tracking-[0.2em] rounded-lg border border-[#0F6E56]/10">
                                {{ $appel->secteur_activite }}
                            </span>
                            <span class="text-[9px] font-black text-slate-400 uppercase tracking-widest">
                                Réf: AO-{{ str_pad($appel->id, 5, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>
                        <h1 class="text-3xl lg:text-5xl font-black text-[#2C2C2A] font-outfit tracking-tight leading-tight mb-4">
                            {{ $appel->titre }}
                        </h1>
                        <div class="flex flex-wrap justify-center md:justify-start items-center gap-4">
                            <span class="text-xl font-bold text-[#2C2C2A]/70">{{ $appel->entreprise->raison_sociale }}</span>
                            <div class="h-4 w-px bg-slate-200 hidden sm:block"></div>
                            <div class="flex items-center gap-2 text-slate-400 font-bold text-sm uppercase tracking-widest">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                {{ $appel->lieu_execution ?? 'République de Guinée' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="w-full md:w-auto">
                    @php
                        $appelStatusBadge = match($appel->statut) {
                            \App\Models\AppelOffre::STATUS_PUBLISHED => 'badge-active',
                            \App\Models\AppelOffre::STATUS_CLOSED => 'badge-warning',
                            \App\Models\AppelOffre::STATUS_AWARDED => 'badge-info',
                            \App\Models\AppelOffre::STATUS_CANCELLED => 'badge-rejected',
                            default => 'badge-gray',
                        };
                        $appelStatusLabel = match($appel->statut) {
                            \App\Models\AppelOffre::STATUS_PUBLISHED => 'Publié',
                            \App\Models\AppelOffre::STATUS_CLOSED => 'Clôturé',
                            \App\Models\AppelOffre::STATUS_AWARDED => 'Attribué',
                            \App\Models\AppelOffre::STATUS_CANCELLED => 'Annulé',
                            default => ucfirst(str_replace('_', ' ', $appel->statut)),
                        };
                    @endphp
                    <span class="badge {{ $appelStatusBadge }}">
                        {{ $appelStatusLabel }}
                    </span>
                </div>
            </div>
        </div>
    </section>

    <div class="py-16 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-10 flex justify-between items-center">
                <a href="{{ route('appels.public.index') }}" class="inline-flex items-center gap-3 text-xs font-black text-slate-400 uppercase tracking-[0.2em] hover:text-[#0F6E56] transition-colors group">
                    <div class="w-8 h-8 rounded-full border border-slate-200 flex items-center justify-center group-hover:border-[#0F6E56] transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M15 19l-7-7 7-7"></path></svg>
                    </div>
                    Retour aux marchés
                </a>
            </div>

            @if(session('success'))
                <div class="mb-10 p-6 bg-[#E1F5EE] text-[#0F6E56] font-black text-sm rounded-3xl border border-[#E1F5EE] flex items-center gap-4 shadow-sm animate-bounce">
                    <svg class="w-6 h-6 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
                <!-- Colonne Principale -->
                <div class="lg:col-span-2 space-y-10">
                    <div class="bg-white rounded-[2.5rem] p-10 lg:p-14 shadow-sm border border-slate-100 relative overflow-hidden">
                        <div class="prose prose-slate max-w-none">
                            <div class="mb-12">
                                <h3 class="text-[15px] font-black text-slate-400 uppercase tracking-[0.3em] mb-8 flex items-center gap-4">
                                    Objet de l'appel d'offre
                                    <span class="flex-grow h-px bg-slate-50"></span>
                                </h3>
                                <div class="text-slate-600 text-lg leading-relaxed font-medium whitespace-pre-line">
                                    {{ $appel->description }}
                                </div>
                            </div>

                            @if($appel->document_cctp)
                                <div class="mt-12 p-8 bg-slate-50 rounded-[2rem] border border-slate-100 flex flex-col sm:flex-row items-center justify-between gap-6">
                                    <div class="flex items-center gap-5">
                                        <div class="w-14 h-14 bg-white rounded-2xl shadow-sm flex items-center justify-center text-[#0F6E56] border border-slate-100">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <div>
                                            <p class="text-xs font-black text-[#2C2C2A] uppercase tracking-widest mb-1">Cahier des Charges (CCTP)</p>
                                            <p class="text-[15px] text-slate-400 font-bold uppercase tracking-widest">Format PDF / DOCX Certifié</p>
                                        </div>
                                    </div>
                                    <a href="{{ asset('storage/' . $appel->document_cctp) }}" target="_blank" class="w-full sm:w-auto px-8 py-4 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-xl hover:bg-black transition-all shadow-lg shadow-slate-200 text-center">
                                        Télécharger le dossier
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Colonne Latérale : Formulaire & Stats -->
                <div class="space-y-8">
                    <!-- Proposition Card -->
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-2xl shadow-slate-200 border border-slate-100">
                        <h4 class="text-xl font-black text-[#2C2C2A] font-outfit mb-8">Soumission</h4>

                        @auth
                            @if(Auth::user()->isPrestataire() && Auth::user()->entreprise && Auth::user()->entreprise->id !== $appel->entreprise_id)
                                <form action="{{ route('appels.proposer', $appel) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                                    @csrf
                                    <div>
                                        <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Montant GNF (TTC)</label>
                                        <div class="relative">
                                            <input type="number" name="montant_propose" required
                                                class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-base font-black text-[#2C2C2A] focus:ring-2 focus:ring-[#0F6E56]/20 transition-all">
                                            <span class="absolute right-5 top-1/2 -translate-y-1/2 text-xs font-black text-slate-400">GNF</span>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Délai d'exécution</label>
                                        <input type="text" name="delai_execution" required placeholder="Ex: 45 jours calendaires"
                                            class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-sm font-bold text-[#2C2C2A] focus:ring-2 focus:ring-[#0F6E56]/20 transition-all">
                                    </div>
                                    <div>
                                        <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] mb-3 ml-1">Offre Technique & Financière</label>
                                        <div class="relative group">
                                            <input type="file" name="document_proposition" required
                                                class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                            <div class="flex items-center gap-3 px-5 py-4 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl group-hover:border-[#0F6E56] transition-all">
                                                <svg class="w-5 h-5 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                <span class="text-xs font-black text-slate-400 uppercase tracking-widest truncate">Joindre mon offre</span>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="submit" class="w-full py-5 bg-[#0F6E56] text-white font-black text-[15px] uppercase tracking-[0.2em] rounded-2xl shadow-xl shadow-[#0F6E56]/20 hover:bg-[#0A5A45] hover:-translate-y-1 transition-all active:translate-y-0">
                                        Envoyer ma proposition
                                    </button>
                                </form>
                            @elseif(Auth::user()->entreprise && Auth::user()->entreprise->id === $appel->entreprise_id)
                                <div class="p-8 bg-slate-50 rounded-3xl text-center border border-slate-100">
                                    <div class="w-12 h-12 bg-white rounded-2xl shadow-sm flex items-center justify-center text-[#0F6E56] mx-auto mb-4">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                    </div>
                                    <p class="text-sm font-bold text-[#2C2C2A] mb-4">C'est votre appel d'offre.</p>
                                    <a href="{{ route('employer.appels.propositions', $appel) }}" class="inline-flex items-center gap-2 text-[15px] font-black text-[#0F6E56] uppercase tracking-[0.2em] hover:translate-x-1 transition-transform">
                                        Voir les réponses
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            @else
                                <div class="p-8 bg-[#FAEEDA] rounded-3xl border border-[#FAEEDA] text-center">
                                    <p class="text-xs font-bold text-[#633806] leading-relaxed uppercase tracking-wider">Accès Prestataire Uniquement</p>
                                    <p class="text-[15px] text-[#633806]/70 mt-2 font-medium">Seuls les comptes prestataires peuvent répondre aux marchés B2B.</p>
                                </div>
                            @endif
                        @else
                            <div class="text-center p-8 bg-slate-50 rounded-3xl border border-slate-100">
                                <p class="text-xs font-bold text-slate-500 mb-6 leading-relaxed">Connectez-vous avec votre compte Prestataire pour soumettre une proposition.</p>
                                <a href="{{ route('login') }}" class="inline-block w-full py-4 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-[0.2em] rounded-2xl hover:bg-[#0A5A45] transition-all">Connexion</a>
                            </div>
                        @endauth
                    </div>

                    <!-- Side Stats -->
                    <div class="bg-white rounded-[2.5rem] p-10 shadow-sm border border-slate-100">
                        <div class="space-y-6">
                            <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                                <span class="text-[15px] font-black text-slate-400 uppercase tracking-widest">Clôture</span>
                                <span class="text-sm font-black text-[#993C1D] font-outfit">{{ $appel->date_limite->format('d/m/Y') }}</span>
                            </div>
                            <div class="flex items-center justify-between border-b border-slate-50 pb-4">
                                <span class="text-[15px] font-black text-slate-400 uppercase tracking-widest">Consultations</span>
                                <span class="text-sm font-black text-[#2C2C2A] font-outfit">{{ $appel->vues }} vues</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-[15px] font-black text-slate-400 uppercase tracking-widest">Éligibilité</span>
                                <span class="text-[15px] font-black text-[#0F6E56] uppercase tracking-widest">Vérifiée GJ</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-public-layout>
