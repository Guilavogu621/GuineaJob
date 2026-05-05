<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Déclarer un nouvel employé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-8">
                    <form method="POST" action="{{ route('employer.employees.store') }}">
                        @csrf

                        <!-- Section 1: Informations Personnelles -->
                        <div class="mb-8 border-b pb-6">
                            <h3 class="text-lg font-bold text-guinea-green mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                Informations Personnelles
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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
                                <div>
                                    <x-input-label for="date_naissance" :value="__('Date de naissance')" />
                                    <x-text-input id="date_naissance" class="block mt-1 w-full" type="date" name="date_naissance" :value="old('date_naissance')" required />
                                    <x-input-error :messages="$errors->get('date_naissance')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="lieu_naissance" :value="__('Lieu de naissance')" />
                                    <x-text-input id="lieu_naissance" class="block mt-1 w-full" type="text" name="lieu_naissance" :value="old('lieu_naissance')" required />
                                    <x-input-error :messages="$errors->get('lieu_naissance')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="genre" :value="__('Genre')" />
                                    <select id="genre" name="genre" class="block mt-1 w-full border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-md shadow-sm">
                                        <option value="Masculin" {{ old('genre') == 'Masculin' ? 'selected' : '' }}>Masculin</option>
                                        <option value="Féminin" {{ old('genre') == 'Féminin' ? 'selected' : '' }}>Féminin</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('genre')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="telephone" :value="__('Téléphone')" />
                                    <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone')" required />
                                    <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                                </div>
                            </div>
                            <div class="mt-6">
                                <x-input-label for="adresse" :value="__('Adresse complète')" />
                                <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse')" required />
                                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                            </div>
                        </div>

                        <!-- Section 2: Informations Professionnelles -->
                        <div class="mb-8 border-b pb-6">
                            <h3 class="text-lg font-bold text-guinea-gold mb-4 flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                Informations Professionnelles
                            </h3>
                            <div class="mt-6">
                                <x-input-label for="email" :value="__('Email professionnel')" />
                                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                                <x-input-error :messages="$errors->get('email')" class="mt-2" />
                            </div>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                                <div>
                                    <x-input-label for="poste" :value="__('Poste occupé')" />
                                    <x-text-input id="poste" class="block mt-1 w-full" type="text" name="poste" :value="old('poste')" required />
                                    <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="date_embauche" :value="__('Date d\'embauche')" />
                                    <x-text-input id="date_embauche" class="block mt-1 w-full" type="date" name="date_embauche" :value="old('date_embauche')" required />
                                    <x-input-error :messages="$errors->get('date_embauche')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="type_contrat" :value="__('Type de contrat')" />
                                    <select id="type_contrat" name="type_contrat" class="block mt-1 w-full border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-md shadow-sm">
                                        <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI (Durée indéterminée)</option>
                                        <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD (Durée déterminée)</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('type_contrat')" class="mt-2" />
                                </div>
                                <div>
                                    <x-input-label for="salaire_base" :value="__('Salaire de base (GNF)')" />
                                    <x-text-input id="salaire_base" class="block mt-1 w-full font-mono" type="number" name="salaire_base" :value="old('salaire_base')" required />
                                    <x-input-error :messages="$errors->get('salaire_base')" class="mt-2" />
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-between mt-10 pt-6">
                            <a href="{{ route('employer.employees.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline font-medium">
                                ← Retour à la liste
                            </a>
                            <x-primary-button class="bg-guinea-green hover:bg-guinea-green-light py-3 px-8 text-lg">
                                {{ __('Enregistrer et Créer le compte') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
