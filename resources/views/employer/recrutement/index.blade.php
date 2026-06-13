<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Gestion du Recrutement</h1>
                <p class="text-[15px] text-[#888780] mt-1">Gérez vos offres d'emploi et suivez les candidatures en temps réel.</p>
            </div>
            <a href="{{ route('employer.recrutement.create') }}" class="btn btn-primary btn-md" style="gap: 6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Publier une offre
            </a>
        </div>

        {{-- Flash Success --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[15px] font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($offres as $offre)
                @php
                    $statusBadge = match($offre->statut) {
                        \App\Models\OffreEmploi::STATUS_PUBLISHED => 'badge-active',
                        \App\Models\OffreEmploi::STATUS_DRAFT => 'badge-gray',
                        \App\Models\OffreEmploi::STATUS_ARCHIVED => 'badge-warning',
                        \App\Models\OffreEmploi::STATUS_CLOSED => 'badge-rejected',
                        default => 'badge-gray',
                    };
                    $statusLabel = match($offre->statut) {
                        \App\Models\OffreEmploi::STATUS_PUBLISHED => 'Publiée',
                        \App\Models\OffreEmploi::STATUS_DRAFT => 'Brouillon',
                        \App\Models\OffreEmploi::STATUS_ARCHIVED => 'Archivée',
                        \App\Models\OffreEmploi::STATUS_CLOSED => 'Clôturée',
                        default => ucfirst(str_replace('_', ' ', $offre->statut)),
                    };
                @endphp
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $offre->titre }}</div>
                            <div class="text-[15px] text-[#888780] mt-0.5">Publiée le {{ $offre->created_at->format('d/m/Y') }}</div>
                        </div>
                        <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-2 text-[15px]">
                        <div>
                            <div class="text-[#888780]">Type</div>
                            <div class="text-[#2C2C2A]">{{ $offre->type_contrat }}</div>
                        </div>
                        <div>
                            <div class="text-[#888780]">Lieu</div>
                            <div class="text-[#2C2C2A]">{{ $offre->lieu }}</div>
                        </div>
                        <div class="col-span-2">
                            <div class="text-[#888780]">Candidatures</div>
                            <div class="text-[#0F6E56]">{{ $offre->candidatures_count }}</div>
                        </div>
                    </div>

                    <div class="mt-4 flex flex-wrap gap-2">
                        <a href="{{ route('employer.recrutement.applications', $offre) }}" class="btn btn-secondary btn-sm">Candidatures</a>
                        <form action="{{ route('employer.recrutement.destroy', $offre) }}" method="POST" class="inline">
                            @csrf @method('DELETE')
                            <button type="submit" onclick="return confirm('Supprimer cette offre ?')" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucune offre publiée.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px;">Offre d'emploi</th>
                            <th style="padding: 10px 18px;">Type / Lieu</th>
                            <th style="padding: 10px 18px; text-align: center;">Candidatures</th>
                            <th style="padding: 10px 18px;">Statut</th>
                            <th style="padding: 10px 18px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($offres as $offre)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $offre->titre }}</div>
                                    <div class="text-[15px] text-[#888780] mt-0.5">Publiée le {{ $offre->created_at->format('d/m/Y') }}</div>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $offre->type_contrat }}</div>
                                    <div class="text-[15px] text-[#888780] flex items-center gap-1 mt-0.5">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                        {{ $offre->lieu }}
                                    </div>
                                </td>
                                <td style="padding: 12px 18px; text-align: center;">
                                    <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-[15px] font-medium" style="background: #E1F5EE; color: #0F6E56; border: 0.5px solid rgba(26,122,74,0.15);">
                                        {{ $offre->candidatures_count }}
                                    </span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    @php
                                        $statusBadge = match($offre->statut) {
                                            \App\Models\OffreEmploi::STATUS_PUBLISHED => 'badge-active',
                                            \App\Models\OffreEmploi::STATUS_DRAFT => 'badge-gray',
                                            \App\Models\OffreEmploi::STATUS_ARCHIVED => 'badge-warning',
                                            \App\Models\OffreEmploi::STATUS_CLOSED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $statusLabel = match($offre->statut) {
                                            \App\Models\OffreEmploi::STATUS_PUBLISHED => 'Publiée',
                                            \App\Models\OffreEmploi::STATUS_DRAFT => 'Brouillon',
                                            \App\Models\OffreEmploi::STATUS_ARCHIVED => 'Archivée',
                                            \App\Models\OffreEmploi::STATUS_CLOSED => 'Clôturée',
                                            default => ucfirst(str_replace('_', ' ', $offre->statut)),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <div class="flex justify-end items-center gap-2">
                                        <a href="{{ route('employer.recrutement.applications', $offre) }}" class="btn btn-secondary btn-sm" style="gap: 4px;">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            Candidatures
                                        </a>
                                        <form action="{{ route('employer.recrutement.destroy', $offre) }}" method="POST" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" onclick="return confirm('Supprimer cette offre ?')" class="btn btn-danger btn-sm" style="gap: 4px;">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucune offre publiée.</p>
                                        <p class="text-[15px] text-[#888780] mt-1">Commencez par publier votre première offre d'emploi.</p>
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
