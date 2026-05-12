<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Ajouter un Nouvel Employeur') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    <form method="POST" action="{{ route('admin.store-employer') }}">
                        @csrf

                        <!-- Informations de la personne -->
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <x-input-label for="prenom" :value="__('Prénom')" />
                                <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom')" required autofocus />
                                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="nom" :value="__('Nom')" />
                                <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom')" required />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                        </div>

                        <div class="mb-6">
                            <x-input-label for="email" :value="__('Email Professionnel')" />
                            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            <p class="text-xs text-gray-500 mt-1 italic">Un email de bienvenue avec un mot de passe temporaire sera envoyé à cette adresse.</p>
                        </div>

                        <hr class="my-6 border-gray-100">

                        <!-- Informations de l'entreprise -->
                        <div class="mb-6">
                            <x-input-label for="raison_sociale" :value="__('Raison Sociale (Nom de l\'entreprise)')" />
                            <x-text-input id="raison_sociale" class="block mt-1 w-full" type="text" name="raison_sociale" :value="old('raison_sociale')" required />
                            <x-input-error :messages="$errors->get('raison_sociale')" class="mt-2" />
                        </div>

                        <div class="mb-6">
                            <x-input-label for="secteur" :value="__('Secteur d\'Activité')" />
                            <select id="secteur" name="secteur" class="block mt-1 w-full border-gray-300 focus:border-[#0F6E56] focus:ring-[#0F6E56] rounded-md shadow-sm">
                                <option value="">-- Sélectionner un secteur --</option>
                                <option value="Bâtiment & Travaux Publics">Bâtiment & Travaux Publics</option>
                                <option value="Mines & Énergie">Mines & Énergie</option>
                                <option value="Agriculture & Élevage">Agriculture & Élevage</option>
                                <option value="Commerce & Services">Commerce & Services</option>
                                <option value="Banques & Assurances">Banques & Assurances</option>
                                <option value="Informatique & Télécoms">Informatique & Télécoms</option>
                                <option value="Transport & Logistique">Transport & Logistique</option>
                                <option value="Hôtellerie & Tourisme">Hôtellerie & Tourisme</option>
                            </select>
                            <x-input-error :messages="$errors->get('secteur')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="mr-4 text-gray-600 hover:underline">Annuler</a>
                            <x-primary-button class="bg-[#0F6E56] hover:bg-[#085041]">
                                {{ __('Créer le compte Employeur') }}
                            </x-primary-button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
