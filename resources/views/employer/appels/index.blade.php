<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">Gestion des Marchés B2B</h1>
                <p class="text-slate-500 font-medium mt-1">Suivez vos appels d'offres et les propositions des prestataires.</p>
            </div>
            <div class="flex items-center gap-3">
                <a href="{{ route('employer.appels.create') }}" class="inline-flex items-center px-6 py-3.5 bg-[#0F6E56] text-white rounded-2xl font-black text-[15px] uppercase tracking-widest hover:bg-[#0A5A45] hover:-translate-y-0.5 transition-all shadow-lg shadow-[#0F6E56]/20">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    Publier un marché
                </a>
            </div>
        </div>

        @if(session('success'))
            <div class="p-4 bg-[#E1F5EE] border border-[#E1F5EE] text-[#0F6E56] rounded-2xl flex items-center gap-3 animate-fade-in-up shadow-sm">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-sm font-bold">{{ session('success') }}</span>
            </div>
        @endif

        <div class="bg-white/35 border border-white/40 backdrop-blur-md rounded-[2.5rem] shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead class="bg-white/20">
                        <tr>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Marché</th>
                            <th class="px-6 py-5 text-center text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Propositions</th>
                            <th class="px-6 py-5 text-center text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Échéance</th>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Statut</th>
                            <th class="px-6 py-5 text-right text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/20">
                        @forelse($appels as $appel)
                            <tr class="hover:bg-white/40 transition-colors duration-200 group">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-[15px] font-black text-[#2C2C2A] font-outfit group-hover:text-[#0F6E56] transition-colors">{{ $appel->titre }}</div>
                                    <div class="text-[15px] font-bold text-slate-500 uppercase tracking-widest mt-1">{{ $appel->secteur_activite }}</div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-center">
                                    <span class="inline-flex items-center justify-center w-10 h-10 bg-[#0F6E56]/10 text-[#0F6E56] rounded-xl text-sm font-black border border-[#0F6E56]/10">
                                        {{ $appel->propositions_count }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-center">
                                    <div class="text-[15px] font-bold {{ $appel->date_limite->isPast() ? 'text-[#993C1D] font-black' : 'text-slate-500' }}">
                                        {{ $appel->date_limite->format('d/m/Y') }}
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @php
                                        $statusClass = match($appel->statut) {
                                            \App\Models\AppelOffre::STATUS_PUBLISHED => 'badge-active',
                                            \App\Models\AppelOffre::STATUS_CLOSED => 'badge-warning',
                                            \App\Models\AppelOffre::STATUS_AWARDED => 'badge-info',
                                            \App\Models\AppelOffre::STATUS_CANCELLED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $statusLabel = match($appel->statut) {
                                            \App\Models\AppelOffre::STATUS_PUBLISHED => 'Publié',
                                            \App\Models\AppelOffre::STATUS_CLOSED => 'Clôturé',
                                            \App\Models\AppelOffre::STATUS_AWARDED => 'Attribué',
                                            \App\Models\AppelOffre::STATUS_CANCELLED => 'Annulé',
                                            default => ucfirst(str_replace('_', ' ', $appel->statut)),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusClass }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-right">
                                    <a href="{{ route('employer.appels.propositions', $appel) }}" class="inline-flex items-center gap-2 text-[#0F6E56] hover:text-[#0A5A45] font-black text-[15px] uppercase tracking-widest transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01m-.01 4h.01"></path></svg>
                                        Voir propositions
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-2xl flex items-center justify-center mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-slate-400 font-black uppercase tracking-widest text-xs">Aucun marché publié</p>
                                        <p class="text-slate-400 text-sm mt-1">Commencez par publier votre premier appel d'offre B2B.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
