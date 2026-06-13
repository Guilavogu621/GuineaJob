<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Déclarer un nouvel employé</h1>
                <p class="text-[15px] text-[#888780] mt-1">Renseignez les informations personnelles et professionnelles.</p>
            </div>
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
            <form method="POST" action="{{ route('employer.employees.store') }}" class="space-y-6">
                @csrf

                <section class="space-y-4">
                    <h2 class="text-base font-medium text-[#2C2C2A]">Informations personnelles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <select id="genre" name="genre" class="block mt-1 w-full" required>
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

                    <div>
                        <x-input-label for="adresse" :value="__('Adresse complète')" />
                        <x-text-input id="adresse" class="block mt-1 w-full" type="text" name="adresse" :value="old('adresse')" required />
                        <x-input-error :messages="$errors->get('adresse')" class="mt-2" />
                    </div>
                </section>

                <section class="space-y-4 pt-2">
                    <h2 class="text-base font-medium text-[#2C2C2A]">Informations professionnelles</h2>
                    <div>
                        <x-input-label for="email" :value="__('Email professionnel')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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
                            <select id="type_contrat" name="type_contrat" class="block mt-1 w-full" required>
                                <option value="CDI" {{ old('type_contrat') == 'CDI' ? 'selected' : '' }}>CDI (Durée indéterminée)</option>
                                <option value="CDD" {{ old('type_contrat') == 'CDD' ? 'selected' : '' }}>CDD (Durée déterminée)</option>
                                <option value="Stage" {{ old('type_contrat') == 'Stage' ? 'selected' : '' }}>Stage / Apprentissage</option>
                                <option value="Prestation" {{ old('type_contrat') == 'Prestation' ? 'selected' : '' }}>Prestation / Freelance</option>
                            </select>
                            <x-input-error :messages="$errors->get('type_contrat')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="salaire_base" :value="__('Salaire de base (GNF)')" />
                            <x-text-input id="salaire_base" class="block mt-1 w-full" type="number" name="salaire_base" :value="old('salaire_base')" required />
                            <x-input-error :messages="$errors->get('salaire_base')" class="mt-2" />
                        </div>
                    </div>
                </section>

                <div class="pt-4 border-t border-[#D3D1C7]/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('employer.employees.index') }}" class="btn btn-outline btn-md">Retour</a>
                    <button type="submit" class="btn btn-primary btn-md">Enregistrer et créer le compte</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
