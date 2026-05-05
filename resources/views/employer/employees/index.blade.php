<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Gestion des Employés') }}
            </h2>
            <a href="{{ route('employer.employees.create') }}" class="inline-flex items-center px-4 py-2 bg-guinea-green border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-guinea-green-light">
                + Déclarer un employé
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-6 p-4 bg-guinea-green-pale border-l-4 border-guinea-green text-guinea-green">
                    <p class="font-bold">{{ session('success') }}</p>
                    @if(session('temp_password'))
                        <div class="mt-2 p-3 bg-white rounded border border-guinea-green">
                            <p class="text-sm">Identifiants à transmettre à l'employé :</p>
                            <p class="font-mono font-bold mt-1">Email : {{ session('new_employee_email') }}</p>
                            <p class="font-mono font-bold">Mot de passe : <span class="text-guinea-red">{{ session('temp_password') }}</span></p>
                            <p class="text-xs text-gray-500 mt-2 italic">Note : Ce mot de passe ne sera plus affiché. Veuillez le copier maintenant.</p>
                        </div>
                    @endif
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg border border-gray-100">
                <div class="p-6">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Matricule</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Employé</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Poste</th>
                                <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date d'embauche</th>
                                <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($employees as $employee)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap font-mono text-sm text-guinea-green font-bold">
                                        {{ $employee->numero_matricule }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="flex-shrink-0 h-10 w-10 bg-guinea-green-pale rounded-full flex items-center justify-center text-guinea-green font-bold uppercase">
                                                {{ substr($employee->user->prenom, 0, 1) }}{{ substr($employee->user->nom, 0, 1) }}
                                            </div>
                                            <div class="ml-4">
                                                <div class="text-sm font-medium text-gray-900">{{ $employee->user->full_name }}</div>
                                                <div class="text-sm text-gray-500">{{ $employee->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $employee->poste }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                        {{ $employee->date_embauche }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <a href="#" class="text-guinea-gold hover:text-orange-700">Modifier</a>
                                        <span class="mx-2 text-gray-300">|</span>
                                        <a href="#" class="text-guinea-green hover:text-green-800 font-bold">Voir contrat</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-10 text-center text-gray-400 italic">
                                        Aucun employé déclaré pour le moment.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
