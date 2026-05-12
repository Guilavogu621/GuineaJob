<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tableau de Bord Administrateur') }}
            </h2>
            <a href="{{ route('admin.create-employer') }}" class="inline-flex items-center px-4 py-2 bg-[#0F6E56] border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-[#085041] focus:bg-[#085041] active:bg-[#085041] focus:outline-none focus:ring-2 focus:ring-[#0F6E56] focus:ring-offset-2 transition ease-in-out duration-150">
                + Ajouter un Employeur
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <!-- Statistiques globales (KPI) - Section 7.2 du CDC -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Entreprises</p>
                    <p class="text-3xl font-bold text-guinea-green mt-2">{{ \App\Models\Entreprise::count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Total Employés</p>
                    <p class="text-3xl font-bold text-guinea-gold mt-2">{{ \App\Models\Employe::count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Contrats du mois</p>
                    <p class="text-3xl font-bold text-guinea-red mt-2">0</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-100">
                    <p class="text-sm font-medium text-gray-500 uppercase tracking-wider">Masse Salariale</p>
                    <p class="text-3xl font-bold text-gray-900 mt-2">0 <span class="text-sm font-normal">GNF</span></p>
                </div>
            </div>

            @if(session('success'))
                <div class="mb-4 p-4 bg-[#E1F5EE] border-l-4 border-[#0F6E56] text-[#085041]">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium mb-4">Liste des Entreprises / Employeurs</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Raison Sociale</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Gestionnaire</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Secteur</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($entreprises as $entreprise)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-900">{{ $entreprise->raison_sociale }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $entreprise->user->full_name }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $entreprise->secteur }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-gray-600">{{ $entreprise->user->email }}</td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                                            <button class="text-[#BA7517] hover:underline">Gérer</button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-10 text-center text-gray-500 italic">
                                            Aucune entreprise enregistrée pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
