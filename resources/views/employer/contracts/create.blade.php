<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-6"
         x-data="{
            step: 1,
            typeContrat: '{{ old('type_contrat', '') }}',
            employe_id: '{{ old('employe_id', request('employe_id', '')) }}',
            date_debut: '{{ old('date_debut', '') }}',
            date_fin: '{{ old('date_fin', '') }}',
            salaire: '{{ old('salaire_mensuel_brut', '') }}',

            isValidStep1() {
                return this.employe_id !== '' && this.typeContrat !== '';
            },
            isValidStep2() {
                if (this.date_debut === '' || this.salaire === '') return false;
                if ((this.typeContrat === 'CDD' || this.typeContrat === 'Stage') && this.date_fin === '') return false;
                return true;
            }
         }">

        <div>
            <h1 class="text-xl font-medium text-[#2C2C2A]">Nouveau contrat de travail</h1>
            <p class="text-[15px] text-[#888780] mt-1">Créez un contrat en 3 étapes : type, clauses et validation.</p>
        </div>

        @if($errors->any())
            <div class="alert alert-danger">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm-1-9V7a1 1 0 112 0v2a1 1 0 11-2 0zm0 4a1 1 0 112 0 1 1 0 01-2 0z" clip-rule="evenodd"></path></svg>
                <div>
                    @foreach ($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="bg-white rounded-xl p-5 sm:p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
            <div class="mb-6">
                <div class="relative flex items-center justify-between">
                    <div class="absolute left-0 right-0 top-4 h-[2px] bg-[#D3D1C7]"></div>
                    <div class="absolute left-0 top-4 h-[2px] bg-[#0F6E56] transition-all duration-300"
                         :style="'width:' + ((step - 1) * 50) + '%'">
                    </div>

                    <div class="relative z-10 flex flex-col items-center gap-1 bg-white px-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[15px]"
                             :class="step >= 1 ? 'bg-[#0F6E56] text-white' : 'bg-[#F1EFE8] text-[#888780]'">1</div>
                        <span class="text-[15px] text-[#888780]">Type</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center gap-1 bg-white px-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[15px]"
                             :class="step >= 2 ? 'bg-[#0F6E56] text-white' : 'bg-[#F1EFE8] text-[#888780]'">2</div>
                        <span class="text-[15px] text-[#888780]">Clauses</span>
                    </div>
                    <div class="relative z-10 flex flex-col items-center gap-1 bg-white px-1">
                        <div class="w-8 h-8 rounded-full flex items-center justify-center text-[15px]"
                             :class="step >= 3 ? 'bg-[#0F6E56] text-white' : 'bg-[#F1EFE8] text-[#888780]'">3</div>
                        <span class="text-[15px] text-[#888780]">Validation</span>
                    </div>
                </div>
            </div>

            <form method="POST" action="{{ route('employer.contracts.store') }}" class="space-y-6">
                @csrf

                <section x-show="step === 1" x-transition.opacity.duration.200ms class="space-y-5">
                    <div>
                        <h2 class="text-base font-medium text-[#2C2C2A]">Type et employé</h2>
                        <p class="text-[15px] text-[#888780] mt-1">Sélectionnez le collaborateur et le cadre contractuel.</p>
                    </div>

                    <div>
                        <x-input-label for="employe_id" :value="__('Employé')" />
                        <select id="employe_id" name="employe_id" x-model="employe_id" class="block mt-1 w-full" required>
                            <option value="">-- Choisir un employé --</option>
                            @foreach($employees as $emp)
                                <option value="{{ $emp->id }}">{{ $emp->user->full_name }} ({{ $emp->numero_matricule }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <x-input-label :value="__('Type de contrat')" />
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 mt-2">
                            @foreach(['CDI', 'CDD', 'Stage', 'Prestation'] as $type)
                                <label class="p-3 rounded-xl border cursor-pointer transition-colors"
                                       :class="typeContrat === '{{ $type }}' ? 'border-[#0F6E56] bg-[#E1F5EE]/40' : 'border-[#D3D1C7]'">
                                    <input type="radio" name="type_contrat" value="{{ $type }}" x-model="typeContrat" class="mr-2" required>
                                    <span class="text-[15px] text-[#2C2C2A]">{{ $type }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="button"
                                @click="if (isValidStep1()) step = 2"
                                :class="!isValidStep1() ? 'opacity-50 cursor-not-allowed' : ''"
                                class="btn btn-primary btn-md">
                            Continuer
                        </button>
                    </div>
                </section>

                <section x-show="step === 2" x-transition.opacity.duration.200ms class="space-y-5" x-cloak>
                    <div>
                        <h2 class="text-base font-medium text-[#2C2C2A]">Clauses et rémunération</h2>
                        <p class="text-[15px] text-[#888780] mt-1">Complétez les dates et les éléments contractuels.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="date_debut" :value="__('Date de début')" />
                            <x-text-input id="date_debut" class="block mt-1 w-full" type="date" name="date_debut" x-model="date_debut" required />
                        </div>

                        <div x-show="typeContrat !== 'CDI'" x-cloak>
                            <x-input-label for="date_fin" :value="__('Date de fin')" />
                            <x-text-input id="date_fin" class="block mt-1 w-full" type="date" name="date_fin" x-model="date_fin" x-bind:required="typeContrat === 'CDD' || typeContrat === 'Stage'" />
                        </div>

                        <div>
                            <label for="salaire_mensuel_brut" class="block text-[15px] text-[#888780] mb-1">
                                <span x-text="typeContrat === 'Stage' ? 'Indemnité mensuelle (GNF)' : (typeContrat === 'Prestation' ? 'Honoraires mensuels (GNF)' : 'Salaire mensuel brut (GNF)')"></span>
                            </label>
                            <x-text-input id="salaire_mensuel_brut" class="block mt-1 w-full" type="number" name="salaire_mensuel_brut" x-model="salaire" required />
                        </div>

                        <div>
                            <x-input-label for="periode_essai" :value="__('Période d\'essai (optionnel)')" />
                            <x-text-input id="periode_essai" class="block mt-1 w-full" type="text" name="periode_essai" :value="old('periode_essai')" placeholder="Ex: 3 mois" />
                        </div>
                    </div>

                    @php $oldAvantages = old('avantages', []); @endphp
                    <div>
                        <x-input-label :value="__('Avantages inclus')" />
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-3 mt-2">
                            @foreach(['Transport', 'Logement', 'Santé', 'Restauration'] as $avantage)
                                <label class="p-3 rounded-xl border border-[#D3D1C7] text-[15px] text-[#2C2C2A] flex items-center gap-2">
                                    <input type="checkbox" name="avantages[]" value="{{ $avantage }}" {{ in_array($avantage, $oldAvantages) ? 'checked' : '' }}>
                                    <span>{{ $avantage }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <x-input-label for="clauses_specifiques" :value="__('Clauses spécifiques (optionnel)')" />
                        <textarea id="clauses_specifiques" name="clauses_specifiques" rows="4" class="block mt-1 w-full" placeholder="Confidentialité, non-concurrence, modalités particulières...">{{ old('clauses_specifiques') }}</textarea>
                    </div>

                    <div class="pt-2 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                        <button type="button" @click="step = 1" class="btn btn-outline btn-md">Précédent</button>
                        <button type="button"
                                @click="if (isValidStep2()) step = 3"
                                :class="!isValidStep2() ? 'opacity-50 cursor-not-allowed' : ''"
                                class="btn btn-primary btn-md">
                            Continuer
                        </button>
                    </div>
                </section>

                <section x-show="step === 3" x-transition.opacity.duration.200ms class="space-y-5" x-cloak>
                    <div>
                        <h2 class="text-base font-medium text-[#2C2C2A]">Validation finale</h2>
                        <p class="text-[15px] text-[#888780] mt-1">Vérifiez les informations puis confirmez la génération.</p>
                    </div>

                    <div class="bg-[#F1EFE8] rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.08);">
                        <ul class="text-[15px] text-[#2C2C2A] space-y-2">
                            <li><span class="text-[#888780]">Type :</span> <span x-text="typeContrat || '-' "></span></li>
                            <li><span class="text-[#888780]">Date de début :</span> <span x-text="date_debut || '-' "></span></li>
                            <li x-show="typeContrat !== 'CDI'"><span class="text-[#888780]">Date de fin :</span> <span x-text="date_fin || '-' "></span></li>
                            <li><span class="text-[#888780]">Montant :</span> <span x-text="salaire || '-' "></span> GNF</li>
                        </ul>
                    </div>

                    <div class="pt-2 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                        <button type="button" @click="step = 2" class="btn btn-outline btn-md">Précédent</button>
                        <button type="submit" class="btn btn-primary btn-md">Générer le contrat</button>
                    </div>
                </section>
            </form>
        </div>
    </div>
</x-app-layout>
