<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Rupture du Contrat : ') }} {{ $contract->numero_contrat }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <!-- Alerte de sécurité -->
            <div class="mb-8 p-6 bg-[#FAEEDA] border-l-4 border-[#BA7517] rounded-2xl shadow-sm">
                <div class="flex items-start gap-4">
                    <div class="text-[#BA7517]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-[#633806] font-bold mb-1 uppercase text-xs tracking-widest">Avertissement Légal</h3>
                        <p class="text-[#633806] text-sm leading-relaxed">
                            La rupture d'un contrat de travail doit respecter les procédures prévues par le Code du Travail de la République de Guinée. Assurez-vous d'avoir les justificatifs nécessaires pour le motif invoqué.
                        </p>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 md:p-12">
                    <div class="mb-10 pb-6 border-b border-gray-100">
                        <h4 class="text-[15px] font-black text-gray-400 uppercase tracking-[0.2em] mb-2">Détails du Contrat Actuel</h4>
                        <div class="flex justify-between items-center">
                            <div>
                                <div class="text-xl font-black text-gray-900">{{ $contract->employe->user->full_name }}</div>
                                <div class="text-xs text-gray-500">{{ $contract->type_contrat }} — Débuté le {{ $contract->date_debut->format('d/m/Y') }}</div>
                            </div>
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
                            <span class="badge {{ $statusBadge }}">
                                {{ $statusLabel }}
                            </span>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('employer.contracts.process-terminate', $contract) }}">
                        @csrf

                        <div class="space-y-8">
                            <!-- 1. Type de Rupture -->
                            <div>
                                <x-input-label for="type_resiliation" :value="__('Type de rupture / Motif principal')" class="font-bold text-gray-900" />
                                <select id="type_resiliation" name="type_resiliation" required class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-xl py-3 px-4 shadow-sm">
                                    <option value="">-- Sélectionner le motif légal --</option>

                                    @if($contract->type_contrat === 'CDI')
                                        <optgroup label="CDI - Modes de rupture">
                                            <option value="{{ \App\Models\Contrat::RUPTURE_DEMISSION }}">Démission du salarié</option>
                                            <option value="{{ \App\Models\Contrat::RUPTURE_LICENCIEMENT }}">Licenciement (Procédure employeur)</option>
                                            <option value="{{ \App\Models\Contrat::RUPTURE_ACCORD }}">Rupture conventionnelle (Commun accord)</option>
                                        </optgroup>
                                    @elseif($contract->type_contrat === 'CDD')
                                        <optgroup label="CDD - Rupture anticipée (Strict)">
                                            <option value="{{ \App\Models\Contrat::RUPTURE_ACCORD }}">Commun accord</option>
                                            <option value="{{ \App\Models\Contrat::RUPTURE_FAUTE_GRAVE }}">Faute grave (Justifiée)</option>
                                            <option value="Embauche en CDI">Embauche du salarié en CDI ailleurs</option>
                                            <option value="Force majeure">Cas de force majeure</option>
                                            <option value="Inaptitude médicale">Inaptitude constatée par médecin</option>
                                        </optgroup>
                                    @else
                                        <optgroup label="STAGE - Interruption">
                                            <option value="{{ \App\Models\Contrat::RUPTURE_STAGE_ABANDON }}">Abandon de stage</option>
                                            <option value="{{ \App\Models\Contrat::RUPTURE_STAGE_EMBAUCHE }}">Embauche anticipée</option>
                                            <option value="{{ \App\Models\Contrat::RUPTURE_ACCORD }}">Accord parties</option>
                                        </optgroup>
                                    @endif

                                    <option value="Autre motif">Autre motif exceptionnel</option>
                                </select>
                            </div>

                            <!-- 2. Date de Rupture -->
                            <div>
                                <x-input-label for="date_resiliation" :value="__('Date de fin effective (Dernier jour travaillé)')" class="font-bold text-gray-900" />
                                <x-text-input id="date_resiliation" class="block mt-2 w-full" type="date" name="date_resiliation" required />
                                <p class="text-[15px] text-gray-400 mt-2 italic">Cette date sera utilisée pour le solde de tout compte.</p>
                            </div>

                            <!-- 3. Justification détaillée -->
                            <div>
                                <x-input-label for="motif_resiliation" :value="__('Justification détaillée de la rupture')" class="font-bold text-gray-900" />
                                <textarea id="motif_resiliation" name="motif_resiliation" rows="5" required placeholder="Expliquez ici les raisons précises de la rupture..." class="block mt-2 w-full border-gray-300 focus:border-red-500 focus:ring-red-500 rounded-2xl shadow-sm text-sm"></textarea>
                                <p class="text-[15px] text-gray-400 mt-2 italic">Ces informations sont confidentielles et serviront à l'archivage légal du dossier.</p>
                            </div>
                        </div>

                        <div class="mt-12 flex justify-between items-center pt-8 border-t border-gray-100">
                            <a href="{{ route('employer.contracts.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                                ← Annuler et revenir
                            </a>
                            <button type="submit" class="bg-red-600 text-white px-10 py-4 rounded-xl font-black text-xs uppercase tracking-widest shadow-xl shadow-red-200 hover:bg-red-700 transition-all">
                                Confirmer la Rupture Légale
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
