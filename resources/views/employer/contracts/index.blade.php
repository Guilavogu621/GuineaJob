<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Mes Contrats de Travail</h1>
                <p class="text-[15px] text-[#888780] mt-1">Gérez et suivez les contrats de travail de vos employés.</p>
            </div>
            <a href="{{ route('employer.contracts.create') }}" class="btn btn-primary btn-md" style="gap: 6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouveau contrat
            </a>
        </div>

        {{-- Flash Success --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[15px] font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Search & Filters Bar --}}
        <div class="bg-white rounded-xl p-3 flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3" style="border: 0.5px solid rgba(0,0,0,0.1);">
            <form action="{{ route('employer.contracts.index') }}" method="GET" class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3 w-full">
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

                    {{-- Export --}}
                    <button type="button"
                            class="h-[44px] px-4 inline-flex items-center gap-2 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] hover:bg-[#F1EFE8] transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Exporter
                    </button>

                    {{-- Reset --}}
                    @if(request()->anyFilled(['search', 'type', 'statut']))
                        <a href="{{ route('employer.contracts.index') }}"
                           class="h-[44px] px-4 inline-flex items-center gap-2 border border-[#D3D1C7] rounded-[10px] text-[15px] text-[#993C1D] hover:bg-[#FCEBEB] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($contracts as $contract)
                @php
                    $statusBadge = match($contract->statut) {
                        \App\Models\Contrat::STATUS_DRAFT => 'badge-gray',
                        \App\Models\Contrat::STATUS_SENT => 'badge-pending',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYER, \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'badge-warning',
                        \App\Models\Contrat::STATUS_ACTIVE => 'badge-active',
                        \App\Models\Contrat::STATUS_CANCELLED => 'badge-rejected',
                        default => 'badge-gray',
                    };
                    $statusLabel = match($contract->statut) {
                        \App\Models\Contrat::STATUS_DRAFT => 'Brouillon',
                        \App\Models\Contrat::STATUS_SENT => 'Envoyé',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYER => 'Signé employeur',
                        \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'Signé employé',
                        \App\Models\Contrat::STATUS_ACTIVE => 'Actif',
                        \App\Models\Contrat::STATUS_CANCELLED => 'Annulé',
                        default => ucfirst(str_replace('_', ' ', $contract->statut)),
                    };
                @endphp
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-start justify-between gap-3">
                        <span class="matricule-pill">{{ $contract->numero_contrat }}</span>
                        <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="mt-3">
                        <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $contract->employe->user->full_name }}</div>
                        <div class="text-[15px] text-[#888780]">{{ $contract->employe->poste }}</div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-2 text-[15px]">
                        <div>
                            <div class="text-[#888780]">Type</div>
                            <div class="text-[#2C2C2A]">{{ $contract->type_contrat }}</div>
                        </div>
                        <div>
                            <div class="text-[#888780]">Début</div>
                            <div class="text-[#2C2C2A]">{{ \Carbon\Carbon::parse($contract->date_debut)->translatedFormat('d M Y') }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-[#888780]">Salaire brut</div>
                            <div class="text-[#2C2C2A]">{{ number_format($contract->salaire_mensuel_brut, 0, ',', ' ') }} GNF</div>
                        </div>
                    </div>

                        <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('employer.contracts.show', $contract) }}" class="btn btn-outline btn-sm">Voir</a>
                        <a href="{{ route('employer.contracts.download', $contract) }}" class="btn btn-secondary btn-sm">PDF</a>
                        @if(!$contract->isSignedByEmployee())
                            <a href="{{ route('employer.contracts.edit', $contract) }}" class="btn btn-outline btn-sm">Modifier</a>
                        @endif
                        @if($contract->statut === \App\Models\Contrat::STATUS_DRAFT)
                            <form action="{{ route('employer.contracts.send', $contract) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-sm bg-[#0F6E56] hover:bg-[#0A5A45] border-none">Envoyer</button>
                            </form>
                        @endif
                        @if($contract->statut !== \App\Models\Contrat::STATUS_CANCELLED)
                            <a href="{{ route('employer.contracts.terminate', $contract) }}" class="btn btn-danger btn-sm">Résilier</a>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucun contrat généré pour le moment.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table" style="table-layout: fixed; width: 100%;">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px; width: 130px;">N° contrat</th>
                            <th style="padding: 10px 18px; width: 180px;">Employé</th>
                            <th style="padding: 10px 18px; width: 80px;">Type</th>
                            <th style="padding: 10px 18px; width: 110px;">Date début</th>
                            <th style="padding: 10px 18px; width: 130px;">Salaire brut</th>
                            <th style="padding: 10px 18px; width: 120px;">Statut</th>
                            <th style="padding: 10px 18px; width: 140px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($contracts as $contract)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    <span style="background: #E1F5EE; color: #0F6E56; font-family: 'JetBrains Mono', monospace; font-size: 12px; font-weight: 500; padding: 3px 8px; border-radius: 6px; white-space: nowrap;">
                                        {{ $contract->numero_contrat }}
                                    </span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <div class="truncate">
                                        <div class="text-[15px] font-medium text-[#2C2C2A] truncate" title="{{ $contract->employe->user->full_name }}">{{ $contract->employe->user->full_name }}</div>
                                        <div class="text-[15px] text-[#888780] truncate" title="{{ $contract->employe->poste }}">{{ $contract->employe->poste }}</div>
                                    </div>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="badge badge-info">{{ $contract->type_contrat }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] text-[#888780]">{{ \Carbon\Carbon::parse($contract->date_debut)->translatedFormat('d M Y') }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ number_format($contract->salaire_mensuel_brut, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    @php
                                        $statusBadge = match($contract->statut) {
                                            \App\Models\Contrat::STATUS_DRAFT => 'badge-gray',
                                            \App\Models\Contrat::STATUS_SENT => 'badge-pending',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYER, \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'badge-warning',
                                            \App\Models\Contrat::STATUS_ACTIVE => 'badge-active',
                                            \App\Models\Contrat::STATUS_CANCELLED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $statusLabel = match($contract->statut) {
                                            \App\Models\Contrat::STATUS_DRAFT => 'Brouillon',
                                            \App\Models\Contrat::STATUS_SENT => 'Envoyé',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYER => 'Signé employeur',
                                            \App\Models\Contrat::STATUS_SIGNED_EMPLOYEE => 'Signé employé',
                                            \App\Models\Contrat::STATUS_ACTIVE => 'Actif',
                                            \App\Models\Contrat::STATUS_CANCELLED => 'Annulé',
                                            default => ucfirst(str_replace('_', ' ', $contract->statut)),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <div class="flex justify-end items-center gap-1.5">
                                        {{-- Voir --}}
                                        <a href="{{ route('employer.contracts.show', $contract) }}" title="Voir" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#2C2C2A] hover:bg-[#F1EFE8]" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                        </a>
                                        {{-- Télécharger --}}
                                        <a href="{{ route('employer.contracts.download', $contract) }}" title="Télécharger PDF" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#0F6E56] hover:bg-[#E1F5EE]" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </a>
                                        {{-- Modifier --}}
                                        @if(!$contract->isSignedByEmployee())
                                            <a href="{{ route('employer.contracts.edit', $contract) }}" title="Modifier" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#185FA5] hover:bg-[#E6F1FB]" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </a>
                                        @else
                                            <div title="Non modifiable" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#888780] opacity-30 cursor-not-allowed" style="border: 0.5px solid rgba(0,0,0,0.05);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                            </div>
                                        @endif
                                        {{-- Envoyer (Brouillon) --}}
                                        @if($contract->statut === \App\Models\Contrat::STATUS_DRAFT)
                                            <form action="{{ route('employer.contracts.send', $contract) }}" method="POST" class="inline">
                                                @csrf
                                                <button type="submit" title="Envoyer le contrat" class="w-7 h-7 rounded-lg flex items-center justify-center text-white bg-[#0F6E56] hover:bg-[#0A5A45]" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                                </button>
                                            </form>
                                        @endif
                                        {{-- Résilier --}}
                                        @if($contract->statut !== \App\Models\Contrat::STATUS_CANCELLED)
                                            <a href="{{ route('employer.contracts.terminate', $contract) }}" title="Résilier" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#993C1D] hover:bg-[#FCEBEB]" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            </a>
                                        @else
                                            <div title="Déjà résilié" class="w-7 h-7 rounded-lg flex items-center justify-center text-[#888780] opacity-30 cursor-not-allowed" style="border: 0.5px solid rgba(0,0,0,0.05);">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                            </div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucun contrat généré pour le moment.</p>
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
