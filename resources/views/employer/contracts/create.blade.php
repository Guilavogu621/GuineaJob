<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Génération de Contrat de Travail') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="{ 
        step: 1, 
        typeContrat: '', 
        employe_id: '',
        date_debut: '',
        date_fin: '',
        salaire: '',
        
        // Validation Step 1
        isValidStep1() {
            return this.employe_id !== '' && this.typeContrat !== '';
        },
        
        // Validation Step 2
        isValidStep2() {
            if (this.date_debut === '' || this.salaire === '') return false;
            if ((this.typeContrat === 'CDD' || this.typeContrat === 'Stage') && this.date_fin === '') return false;
            return true;
        }
    }">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Stepper Header -->
            <div class="mb-10">
                <div class="flex items-center justify-between relative">
                    <!-- Progress Line -->
                    <div class="absolute top-1/2 left-0 w-full h-1 bg-gray-200 -translate-y-1/2 z-0"></div>
                    <div class="absolute top-1/2 left-0 h-1 bg-guinea-green -translate-y-1/2 z-0 transition-all duration-500" 
                         :style="'width: ' + ((step-1) * 50) + '%'"></div>

                    <!-- Step 1 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors duration-300"
                             :class="step >= 1 ? 'bg-guinea-green text-white' : 'bg-gray-200 text-gray-500'">1</div>
                        <span class="text-xs font-bold mt-2 uppercase tracking-tighter" :class="step >= 1 ? 'text-guinea-green' : 'text-gray-400'">Type</span>
                    </div>

                    <!-- Step 2 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors duration-300"
                             :class="step >= 2 ? 'bg-guinea-green text-white' : 'bg-gray-200 text-gray-500'">2</div>
                        <span class="text-xs font-bold mt-2 uppercase tracking-tighter" :class="step >= 2 ? 'text-guinea-green' : 'text-gray-400'">Clauses</span>
                    </div>

                    <!-- Step 3 -->
                    <div class="relative z-10 flex flex-col items-center">
                        <div class="w-10 h-10 rounded-full flex items-center justify-center font-bold transition-colors duration-300"
                             :class="step >= 3 ? 'bg-guinea-green text-white' : 'bg-gray-200 text-gray-500'">3</div>
                        <span class="text-xs font-bold mt-2 uppercase tracking-tighter" :class="step >= 3 ? 'text-guinea-green' : 'text-gray-400'">Aperçu</span>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 md:p-12">
                    <form method="POST" action="{{ route('employer.contracts.store') }}">
                        @csrf

                        <!-- ÉTAPE 1 : TYPE & EMPLOYÉ -->
                        <div x-show="step === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Type de contrat</h3>
                            <p class="text-sm text-gray-500 mb-8">Commencez par définir les parties et le type de relation contractuelle.</p>
                            
                            <div class="space-y-8">
                                <div>
                                    <x-input-label for="employe_id" :value="__('Sélectionner l\'employé')" class="text-lg font-semibold" />
                                    <select id="employe_id" name="employe_id" x-model="employe_id" class="block mt-1 w-full border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4 shadow-sm">
                                        <option value="">-- Choisir un employé --</option>
                                        @foreach($employees as $emp)
                                            <option value="{{ $emp->id }}">{{ $emp->user->full_name }} ({{ $emp->numero_matricule }})</option>
                                        @endforeach
                                    </select>
                                    <p class="text-[11px] text-gray-400 mt-2 italic flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path></svg>
                                        Indiquez le collaborateur pour lequel ce document est généré.
                                    </p>
                                </div>

                                <div>
                                    <x-input-label :value="__('Type de contrat')" class="mb-4 text-lg font-semibold" />
                                    <div class="space-y-4">
                                        <!-- Bloc CDI -->
                                        <label class="flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all hover:bg-gray-50"
                                               :class="typeContrat === 'CDI' ? 'border-guinea-green bg-guinea-green/5' : 'border-gray-100'">
                                            <input type="radio" name="type_contrat" value="CDI" x-model="typeContrat" class="w-5 h-5 text-guinea-green focus:ring-guinea-green mr-4">
                                            <div>
                                                <span class="block font-bold text-lg text-gray-900 leading-none">CDI</span>
                                                <span class="text-sm text-gray-500 italic">Pour une durée indéterminée.</span>
                                            </div>
                                        </label>

                                        <!-- Bloc CDD -->
                                        <label class="flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all hover:bg-gray-50"
                                               :class="typeContrat === 'CDD' ? 'border-guinea-green bg-guinea-green/5' : 'border-gray-100'">
                                            <input type="radio" name="type_contrat" value="CDD" x-model="typeContrat" class="w-5 h-5 text-guinea-green focus:ring-guinea-green mr-4">
                                            <div>
                                                <span class="block font-bold text-lg text-gray-900 leading-none">CDD</span>
                                                <span class="text-sm text-gray-500 italic">Contrat temporaire avec date de fin.</span>
                                            </div>
                                        </label>

                                        <!-- Bloc STAGE -->
                                        <label class="flex items-center p-5 border-2 rounded-2xl cursor-pointer transition-all hover:bg-gray-50"
                                               :class="typeContrat === 'Stage' ? 'border-guinea-green bg-guinea-green/5' : 'border-gray-100'">
                                            <input type="radio" name="type_contrat" value="Stage" x-model="typeContrat" class="w-5 h-5 text-guinea-green focus:ring-guinea-green mr-4">
                                            <div>
                                                <span class="block font-bold text-lg text-gray-900 leading-none">STAGE</span>
                                                <span class="text-sm text-gray-500 italic">Convention pour les étudiants ou en formation.</span>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-12 flex flex-col items-end">
                                <p x-show="!isValidStep1()" class="text-[10px] text-red-500 font-bold uppercase mb-3 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Veuillez choisir un employé et un type de contrat.
                                </p>
                                <button type="button" 
                                        @click="if(isValidStep1()) step = 2" 
                                        :class="!isValidStep1() ? 'bg-gray-300 cursor-not-allowed' : 'bg-guinea-green hover:bg-guinea-green-light shadow-lg'"
                                        class="text-white px-10 py-4 rounded-xl font-bold transition-all">
                                    Continuer vers les clauses →
                                </button>
                            </div>
                        </div>

                        <!-- ÉTAPE 2 : CLAUSES & SALAIRE -->
                        <div x-show="step === 2" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">Détails et Clauses</h3>
                            <p class="text-sm text-gray-500 mb-8">Précisez les termes de l'engagement financier et temporel.</p>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <x-input-label for="date_debut" :value="__('Date de prise de fonction')" class="font-semibold" />
                                    <x-text-input id="date_debut" class="block mt-1 w-full" type="date" name="date_debut" x-model="date_debut" required />
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Jour effectif du début de travail.</p>
                                </div>
                                <div x-show="typeContrat !== 'CDI'" x-transition>
                                    <x-input-label for="date_fin" :value="__('Date de fin (Obligatoire)')" class="font-semibold" />
                                    <x-text-input id="date_fin" class="block mt-1 w-full" type="date" name="date_fin" x-model="date_fin" />
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Date d'expiration du contrat.</p>
                                </div>
                                <div>
                                    <x-input-label for="salaire_mensuel_brut" :value="__('Salaire Mensuel Brut (GNF)')" class="font-semibold" />
                                    <x-text-input id="salaire_mensuel_brut" class="block mt-1 w-full font-mono text-lg" type="number" name="salaire_mensuel_brut" x-model="salaire" placeholder="Ex: 5000000" required />
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Montant avant retenues et taxes.</p>
                                </div>
                                <div>
                                    <x-input-label for="periode_essai" :value="__('Période d\'essai')" class="font-semibold" />
                                    <x-text-input id="periode_essai" class="block mt-1 w-full" type="text" name="periode_essai" placeholder="Ex: 3 mois" />
                                    <p class="text-[10px] text-gray-400 mt-1 italic">Indiquez la durée de test (optionnel).</p>
                                </div>
                            </div>

                            <div class="mt-8">
                                <x-input-label :value="__('Avantages inclus')" class="mb-3 font-semibold" />
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    @foreach(['Transport', 'Logement', 'Santé', 'Restauration'] as $avantage)
                                    <label class="flex items-center space-x-3 p-3 border rounded-xl hover:bg-gray-50 cursor-pointer">
                                        <input type="checkbox" name="avantages[]" value="{{ $avantage }}" class="rounded text-guinea-green focus:ring-guinea-green">
                                        <span class="text-sm font-medium text-gray-700">{{ $avantage }}</span>
                                    </label>
                                    @endforeach
                                </div>
                                <p class="text-[10px] text-gray-400 mt-2 italic">Cochez les primes ou services additionnels.</p>
                            </div>

                            <div class="mt-8">
                                <x-input-label for="clauses_specifiques" :value="__('Clauses spécifiques')" class="font-semibold" />
                                <textarea id="clauses_specifiques" name="clauses_specifiques" rows="4" placeholder="Indiquez ici les clauses de non-concurrence, de confidentialité, etc." class="block mt-1 w-full border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-xl shadow-sm"></textarea>
                            </div>

                            <div class="mt-12 flex flex-col items-end">
                                <p x-show="!isValidStep2()" class="text-[10px] text-red-500 font-bold uppercase mb-3 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path></svg>
                                    Veuillez remplir les dates et le salaire mensuel.
                                </p>
                                <div class="flex justify-between w-full items-center">
                                    <button type="button" @click="step = 1" class="text-gray-500 font-bold hover:text-gray-900">
                                        ← Précédent
                                    </button>
                                    <button type="button" 
                                            @click="if(isValidStep2()) step = 3" 
                                            :class="!isValidStep2() ? 'bg-gray-300 cursor-not-allowed' : 'bg-guinea-green hover:bg-guinea-green-light shadow-lg'"
                                            class="bg-guinea-green text-white px-10 py-4 rounded-xl font-bold shadow-lg transition-all">
                                        Aperçu final →
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- ÉTAPE 3 : APERÇU & VALIDATION -->
                        <div x-show="step === 3" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 transform translate-x-8">
                            <h3 class="text-2xl font-bold text-gray-900 mb-6">Aperçu & Confirmation</h3>
                            <div class="bg-gray-50 rounded-3xl p-8 border border-dashed border-gray-300">
                                <div class="flex items-start gap-4 mb-6">
                                    <div class="p-3 bg-guinea-green/10 rounded-2xl text-guinea-green">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 uppercase font-bold tracking-widest">Prêt pour la signature</p>
                                        <h4 class="text-xl font-bold text-gray-900">Le contrat est prêt à être généré.</h4>
                                    </div>
                                </div>
                                <p class="text-gray-600 mb-8 leading-relaxed">
                                    En cliquant sur le bouton ci-dessous, le contrat sera enregistré et un numéro de contrat unique sera généré. Vous pourrez ensuite l'envoyer à l'employé pour signature.
                                </p>
                            </div>

                            <div class="mt-12 flex justify-between">
                                <button type="button" @click="step = 2" class="text-gray-500 font-bold hover:text-gray-900">
                                    ← Précédent
                                </button>
                                <x-primary-button class="bg-guinea-gold hover:bg-orange-700 px-12 py-5 text-lg shadow-xl shadow-guinea-gold/20">
                                    {{ __('GÉNÉRER LE CONTRAT') }}
                                </x-primary-button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
