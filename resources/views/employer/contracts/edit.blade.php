<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier le Contrat : ') }} {{ $contract->numero_contrat }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        step: 1, 
        typeContrat: '{{ $contract->type_contrat }}', 
        employe_id: '{{ $contract->employe_id }}',
        date_debut: '{{ $contract->date_debut->format('Y-m-d') }}',
        date_fin: '{{ $contract->date_fin ? $contract->date_fin->format('Y-m-d') : '' }}',
        salaire: '{{ $contract->salaire_mensuel_brut }}',
        
        isValidStep1() { return this.employe_id !== '' && this.typeContrat !== ''; },
        isValidStep2() {
            if (this.date_debut === '' || this.salaire === '') return false;
            if ((this.typeContrat === 'CDD' || this.typeContrat === 'Stage') && this.date_fin === '') return false;
            return true;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 md:p-12">
                    <form method="POST" action="{{ route('employer.contracts.update', $contract) }}">
                        @csrf

                        <!-- ÉTAPE 1 : TYPE -->
                        <div x-show="step === 1">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Modification du Type</h3>
                            <div class="space-y-6">
                                <div>
                                    <x-input-label :value="__('Employé (Non modifiable)')" />
                                    <div class="p-4 bg-gray-50 rounded-xl border border-gray-200 font-bold text-gray-700">
                                        {{ $contract->employe->user->full_name }}
                                    </div>
                                </div>

                                <div>
                                    <x-input-label :value="__('Type de contrat')" class="mb-4 text-lg font-semibold" />
                                    <div class="grid grid-cols-1 gap-4">
                                        @foreach(['CDI', 'CDD', 'Stage'] as $type)
                                        <label class="flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all"
                                               :class="typeContrat === '{{ $type }}' ? 'border-guinea-green bg-guinea-green/5' : 'border-gray-100'">
                                            <input type="radio" name="type_contrat" value="{{ $type }}" x-model="typeContrat" class="w-5 h-5 text-guinea-green mr-4">
                                            <span class="font-bold text-gray-900">{{ $type }}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 flex justify-end">
                                <button type="button" @click="step = 2" class="bg-guinea-green text-white px-10 py-4 rounded-xl font-bold shadow-lg">
                                    Suivant →
                                </button>
                            </div>
                        </div>

                        <!-- ÉTAPE 2 : CLAUSES -->
                        <div x-show="step === 2">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Détails du Contrat</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <x-input-label for="date_debut" :value="__('Date de début')" />
                                    <x-text-input id="date_debut" class="block mt-1 w-full" type="date" name="date_debut" x-model="date_debut" required />
                                </div>
                                <div x-show="typeContrat !== 'CDI'">
                                    <x-input-label for="date_fin" :value="__('Date de fin')" />
                                    <x-text-input id="date_fin" class="block mt-1 w-full" type="date" name="date_fin" x-model="date_fin" />
                                </div>
                                <div>
                                    <x-input-label for="salaire_mensuel_brut" :value="__('Salaire Brut (GNF)')" />
                                    <x-text-input id="salaire_mensuel_brut" class="block mt-1 w-full" type="number" name="salaire_mensuel_brut" x-model="salaire" required />
                                </div>
                                <div>
                                    <x-input-label for="periode_essai" :value="__('Période d\'essai')" />
                                    <x-text-input id="periode_essai" class="block mt-1 w-full" type="text" name="periode_essai" value="{{ $contract->periode_essai }}" />
                                </div>
                            </div>

                            <div class="mt-8">
                                <x-input-label :value="__('Avantages')" class="mb-3" />
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach(['Transport', 'Logement', 'Santé', 'Restauration'] as $avantage)
                                    <label class="flex items-center space-x-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="avantages[]" value="{{ $avantage }}" 
                                               {{ in_array($avantage, $contract->avantages ?? []) ? 'checked' : '' }}
                                               class="rounded text-guinea-green focus:ring-guinea-green">
                                        <span class="text-sm font-medium text-gray-700">{{ $avantage }}</span>
                                    </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-8">
                                <x-input-label for="clauses_specifiques" :value="__('Clauses spécifiques')" />
                                <textarea id="clauses_specifiques" name="clauses_specifiques" rows="4" class="block mt-1 w-full border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-xl shadow-sm">{{ $contract->clauses_specifiques }}</textarea>
                            </div>

                            <div class="mt-12 flex justify-between">
                                <button type="button" @click="step = 1" class="text-gray-500 font-bold">← Précédent</button>
                                <x-primary-button class="bg-[#0F6E56] hover:bg-[#085041] px-10 py-4 shadow-xl">
                                    {{ __('ENREGISTRER LES MODIFICATIONS') }}
                                </x-primary-button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
