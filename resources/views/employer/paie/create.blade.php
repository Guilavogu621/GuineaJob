<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        <div>
            <h1 class="text-xl font-medium text-[#2C2C2A]">Générer une fiche de paie</h1>
            <p class="text-[15px] text-[#888780] mt-1">Sélectionnez un contrat actif et la période de paie.</p>
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
            <form method="POST" action="{{ route('employer.paie.store') }}" class="space-y-6">
                @csrf

                <div class="space-y-4">
                    <div>
                        <x-input-label :value="__('Contrat actif (employé)')" />
                        <select name="contrat_id" required class="block mt-1 w-full">
                            <option value="">— Sélectionner un employé —</option>
                            @foreach($contrats as $contrat)
                                <option value="{{ $contrat->id }}" {{ old('contrat_id') == $contrat->id ? 'selected' : '' }}>
                                    {{ $contrat->employe->user->full_name }} — {{ $contrat->type_contrat }} — {{ number_format($contrat->salaire_mensuel_brut, 0, ',', ' ') }} GNF/mois
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="mois" :value="__('Mois concerné')" />
                            <x-text-input id="mois" class="block mt-1 w-full" type="month" name="mois" :value="old('mois', now()->format('Y-m'))" required />
                        </div>
                        <div>
                            <x-input-label for="autres_deductions" :value="__('Autres déductions (GNF)')" />
                            <x-text-input id="autres_deductions" class="block mt-1 w-full" type="number" name="autres_deductions" :value="old('autres_deductions', 0)" min="0" />
                            <p class="text-[15px] text-[#888780] mt-1">Avances, prêts, retenues diverses.</p>
                        </div>
                    </div>
                </div>

                <div class="bg-[#FAEEDA] rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.08);">
                    <p class="text-[15px] text-[#2C2C2A]">
                        <span class="font-medium">Taux appliqués automatiquement :</span>
                        CNSS 5% du brut, AGUIPE 1% du brut.
                    </p>
                </div>

                <div class="pt-4 border-t border-[#D3D1C7]/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('employer.paie.index') }}" class="btn btn-outline btn-md">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-md">Générer la fiche de paie</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
