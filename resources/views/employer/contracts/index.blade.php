<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Mes Contrats de Travail') }}
            </h2>
            <a href="{{ route('employer.contracts.create') }}" class="inline-flex items-center px-4 py-2 bg-guinea-gold border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-orange-700 transition-colors">
                + Nouveau Contrat
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="mb-4 p-4 bg-[#E1F5EE] border-l-4 border-[#0F6E56] text-[#085041] rounded-md">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl border border-gray-100">
                <div class="p-8">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">N° Contrat</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Employé</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Date Début</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Salaire Brut</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Statut</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-widest">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($contracts as $contract)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap font-mono text-xs font-bold text-gray-900">
                                            {{ $contract->numero_contrat }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-900">{{ $contract->employe->user->full_name }}</div>
                                            <div class="text-xs text-gray-500">{{ $contract->employe->poste }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 py-1 text-xs font-bold rounded bg-gray-100 text-gray-800">
                                                {{ $contract->type_contrat }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600">
                                            {{ \Carbon\Carbon::parse($contract->date_debut)->format('d/m/Y') }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                            {{ number_format($contract->salaire_mensuel_brut, 0, ',', ' ') }} GNF
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @php
                                                $statusClasses = [
                                                    \App\Models\Contrat::STATUS_DRAFT => 'bg-gray-100 text-gray-600',
                                                    \App\Models\Contrat::STATUS_SENT => 'bg-blue-100 text-blue-700',
                                                    \App\Models\Contrat::STATUS_SIGNED_EMPLOYER => 'bg-orange-100 text-orange-700',
                                                    \App\Models\Contrat::STATUS_ACTIVE => 'bg-guinea-green/20 text-guinea-green',
                                                ];
                                                $class = $statusClasses[$contract->statut] ?? 'bg-gray-100 text-gray-800';
                                            @endphp
                                            <span class="px-3 py-1 inline-flex text-xs leading-5 font-bold rounded-full {{ $class }}">
                                                {{ $contract->statut }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm flex items-center gap-3">
                                            @if(trim($contract->statut) === 'Brouillon')
                                                <form action="{{ route('employer.contracts.send', $contract) }}" method="POST">
                                                    @csrf
                                                    <button class="bg-[#0F6E56] text-white px-4 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-[#085041] transition-all shadow-md flex items-center gap-2">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
                                                        Envoyer
                                                    </button>
                                                </form>
                                            @endif
                                            
                                            @if(trim($contract->statut) === 'Envoyé')
                                                <form action="{{ route('employer.contracts.sign', $contract) }}" method="POST">
                                                    @csrf
                                                    <button class="bg-[#D4AF37] text-white px-4 py-2 rounded-xl font-black text-[10px] uppercase tracking-widest hover:bg-orange-600 transition-all shadow-md flex items-center gap-2">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                        Signer
                                                    </button>
                                                </form>
                                            @endif

                                            <button class="text-[#0F6E56] hover:text-[#D4AF37] font-black text-[11px] uppercase tracking-tighter transition-colors">
                                                Détails
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center text-gray-500 italic">
                                            Aucun contrat généré pour le moment.
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
