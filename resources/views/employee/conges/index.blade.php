<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Mes Demandes de Congé</h1>
                <p class="text-[15px] text-[#888780] mt-1">Consultez l'historique et le statut de vos demandes de congé.</p>
            </div>
            <a href="{{ route('employee.conges.create') }}" class="btn btn-primary btn-md" style="gap: 6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Nouvelle demande
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
            @forelse($conges as $conge)
                @php
                    $typeBadge = match($conge->type_conge) {
                        'annuel' => 'badge-info',
                        'maladie' => 'badge-danger',
                        'maternite', 'paternite' => 'badge-in-progress',
                        'sans_solde' => 'badge-warning',
                        default => 'badge-gray',
                    };
                    $statusBadge = match($conge->statut) {
                        \App\Models\Conge::STATUS_PENDING => 'badge-pending',
                        \App\Models\Conge::STATUS_APPROVED => 'badge-active',
                        \App\Models\Conge::STATUS_REJECTED => 'badge-rejected',
                        default => 'badge-gray',
                    };
                    $statusLabel = match($conge->statut) {
                        \App\Models\Conge::STATUS_PENDING => 'En attente',
                        \App\Models\Conge::STATUS_APPROVED => 'Validé',
                        \App\Models\Conge::STATUS_REJECTED => 'Refusé',
                        default => ucfirst(str_replace('_', ' ', $conge->statut)),
                    };
                @endphp
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-start justify-between gap-2">
                        <span class="badge {{ $typeBadge }}">{{ ucfirst(str_replace('_', ' ', $conge->type_conge)) }}</span>
                        <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                    </div>
                    <div class="mt-3 text-[15px] text-[#2C2C2A]">
                        <div><span class="text-[#888780]">Période:</span> {{ $conge->date_debut->translatedFormat('d M Y') }} → {{ $conge->date_fin->translatedFormat('d M Y') }}</div>
                        <div class="mt-1"><span class="text-[#888780]">Durée:</span> {{ $conge->jours_deduits }} jours</div>
                        <div class="mt-1"><span class="text-[#888780]">Réponse:</span> {{ $conge->reponse_employeur ?? '—' }}</div>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucune demande de congé.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px;">Type</th>
                            <th style="padding: 10px 18px;">Dates</th>
                            <th style="padding: 10px 18px;">Durée</th>
                            <th style="padding: 10px 18px;">Statut</th>
                            <th style="padding: 10px 18px;">Réponse employeur</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conges as $conge)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    @php
                                        $typeBadge = match($conge->type_conge) {
                                            'annuel' => 'badge-info',
                                            'maladie' => 'badge-danger',
                                            'maternite', 'paternite' => 'badge-in-progress',
                                            'sans_solde' => 'badge-warning',
                                            default => 'badge-gray',
                                        };
                                    @endphp
                                    <span class="badge {{ $typeBadge }}">{{ ucfirst(str_replace('_', ' ', $conge->type_conge)) }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] text-[#888780]">{{ $conge->date_debut->translatedFormat('d M Y') }} → {{ $conge->date_fin->translatedFormat('d M Y') }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ $conge->jours_deduits }} <span class="text-[15px] text-[#888780]">jours</span></span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    @php
                                        $statusBadge = match($conge->statut) {
                                            \App\Models\Conge::STATUS_PENDING => 'badge-pending',
                                            \App\Models\Conge::STATUS_APPROVED => 'badge-active',
                                            \App\Models\Conge::STATUS_REJECTED => 'badge-rejected',
                                            default => 'badge-gray',
                                        };
                                        $statusLabel = match($conge->statut) {
                                            \App\Models\Conge::STATUS_PENDING => 'En attente',
                                            \App\Models\Conge::STATUS_APPROVED => 'Validé',
                                            \App\Models\Conge::STATUS_REJECTED => 'Refusé',
                                            default => ucfirst(str_replace('_', ' ', $conge->statut)),
                                        };
                                    @endphp
                                    <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                                </td>
                                <td style="padding: 12px 18px; max-width: 220px;">
                                    <span class="text-[15px] text-[#2C2C2A] truncate block">{{ $conge->reponse_employeur ?? '—' }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucune demande de congé.</p>
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
