<x-app-layout>
    <div class="max-w-3xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-6" x-data="{ typeConge: '{{ old('type_conge', 'annuel') }}' }">
        <div>
            <h1 class="text-xl font-medium text-[#2C2C2A]">Nouvelle demande de congé</h1>
            <p class="text-[15px] text-[#888780] mt-1">Renseignez le type, la période et le motif de votre absence.</p>
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
            <form method="POST" action="{{ route('employee.conges.store') }}" class="space-y-6">
                @csrf

                @php
                    $types = [
                        ['value' => 'annuel', 'label' => 'Annuel', 'desc' => 'Congé payé légal', 'active' => 'border-[#185FA5] bg-[#E6F1FB]/40'],
                        ['value' => 'maladie', 'label' => 'Maladie', 'desc' => 'Certificat médical requis', 'active' => 'border-[#993C1D] bg-[#FCEBEB]/40'],
                        ['value' => 'maternite', 'label' => 'Maternité', 'desc' => '14 semaines (Code du Travail)', 'active' => 'border-[#BA7517] bg-[#FAEEDA]/40'],
                        ['value' => 'paternite', 'label' => 'Paternité', 'desc' => '3 jours ouvrables', 'active' => 'border-[#0F6E56] bg-[#E1F5EE]/40'],
                        ['value' => 'sans_solde', 'label' => 'Sans solde', 'desc' => 'Absence non rémunérée', 'active' => 'border-[#888780] bg-[#F1EFE8]/70'],
                    ];
                @endphp

                <section class="space-y-4">
                    <h2 class="text-base font-medium text-[#2C2C2A]">Type de congé</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        @foreach($types as $type)
                            <label class="flex items-start gap-3 p-4 rounded-xl border cursor-pointer transition-colors"
                                   :class="typeConge === '{{ $type['value'] }}' ? '{{ $type['active'] }}' : 'border-[#D3D1C7]'">
                                <input type="radio" name="type_conge" value="{{ $type['value'] }}" x-model="typeConge" class="mt-0.5" required>
                                <span>
                                    <span class="block text-[15px] font-medium text-[#2C2C2A]">{{ $type['label'] }}</span>
                                    <span class="block text-[15px] text-[#888780] mt-0.5">{{ $type['desc'] }}</span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </section>

                <section class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <x-input-label for="date_debut" :value="__('Date de début')" />
                        <x-text-input id="date_debut" class="block mt-1 w-full" type="date" name="date_debut" :value="old('date_debut')" required />
                        <p class="text-[15px] text-[#888780] mt-1">Premier jour d'absence</p>
                    </div>
                    <div>
                        <x-input-label for="date_fin" :value="__('Date de fin')" />
                        <x-text-input id="date_fin" class="block mt-1 w-full" type="date" name="date_fin" :value="old('date_fin')" required />
                        <p class="text-[15px] text-[#888780] mt-1">Dernier jour d'absence</p>
                    </div>
                </section>

                <section>
                    <x-input-label for="motif" :value="__('Motif')" />
                    <select id="motif" name="motif" required class="block mt-1 w-full">
                        <option value="">Sélectionnez un motif...</option>
                        <option value="Maladie" {{ old('motif') == 'Maladie' ? 'selected' : '' }}>Maladie</option>
                        <option value="Personnel" {{ old('motif') == 'Personnel' ? 'selected' : '' }}>Personnel</option>
                        <option value="Familial" {{ old('motif') == 'Familial' ? 'selected' : '' }}>Familial</option>
                        <option value="Formation" {{ old('motif') == 'Formation' ? 'selected' : '' }}>Formation</option>
                        <option value="Autre" {{ old('motif') == 'Autre' ? 'selected' : '' }}>Autre</option>
                    </select>
                </section>

                <div class="pt-4 border-t border-[#D3D1C7]/70 flex flex-col-reverse sm:flex-row sm:items-center sm:justify-between gap-3">
                    <a href="{{ route('employee.conges.index') }}" class="btn btn-outline btn-md">Annuler</a>
                    <button type="submit" class="btn btn-primary btn-md">Soumettre la demande</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
