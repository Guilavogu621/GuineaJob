<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        <div>
            <h1 class="text-xl font-medium text-[#2C2C2A]">Modifier l'employé</h1>
            <p class="text-[15px] text-[#888780] mt-1">Matricule : {{ $employe->numero_matricule }}</p>
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
            <form method="POST" action="{{ route('employer.employees.update', $employe) }}" class="space-y-6">
                @csrf
                @method('PUT')

                <section class="space-y-4">
                    <h2 class="text-base font-medium text-[#2C2C2A]">Informations personnelles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                </section>

                <section class="space-y-4 pt-2">
                    <h2 class="text-base font-medium text-[#2C2C2A]">Informations professionnelles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="poste" :value="__('Poste occupé')" />
                            <x-text-input id="poste" class="block mt-1 w-full" type="text" name="poste" :value="old('poste', $employe->poste)" required />
                            <x-input-error :messages="$errors->get('poste')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="type_contrat" :value="__('Type de contrat initial')" />
                            <select id="type_contrat" name="type_contrat" class="block mt-1 w-full" required>
                                <option value="CDI" {{ $employe->type_contrat == 'CDI' ? 'selected' : '' }}>CDI</option>
                                <option value="CDD" {{ $employe->type_contrat == 'CDD' ? 'selected' : '' }}>CDD</option>
                                <option value="Stage" {{ $employe->type_contrat == 'Stage' ? 'selected' : '' }}>Stage</option>
                                <option value="Prestation" {{ $employe->type_contrat == 'Prestation' ? 'selected' : '' }}>Prestation</option>
                            </select>
                            <x-input-error :messages="$errors->get('type_contrat')" class="mt-2" />
                        </div>
                        <div class="md:col-span-2">
                            <x-input-label for="salaire_base" :value="__('Salaire de base (GNF)')" />
                            <x-text-input id="salaire_base" class="block mt-1 w-full" type="number" name="salaire_base" :value="old('salaire_base', $employe->salaire_base)" required />
                            <x-input-error :messages="$errors->get('salaire_base')" class="mt-2" />
                        </div>
                    </div>
                </section>

                <div class="pt-4 border-t border-[#D3D1C7]/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('employer.employees.index') }}" class="btn btn-outline btn-md">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-md">Mettre à jour l'employé</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
