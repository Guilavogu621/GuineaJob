<x-app-layout>
    <div class="py-12 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10">
                <h2 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">
                    Publier une <span class="text-[#0F6E56]">Offre d'Emploi</span>
                </h2>
                <p class="text-slate-500 font-medium mt-1">Attirez les meilleurs talents en décrivant précisément vos besoins.</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#0F6E56]/5 rounded-full blur-2xl transition-transform duration-700 group-hover:scale-110"></div>
                
                <div class="p-8 lg:p-10 relative z-10">
                    <form action="{{ route('employer.recrutement.store') }}" method="POST" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <!-- Titre -->
                            <div class="md:col-span-2">
                                <x-input-label for="titre" :value="__('Intitulé du Poste')" />
                                <x-text-input id="titre" name="titre" type="text" class="block w-full" :value="old('titre')" required autofocus placeholder="Ex: Développeur PHP Senior" />
                                <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                            </div>

                            <!-- Type de Contrat -->
                            <div>
                                <x-input-label for="type_contrat" :value="__('Type de Contrat')" />
                                <select id="type_contrat" name="type_contrat" required class="block w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl text-base font-medium text-[#2C2C2A] focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner cursor-pointer">
                                    <option value="CDI">CDI</option>
                                    <option value="CDD">CDD</option>
                                    <option value="Stage">Stage</option>
                                    <option value="Prestation">Prestation</option>
                                </select>
                                <x-input-error :messages="$errors->get('type_contrat')" class="mt-2" />
                            </div>

                            <!-- Lieu -->
                            <div>
                                <x-input-label for="lieu" :value="__('Lieu de Travail')" />
                                <x-text-input id="lieu" name="lieu" type="text" class="block w-full" :value="old('lieu', 'Conakry')" required placeholder="Ex: Conakry, Kaloum" />
                                <x-input-error :messages="$errors->get('lieu')" class="mt-2" />
                            </div>

                            <!-- Salaire -->
                            <div>
                                <x-input-label for="salaire_range" :value="__('Fourchette Salariale (Optionnel)')" />
                                <x-text-input id="salaire_range" name="salaire_range" type="text" class="block w-full" :value="old('salaire_range')" placeholder="Ex: 5M - 8M GNF" />
                                <x-input-error :messages="$errors->get('salaire_range')" class="mt-2" />
                            </div>

                            <!-- Date Expiration -->
                            <div>
                                <x-input-label for="date_expiration" :value="__('Date d\'expiration')" />
                                <x-text-input id="date_expiration" name="date_expiration" type="date" class="block w-full" :value="old('date_expiration')" />
                                <x-input-error :messages="$errors->get('date_expiration')" class="mt-2" />
                            </div>

                            <!-- Description -->
                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description du Poste')" />
                                <textarea id="description" name="description" rows="5" required class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-base font-medium text-[#2C2C2A] placeholder:text-slate-300 focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner" placeholder="Missions, environnement de travail...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <!-- Compétences -->
                            <div class="md:col-span-2">
                                <x-input-label for="competences_requises" :value="__('Profil Recherché (Compétences)')" />
                                <textarea id="competences_requises" name="competences_requises" rows="3" class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-base font-medium text-[#2C2C2A] placeholder:text-slate-300 focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner" placeholder="Listez les compétences clés...">{{ old('competences_requises') }}</textarea>
                                <x-input-error :messages="$errors->get('competences_requises')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-6 border-t border-slate-50">
                            <x-primary-button class="px-12">
                                Publier l'Annonce
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
