<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Espace Entreprise : ') }} {{ $entreprise->raison_sociale ?? 'Non définie' }}
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('employer.employees.create') }}" class="inline-flex items-center px-4 py-2 bg-guinea-gold border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 transition-colors">
                    + Ajouter un Employé
                </a>
                <button class="inline-flex items-center px-4 py-2 bg-guinea-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-guinea-green-light transition-colors">
                    + Nouveau Contrat
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-[#E1F5EE] border-l-4 border-[#0F6E56] text-[#085041]">
                    {{ session('success') }}
                </div>
            @endif

            <!-- Cartes KPI -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold">Contrats actifs</p>
                    <p class="text-3xl font-bold text-[#0F6E56]">0</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold">Masse Salariale</p>
                    <p class="text-3xl font-bold text-gray-800">0 GNf</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold">Congés en attente</p>
                    <p class="text-3xl font-bold text-[#BA7517]">0</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm text-gray-500 uppercase font-bold">Candidatures</p>
                    <p class="text-3xl font-bold text-blue-600">0</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Derniers contrats générés</h3>
                    <div class="text-center py-10 text-gray-400 italic">
                        Vous n'avez pas encore généré de contrat. Commencez par en créer un !
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
