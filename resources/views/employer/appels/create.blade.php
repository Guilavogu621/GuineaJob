<x-app-layout>
    <div class="py-12 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-10 text-center md:text-left">
                <h2 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">
                    Lancer un <span class="text-[#0F6E56]">Appel d'Offre</span>
                </h2>
                <p class="text-slate-500 font-medium mt-1">Connectez-vous aux meilleurs prestataires pour réaliser vos projets.</p>
            </div>

            <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden relative group">
                <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#0F6E56]/5 rounded-full blur-2xl transition-transform duration-700 group-hover:scale-110"></div>
                
                <div class="p-8 lg:p-12 relative z-10">
                    <form action="{{ route('employer.appels.store') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                            <div class="md:col-span-2">
                                <x-input-label for="titre" :value="__('Titre du Marché')" />
                                <x-text-input id="titre" name="titre" type="text" class="block w-full" :value="old('titre')" required autofocus placeholder="Ex: Construction de nouveaux bureaux à Conakry" />
                                <x-input-error :messages="$errors->get('titre')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="secteur_activite" :value="__('Secteur d\'activité')" />
                                <select id="secteur_activite" name="secteur_activite" required class="block w-full px-5 py-3.5 bg-slate-50 border-none rounded-2xl text-base font-medium text-[#2C2C2A] focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner cursor-pointer">
                                    <option value="Construction">🏗️ Construction / BTP</option>
                                    <option value="Informatique">💻 Informatique / Digital</option>
                                    <option value="Services">🤝 Services aux entreprises</option>
                                    <option value="Logistique">🚚 Logistique / Transport</option>
                                </select>
                                <x-input-error :messages="$errors->get('secteur_activite')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="budget_estime" :value="__('Budget Estimé (Optionnel)')" />
                                <x-text-input id="budget_estime" name="budget_estime" type="text" class="block w-full" :value="old('budget_estime')" placeholder="Ex: 50M - 100M GNF" />
                                <x-input-error :messages="$errors->get('budget_estime')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="lieu_execution" :value="__('Lieu d\'exécution')" />
                                <x-text-input id="lieu_execution" name="lieu_execution" type="text" class="block w-full" :value="old('lieu_execution', 'Conakry')" placeholder="Ex: Conakry" />
                                <x-input-error :messages="$errors->get('lieu_execution')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="date_limite" :value="__('Date limite de réponse')" />
                                <x-text-input id="date_limite" name="date_limite" type="date" class="block w-full" :value="old('date_limite')" required />
                                <x-input-error :messages="$errors->get('date_limite')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="description" :value="__('Description détaillée du besoin')" />
                                <textarea id="description" name="description" rows="6" required class="block w-full px-5 py-4 bg-slate-50 border-none rounded-2xl text-base font-medium text-[#2C2C2A] placeholder:text-slate-300 focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner" placeholder="Décrivez précisément votre projet et vos attentes...">{{ old('description') }}</textarea>
                                <x-input-error :messages="$errors->get('description')" class="mt-2" />
                            </div>

                            <div class="md:col-span-2">
                                <x-input-label for="document_cctp" :value="__('Cahier des Charges (CCTP) - PDF, DOC')" />
                                <div class="mt-2 flex items-center justify-center px-6 pt-5 pb-6 border-2 border-slate-100 border-dashed rounded-2xl bg-slate-50 hover:bg-white hover:border-[#0F6E56]/30 transition-all cursor-pointer group/file">
                                    <div class="space-y-1 text-center">
                                        <svg class="mx-auto h-12 w-12 text-slate-300 group-hover/file:text-[#0F6E56] transition-colors" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                                            <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <div class="flex text-sm text-slate-600">
                                            <input id="document_cctp" name="document_cctp" type="file" class="sr-only">
                                            <label for="document_cctp" class="relative cursor-pointer bg-transparent rounded-md font-black text-[#0F6E56] hover:text-[#4E7A1B] focus-within:outline-none">
                                                <span>Cliquez pour télécharger</span>
                                            </label>
                                            <p class="pl-1">ou glissez-déposez</p>
                                        </div>
                                        <p class="text-xs text-slate-400 font-bold uppercase tracking-widest">PDF, DOC jusqu'à 10MB</p>
                                    </div>
                                </div>
                                <x-input-error :messages="$errors->get('document_cctp')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex justify-end pt-8 border-t border-slate-50">
                            <button type="submit" class="px-12 py-4 bg-[#0F6E56] text-white text-[15px] font-black uppercase tracking-widest rounded-2xl shadow-xl shadow-[#0F6E56]/20 hover:bg-[#4E7A1B] hover:-translate-y-1 transition-all">
                                Lancer l'Appel d'Offre
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
