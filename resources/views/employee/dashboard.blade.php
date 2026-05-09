<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Mon Espace Employé') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Message de Bienvenue -->
            <div class="bg-white p-8 rounded-xl shadow-sm border border-gray-100 mb-8">
                <div class="flex items-center gap-6">
                    <div class="w-20 h-20 rounded-full bg-guinea-green flex items-center justify-center text-white text-3xl font-bold uppercase">
                        {{ substr($user->prenom, 0, 1) }}{{ substr($user->nom, 0, 1) }}
                    </div>
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Bonjour, {{ $user->prenom }} !</h1>
                        <p class="text-gray-600 mt-1">Bienvenue sur votre espace personnel GuinéaJob.</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Bloc Contrat -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-guinea-green mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        Mon Contrat de Travail
                    </h3>
                    <div class="space-y-3">
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Poste actuel</span>
                            <span class="font-medium text-gray-900">{{ $employe->poste ?? 'Non renseigné' }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Type de contrat</span>
                            <span class="px-2 py-1 bg-guinea-green-pale text-guinea-green text-xs font-bold rounded">CDI</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Date d'embauche</span>
                            <span class="font-medium text-gray-900">{{ $employe->date_embauche ?? 'Non renseignée' }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-500">Matricule</span>
                            <span class="font-mono text-gray-900">{{ $employe->numero_matricule ?? '---' }}</span>
                        </div>
                    </div>
                    <a href="{{ route('employee.contract.show') }}" class="block w-full mt-6 py-3 bg-guinea-green text-white rounded-lg font-bold text-center hover:bg-guinea-green-light transition-colors shadow-lg">
                        Consulter mon contrat
                    </a>
                </div>

                <!-- Bloc Documents & Bulletins -->
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <h3 class="text-lg font-bold text-guinea-gold mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Mes Derniers Bulletins de Paie
                    </h3>
                    <div class="text-center py-10 text-gray-400 italic">
                        Aucun bulletin de paie disponible pour le moment.
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
