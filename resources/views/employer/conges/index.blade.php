<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Demandes de Congé</h1>
                <p class="text-[15px] text-[#888780] mt-1">Gérez et traitez les demandes de congé de vos employés.</p>
            </div>
        </div>

        {{-- Flash Success --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[15px] font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Stat Cards Row --}}
        @php
            $totalConges = $conges->count();
            $enAttente = $conges->where('statut', \App\Models\Conge::STATUS_PENDING)->count();
            $valides = $conges->where('statut', \App\Models\Conge::STATUS_APPROVED)->count();
            $joursConsommes = $conges->sum('jours_deduits');
        @endphp
        <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #0F6E56;">
                <p class="text-[15px] text-[#888780] font-medium" style="text-transform: none; letter-spacing: 0.5px;">Demandes totales</p>
                <p class="text-2xl font-medium text-[#2C2C2A] mt-1">{{ $totalConges }}</p>
            </div>
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #BA7517;">
                <p class="text-[15px] text-[#888780] font-medium" style="text-transform: none; letter-spacing: 0.5px;">En attente</p>
                <p class="text-2xl font-medium text-[#BA7517] mt-1">{{ $enAttente }}</p>
            </div>
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #0F6E56;">
                <p class="text-[15px] text-[#888780] font-medium" style="text-transform: none; letter-spacing: 0.5px;">Validées</p>
                <p class="text-2xl font-medium text-[#0F6E56] mt-1">{{ $valides }}</p>
            </div>
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #993C1D;">
                <p class="text-[15px] text-[#888780] font-medium" style="text-transform: none; letter-spacing: 0.5px;">Jours consommés</p>
                <p class="text-2xl font-medium text-[#2C2C2A] mt-1">{{ $joursConsommes }}</p>
            </div>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($conges as $conge)
                @php
                    $typeBadgeClass = match($conge->type_conge) {
                        'annuel' => 'badge-info',
                        'maladie' => 'badge-danger',
                        'sans_solde' => 'badge-warning',
                        default => 'badge-gray',
                    };
                    $typeLabel = match($conge->type_conge) {
                        'annuel' => 'Annuel',
                        'maladie' => 'Maladie',
                        'sans_solde' => 'Sans solde',
                        'maternite' => 'Maternité',
                        'paternite' => 'Paternité',
                        default => ucfirst(str_replace('_', ' ', $conge->type_conge)),
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
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);" x-data="{ showReject: false }">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $conge->employe->user->full_name }}</div>
                            <div class="text-[15px] text-[#888780]">{{ $conge->employe->poste }}</div>
                        </div>
                        <span class="badge {{ $statusBadge }}">{{ $statusLabel }}</span>
                    </div>

                    <div class="mt-3 flex flex-wrap gap-2">
                        <span class="badge {{ $typeBadgeClass }}">{{ $typeLabel }}</span>
                        <span class="text-[15px] text-[#888780]">{{ $conge->date_debut->translatedFormat('d M') }} → {{ $conge->date_fin->translatedFormat('d M Y') }}</span>
                    </div>

                    <div class="mt-2 text-[15px] text-[#2C2C2A]">
                        <span class="text-[#888780]">Durée:</span> {{ $conge->jours_deduits }} jours
                    </div>
                    <div class="mt-1 text-[15px] text-[#2C2C2A] line-clamp-2">
                        <span class="text-[#888780]">Motif:</span> {{ $conge->motif }}
                    </div>

                    <div class="mt-4">
                        @if($conge->statut === \App\Models\Conge::STATUS_PENDING)
                            <div class="flex flex-wrap gap-2">
                                <form action="{{ route('employer.conges.approve', $conge) }}" method="POST" class="inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                                </form>
                                <button @click="showReject = !showReject" class="btn btn-danger btn-sm">Refuser</button>
                            </div>
                            <div x-show="showReject" x-transition class="mt-3 p-3 bg-white rounded-lg" style="border: 0.5px solid rgba(0,0,0,0.1);">
                                <form action="{{ route('employer.conges.reject', $conge) }}" method="POST">
                                    @csrf
                                    <label class="text-[15px] font-medium text-[#888780] mb-1 block">Raison du refus</label>
                                    <textarea name="reponse_employeur" rows="2" required placeholder="Saisir la raison..." class="w-full text-[15px]" style="min-height: 60px;"></textarea>
                                    <button type="submit" class="btn btn-danger btn-sm w-full mt-2">Confirmer le refus</button>
                                </form>
                            </div>
                        @else
                            <span class="badge badge-archived">Traité</span>
                        @endif
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucune demande de congé en cours.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px;">Employé</th>
                            <th style="padding: 10px 18px;">Type</th>
                            <th style="padding: 10px 18px;">Période</th>
                            <th style="padding: 10px 18px;">Durée</th>
                            <th style="padding: 10px 18px;">Motif</th>
                            <th style="padding: 10px 18px;">Statut</th>
                            <th style="padding: 10px 18px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($conges as $conge)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $avatarColors = ['#0F6E56', '#185FA5', '#BA7517', '#7C3AED', '#993C1D', '#0D9488'];
                                            $colorIndex = crc32($conge->employe->user->full_name) % count($avatarColors);
                                            $avatarColor = $avatarColors[abs($colorIndex)];
                                        @endphp
                                        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white text-[15px] font-medium" style="background-color: {{ $avatarColor }};">
                                            {{ substr($conge->employe->user->prenom, 0, 1) }}{{ substr($conge->employe->user->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $conge->employe->user->full_name }}</div>
                                            <div class="text-[15px] text-[#888780]">{{ $conge->employe->poste }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 12px 18px;">
                                    @php
                                        $typeBadgeClass = match($conge->type_conge) {
                                            'annuel' => 'badge-info',
                                            'maladie' => 'badge-danger',
                                            'sans_solde' => 'badge-warning',
                                            default => 'badge-gray',
                                        };
                                        $typeLabel = match($conge->type_conge) {
                                            'annuel' => 'Annuel',
                                            'maladie' => 'Maladie',
                                            'sans_solde' => 'Sans solde',
                                            'maternite' => 'Maternité',
                                            'paternite' => 'Paternité',
                                            default => ucfirst(str_replace('_', ' ', $conge->type_conge)),
                                        };
                                    @endphp
                                    <span class="badge {{ $typeBadgeClass }}">{{ $typeLabel }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] text-[#888780]">{{ $conge->date_debut->translatedFormat('d M') }} → {{ $conge->date_fin->translatedFormat('d M Y') }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ $conge->jours_deduits }} <span class="text-[15px] text-[#888780]">jours</span></span>
                                </td>
                                <td style="padding: 12px 18px; max-width: 200px;">
                                    <span class="text-[15px] text-[#2C2C2A] truncate block">{{ $conge->motif }}</span>
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
                                <td style="padding: 12px 18px; text-align: right;" x-data="{ showReject: false }">
                                    @if($conge->statut === \App\Models\Conge::STATUS_PENDING)
                                        <div class="flex items-center justify-end gap-2">
                                            <form action="{{ route('employer.conges.approve', $conge) }}" method="POST" class="inline-block">
                                                @csrf
                                                <button type="submit" class="btn btn-primary btn-sm">Valider</button>
                                            </form>
                                            <button @click="showReject = !showReject" class="btn btn-danger btn-sm">Refuser</button>
                                        </div>
                                        <div x-show="showReject" x-transition class="mt-3 text-left p-3 bg-white rounded-lg max-w-xs ml-auto" style="border: 0.5px solid rgba(0,0,0,0.1);">
                                            <form action="{{ route('employer.conges.reject', $conge) }}" method="POST">
                                                @csrf
                                                <label class="text-[15px] font-medium text-[#888780] mb-1 block">Raison du refus</label>
                                                <textarea name="reponse_employeur" rows="2" required placeholder="Saisir la raison..." class="w-full text-[15px]" style="min-height: 60px;"></textarea>
                                                <button type="submit" class="btn btn-danger btn-sm w-full mt-2">Confirmer le refus</button>
                                            </form>
                                        </div>
                                    @else
                                        <span class="badge badge-archived">Traité</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucune demande de congé en cours.</p>
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
