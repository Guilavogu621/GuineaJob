<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ajouter un Nouvel Employeur') }}
            </h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 transition-colors">
                ← Retour au tableau de bord
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 md:p-12">
                    
                    <form method="POST" action="{{ route('admin.store-employer') }}">
                        @csrf

                        <!-- Informations de la personne -->
                        <div class="mb-8">
                            <h3 class="text-lg font-black text-[#0F6E56] mb-6 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informations du Représentant
                            </h3>
                            <div class="grid grid-cols-2 gap-6 mb-6">
                                <div>
                                    <x-input-label for="prenom" :value="__('Prénom')" class="font-bold text-gray-700" />
                                    <x-text-input id="prenom" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-xl shadow-sm" type="text" name="prenom" :value="old('prenom')" required autofocus />
                                    <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="nom" :value="__('Nom')" class="font-bold text-gray-700" />
                                    <x-text-input id="nom" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-xl shadow-sm" type="text" name="nom" :value="old('nom')" required />
                                    <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="email" :value="__('Email Professionnel')" class="font-bold text-gray-700" />
                                <x-text-input id="email" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-xl shadow-sm" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                                <p class="text-xs font-bold text-[#BA7517] mt-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    Un mot de passe sécurisé sera généré automatiquement et envoyé à cette adresse.
                                </p>
                            </div>
                        </div>

                        <!-- Informations de l'entreprise -->
                        <div class="mb-8">
                            <h3 class="text-lg font-black text-[#0F6E56] mb-6 flex items-center gap-2 border-b border-gray-100 pb-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                Détails de l'Entreprise
                            </h3>
                            <div class="mb-6">
                                <x-input-label for="raison_sociale" :value="__('Raison Sociale')" class="font-bold text-gray-700" />
                                <x-text-input id="raison_sociale" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-xl shadow-sm" type="text" name="raison_sociale" :value="old('raison_sociale')" required />
                                <x-input-error :messages="$errors->get('raison_sociale')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="secteur" :value="__('Secteur d\'Activité')" class="font-bold text-gray-700" />
                                <select id="secteur" name="secteur" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-xl shadow-sm" required>
                                    <option value="">-- Sélectionner un secteur --</option>
                                    <option value="Bâtiment & Travaux Publics">Bâtiment & Travaux Publics</option>
                                    <option value="Mines & Énergie">Mines & Énergie</option>
                                    <option value="Agriculture & Élevage">Agriculture & Élevage</option>
                                    <option value="Commerce & Services">Commerce & Services</option>
                                    <option value="Banques & Assurances">Banques & Assurances</option>
                                    <option value="Informatique & Télécoms">Informatique & Télécoms</option>
                                    <option value="Transport & Logistique">Transport & Logistique</option>
                                    <option value="Hôtellerie & Tourisme">Hôtellerie & Tourisme</option>
                                    <option value="Administration Publique">Administration Publique</option>
                                    <option value="Autre">Autre</option>
                                </select>
                                <x-input-error :messages="$errors->get('secteur')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-10 pt-6 border-t border-gray-100">
                            <button type="submit" class="inline-flex items-center px-8 py-4 bg-[#0F6E56] border border-transparent rounded-xl font-black text-sm text-white uppercase tracking-widest hover:bg-[#085041] active:bg-[#085041] focus:outline-none focus:ring-2 focus:ring-[#0F6E56] focus:ring-offset-2 transition ease-in-out duration-150 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                Créer l'entreprise & Envoyer les accès
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path></svg>
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
