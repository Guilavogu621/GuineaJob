<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Modifier l\'employé : ') }} {{ $employe->numero_matricule }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-2xl sm:rounded-3xl border border-gray-100">
                <div class="p-8 md:p-12">
                    <form method="POST" action="{{ route('employer.employees.update', $employe) }}">
                        @csrf
                        
                        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Informations Personnelles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <x-input-label for="nom" :value="__('Nom')" />
                                <x-text-input id="nom" class="block mt-1 w-full" type="text" name="nom" :value="old('nom', $employe->user->nom)" required autofocus />
                                <x-input-error :messages="$errors->get('nom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="prenom" :value="__('Prénom')" />
                                <x-text-input id="prenom" class="block mt-1 w-full" type="text" name="prenom" :value="old('prenom', $employe->user->prenom)" required />
                                <x-input-error :messages="$errors->get('prenom')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="telephone" :value="__('Téléphone')" />
                                <x-text-input id="telephone" class="block mt-1 w-full" type="text" name="telephone" :value="old('telephone', $employe->telephone)" required />
                                <x-input-error :messages="$errors->get('telephone')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="adresse" :value="__('Adresse')" />
                                <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse', $employe->adresse)" required />
                                <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                            </div>
                        </div>

                        <h3 class="text-2xl font-bold text-gray-900 mb-6 border-b pb-4">Informations Professionnelles</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
                            <div>
                                <x-input-label for="poste" :value="__('Poste occupé')" />
                                <x-text-input id="poste" class="block mt-1 w-full" type="text" name="poste" :value="old('poste', $employe->poste)" required />
                                <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                            </div>
                            <div>
                                <x-input-label for="type_contrat" :value="__('Type de contrat initial')" />
                                <select id="type_contrat" name="type_contrat" class="border-gray-300 focus:border-guinea-green focus:ring-guinea-green rounded-md shadow-sm block mt-1 w-full" required>
                                    <option value="CDI" {{ $employe->type_contrat == 'CDI' ? 'selected' : '' }}>CDI</option>
                                    <option value="CDD" {{ $employe->type_contrat == 'CDD' ? 'selected' : '' }}>CDD</option>
                                </select>
                                <x-input-error :messages="$errors->get('type_contrat')" class="mt-2" />
                            </div>
                            <div class="md:col-span-2">
                                <x-input-label for="salaire_base" :value="__('Salaire de base (GNF)')" />
                                <x-text-input id="salaire_base" class="block mt-1 w-full" type="number" name="salaire_base" :value="old('salaire_base', $employe->salaire_base)" required />
                                <x-input-error :messages="$errors->get('salaire_base')" class="mt-2" />
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-8 border-t pt-6">
                            <a href="{{ route('employer.employees.index') }}" class="text-gray-500 font-bold mr-6">Annuler</a>
                            <x-primary-button class="bg-guinea-user hover:bg-indigo-800 px-8 py-3">
                                {{ __('Mettre à jour l\'employé') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
