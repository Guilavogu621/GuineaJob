<x-app-layout>
    <div class="space-y-10">
        <!-- Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
            <div>
                <h1 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">Supervision des Contrats</h1>
                <p class="text-slate-500 font-medium mt-1">Supervisez tous les contrats générés par l'ensemble des entreprises partenaires.</p>
            </div>
        </div>

        <!-- Barre de Recherche & Filtres Premium -->
        <div class="bg-white rounded-xl p-3 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3" style="border: 0.5px solid rgba(0,0,0,0.1);">
            <form action="{{ route('admin.contracts.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3 w-full">
                
                {{-- Search --}}
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Rechercher un contrat..."
                        class="w-full h-[44px] bg-[#F9F8F5] border border-[#D3D1C7] rounded-[10px] text-[15px] text-[#2C2C2A] placeholder:text-[#B5B4AA] pl-9 pr-3 focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all">
                    <button type="submit" class="hidden"></button>
                </div>

                {{-- Right filters --}}
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Type filter --}}
                    <select name="type" onchange="this.form.submit()"
                            class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all cursor-pointer"
                            style="width: auto; min-width: 140px;">
                        <option value="">Type : Tous</option>
                        <option value="CDI"        {{ request('type') == 'CDI'        ? 'selected' : '' }}>CDI</option>
                        <option value="CDD"        {{ request('type') == 'CDD'        ? 'selected' : '' }}>CDD</option>
                        <option value="Stage"      {{ request('type') == 'Stage'      ? 'selected' : '' }}>Stage</option>
                        <option value="Prestation" {{ request('type') == 'Prestation' ? 'selected' : '' }}>Prestation</option>
                    </select>

                    {{-- Status filter --}}
                    <select name="statut" onchange="this.form.submit()"
                            class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all cursor-pointer"
                            style="width: auto; min-width: 160px;">
                        <option value="">Statut : Tous</option>
                        <option value="{{ \App\Models\Contrat::STATUS_ACTIVE }}"          {{ request('statut') == \App\Models\Contrat::STATUS_ACTIVE          ? 'selected' : '' }}>Actif</option>
                        <option value="{{ \App\Models\Contrat::STATUS_DRAFT }}"           {{ request('statut') == \App\Models\Contrat::STATUS_DRAFT           ? 'selected' : '' }}>Brouillon</option>
                        <option value="{{ \App\Models\Contrat::STATUS_SENT }}"            {{ request('statut') == \App\Models\Contrat::STATUS_SENT            ? 'selected' : '' }}>Envoyé</option>
                        <option value="{{ \App\Models\Contrat::STATUS_SIGNED_EMPLOYER }}" {{ request('statut') == \App\Models\Contrat::STATUS_SIGNED_EMPLOYER  ? 'selected' : '' }}>Signé employeur</option>
                        <option value="{{ \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE }}" {{ request('statut') == \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE  ? 'selected' : '' }}>Signé employé</option>
                        <option value="{{ \App\Models\Contrat::STATUS_CANCELLED }}"       {{ request('statut') == \App\Models\Contrat::STATUS_CANCELLED        ? 'selected' : '' }}>Annulé</option>
                    </select>

                    {{-- Export Button --}}
                    <button type="button" class="h-[44px] px-4 flex items-center gap-2 bg-white border border-[#D3D1C7] rounded-[10px] text-[15px] text-[#2C2C2A] hover:bg-[#F9F8F5] hover:border-[#B5B4AA] transition-all cursor-pointer shadow-sm">
                        <svg class="w-4 h-4 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Exporter
                    </button>

                    {{-- Reset --}}
                    @if(request()->anyFilled(['search', 'type', 'statut']))
                        <a href="{{ route('admin.contracts.index') }}" class="h-[44px] w-[44px] flex items-center justify-center bg-[#FCEBEB] border border-[#FCEBEB] text-[#993C1D] hover:bg-[#FAD8D8] rounded-[10px] transition-all shrink-0" title="Réinitialiser">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($contrats as $contrat)
                @php
                    $statusBadge = match($contrat->statut) {
                        \App\Models\Contrat::STATUS_DRAFT => 'badge-gray',
                        \App\Models\Contrat::STATUS_SENT => 'badge-pending',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYER, \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'badge-warning',
                        \App\Models\Contrat::STATUS_ACTIVE => 'badge-active',
                        \App\Models\Contrat::STATUS_CANCELLED => 'badge-rejected',
                        default => 'badge-gray',
                    };
                    $statusLabel = match($contrat->statut) {
                        \App\Models\Contrat::STATUS_DRAFT => 'Brouillon',
                        \App\Models\Contrat::STATUS_SENT => 'Envoyé',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYER => 'Signé employeur',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'Signé employé',
                        \App\Models\Contrat::STATUS_ACTIVE => 'Actif',
                        \App\Models\Contrat::STATUS_CANCELLED => 'Annulé',
                        default => ucfirst(str_replace('_', ' ', $contrat->statut)),
                    };
                @endphp
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="text-[15px] text-[#888780]">{{ $contrat->numero_contrat }}</div>
                            <div class="text-[15px] text-[#0F6E56]">{{ $contrat->type_contrat }}</div>
                        </div>
                        <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="mt-3 text-[15px]">
                        <div><span class="text-[#888780]">Entreprise:</span> <span class="text-[#2C2C2A]">{{ $contrat->entreprise->raison_sociale ?? 'N/A' }}</span></div>
                        <div class="mt-1"><span class="text-[#888780]">Employé:</span> <span class="text-[#2C2C2A]">{{ $contrat->employe->user->full_name ?? 'N/A' }}</span></div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('employer.contracts.show', $contrat) }}" target="_blank" class="btn btn-secondary btn-sm">Consulter</a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucun contrat n'a encore été généré sur la plateforme.</p>
                </div>
            @endforelse
        </div>

        <div class="bg-white/35 border border-white/40 backdrop-blur-md rounded-[2.5rem] shadow-sm overflow-hidden hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead class="bg-white/20">
                        <tr>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Contrat / Type</th>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Entreprise</th>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Employé</th>
                            <th class="px-6 py-5 text-left text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Statut</th>
                            <th class="px-6 py-5 text-right text-[15px] font-black text-slate-600 uppercase tracking-[0.2em]">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/20">
                        @forelse($contrats as $contrat)
                            <tr class="hover:bg-white/40 transition-colors duration-200">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="font-black text-[#2C2C2A] text-[15px] font-mono leading-none">{{ $contrat->numero_contrat }}</div>
                                    <div class="mt-1.5">
                                        <span class="text-[9px] font-black text-[#0F6E56] uppercase tracking-wider bg-[#0F6E56]/10 border border-[#0F6E56]/20 px-2 py-0.5 rounded-md">
                                            {{ $contrat->type_contrat }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-[15px] font-black text-[#2C2C2A] font-outfit">{{ $contrat->entreprise->raison_sociale ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="text-[15px] font-black text-[#2C2C2A] font-outfit leading-none">{{ $contrat->employe->user->full_name ?? 'N/A' }}</div>
                                    <div class="text-[15px] text-slate-500 font-bold mt-1">{{ $contrat->employe->poste ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @php
                                        $statusBadge = match($contrat->statut) {
                                            \App\Models\Contrat::STATUS_DRAFT => 'badge-gray',
                                            \App\Models\Contrat::STATUS_SENT => 'badge-pending',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYER, \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'badge-warning',
                                            \App\Models\Contrat::STATUS_ACTIVE => 'badge-active',
                                            \App\Models\Contrat::STATUS_CANCELLED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $statusLabel = match($contrat->statut) {
                                            \App\Models\Contrat::STATUS_DRAFT => 'Brouillon',
                                            \App\Models\Contrat::STATUS_SENT => 'Envoyé',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYER => 'Signé employeur',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'Signé employé',
                                            \App\Models\Contrat::STATUS_ACTIVE => 'Actif',
                                            \App\Models\Contrat::STATUS_CANCELLED => 'Annulé',
                                            default => ucfirst(str_replace('_', ' ', $contrat->statut)),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">
                                        {{ $statusLabel }}
                                    </span>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap text-right">
                                    <a href="{{ route('employer.contracts.show', $contrat) }}" target="_blank" class="inline-flex items-center gap-1.5 text-[#0F6E56] hover:text-[#0A5A45] font-black text-[15px] uppercase tracking-widest transition-all">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        Consulter
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-20 text-center">
                                    <svg class="mx-auto h-12 w-12 text-slate-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    <p class="text-slate-400 font-bold italic">Aucun contrat n'a encore été généré sur la plateforme.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($contrats->hasPages())
            <div class="mt-6">
                {{ $contrats->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
