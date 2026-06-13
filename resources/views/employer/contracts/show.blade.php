<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Signature du Contrat') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 min-h-screen">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-2xl rounded-3xl overflow-hidden border border-gray-200">
                <!-- Header Document -->
                <div class="p-10 bg-[#0F6E56] text-white text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-4 opacity-10">
                        <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M13 2H6c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V9l-7-7zM6 20V4h6v5h5v11H6z"/></svg>
                    </div>
                    <div class="uppercase tracking-[0.4em] text-[15px] font-black mb-2 opacity-80">République de Guinée</div>
                    <h1 class="text-3xl font-black tracking-tighter mb-1">CONTRAT DE TRAVAIL</h1>
                    <p class="text-xs font-mono opacity-60">N° {{ $contract->numero_contrat }} — {{ strtoupper($contract->type_contrat) }}</p>
                </div>

                <div class="p-8 md:p-12">
                    <!-- Section Parties -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-0 border border-gray-200 rounded-2xl overflow-hidden mb-12">
                        <div class="p-6 border-r border-gray-200 bg-gray-50">
                            <h4 class="text-[9px] font-black text-guinea-gold uppercase mb-3 tracking-widest">L'Employeur</h4>
                            <div class="font-black text-gray-900 text-lg leading-tight">{{ $contract->entreprise->raison_sociale }}</div>
                            <div class="text-[15px] text-gray-500 mt-1 uppercase">{{ $contract->entreprise->adresse }}</div>
                        </div>
                        <div class="p-6 bg-white">
                            <h4 class="text-[9px] font-black text-guinea-gold uppercase mb-3 tracking-widest">L'Employé</h4>
                            <div class="font-black text-gray-900 text-lg leading-tight">{{ $contract->employe->user->full_name }}</div>
                            <div class="text-[15px] text-gray-500 mt-1 uppercase">{{ $contract->employe->poste }} — MATRICULE : {{ $contract->employe->numero_matricule }}</div>
                        </div>
                    </div>

                    <!-- Section Détails -->
                    <div class="space-y-8">
                        <div>
                            <h3 class="flex items-center gap-3 text-sm font-black text-gray-900 uppercase tracking-widest mb-4">
                                <span class="w-6 h-6 bg-guinea-gold text-white rounded flex items-center justify-center text-[15px]">01</span>
                                Engagement & Durée
                            </h3>
                            <table class="design-table">
                                <tr class="bg-gray-50">
                                    <td class="p-4 border border-gray-100 text-[15px] font-black text-gray-400 uppercase w-1/3">Date d'effet</td>
                                    <td class="p-4 border border-gray-100 text-sm font-bold text-gray-900">{{ $contract->date_debut->format('d/m/Y') }}</td>
                                </tr>
                                @if($contract->date_fin)
                                <tr>
                                    <td class="p-4 border border-gray-100 text-[15px] font-black text-gray-400 uppercase">Échéance du contrat</td>
                                    <td class="p-4 border border-gray-100 text-sm font-bold text-gray-900">{{ $contract->date_fin->format('d/m/Y') }}</td>
                                </tr>
                                @endif
                                <tr class="bg-gray-50">
                                    <td class="p-4 border border-gray-100 text-[15px] font-black text-gray-400 uppercase">Période d'essai</td>
                                    <td class="p-4 border border-gray-100 text-sm font-bold text-gray-900">{{ $contract->periode_essai ?? 'Aucune' }}</td>
                                </tr>
                            </table>
                        </div>

                        <div>
                            <h3 class="flex items-center gap-3 text-sm font-black text-gray-900 uppercase tracking-widest mb-4">
                                <span class="w-6 h-6 bg-guinea-gold text-white rounded flex items-center justify-center text-[15px]">02</span>
                                Rémunération
                            </h3>
                            <div class="p-8 bg-gray-900 rounded-2xl shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 border-b-4 border-guinea-gold">
                                <div class="text-center md:text-left">
                                    <div class="text-[9px] text-gray-400 font-black uppercase mb-1 tracking-widest">Salaire de base</div>
                                    <div class="text-4xl font-black text-guinea-gold">{{ number_format($contract->salaire_mensuel_brut, 0, ',', ' ') }} <span class="text-sm font-normal text-gray-400">GNF/Mois</span></div>
                                </div>
                                @if($contract->avantages)
                                    <div class="flex flex-wrap justify-center gap-2">
                                        @foreach($contract->avantages as $avantage)
                                            <span class="px-3 py-1 bg-white/10 rounded text-[9px] font-black text-white uppercase border border-white/10 tracking-tighter">{{ $avantage }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>

                        @if($contract->clauses_specifiques)
                        <div>
                            <h3 class="flex items-center gap-3 text-sm font-black text-gray-900 uppercase tracking-widest mb-4">
                                <span class="w-6 h-6 bg-guinea-gold text-white rounded flex items-center justify-center text-[15px]">03</span>
                                Clauses Particulières
                            </h3>
                            <div class="p-6 bg-gray-50 border-l-4 border-guinea-green rounded-r-2xl text-sm text-gray-700 leading-relaxed italic whitespace-pre-line">
                                {{ $contract->clauses_specifiques }}
                            </div>
                        </div>
                        @endif
                    </div>

                    <!-- Signature Section -->
                    <div class="mt-16 pt-10 border-t-2 border-dashed border-gray-100">
                        <div class="flex flex-col md:flex-row justify-between gap-10 items-end">
                            <div class="flex-1 space-y-4">
                                <h5 class="text-[9px] font-black text-gray-400 uppercase tracking-widest">Certifications de l'Employeur</h5>
                                <p class="text-[15px] text-gray-500 leading-relaxed italic">
                                    En tant qu'employeur, vous certifiez que les informations ci-dessus sont exactes et conformes à la réglementation en vigueur en République de Guinée.
                                </p>
                            </div>

                            <div class="flex-1 w-full flex flex-col items-end gap-4">
                                @if(in_array($contract->statut, [\App\Models\Contrat::STATUS_DRAFT, \App\Models\Contrat::STATUS_SENT]))
                                    <form id="sign-form" action="{{ route('employer.contracts.sign', $contract) }}" method="POST" class="w-full flex flex-col items-end gap-4">
                                        @csrf
                                        <label class="flex items-center gap-3 cursor-pointer select-none">
                                            <input
                                                type="checkbox"
                                                id="accept-checkbox"
                                                onchange="document.getElementById('sign-btn').disabled = !this.checked; document.getElementById('sign-btn').classList.toggle('bg-gray-300', !this.checked); document.getElementById('sign-btn').classList.toggle('bg-[#0F6E56]', this.checked); document.getElementById('sign-btn').classList.toggle('hover:bg-[#0A5A45]', this.checked); document.getElementById('sign-btn').classList.toggle('shadow-2xl', this.checked);"
                                                class="w-5 h-5 accent-[#0F6E56] border-gray-300 rounded"
                                            >
                                            <span class="text-[15px] text-gray-500 font-black uppercase tracking-tighter italic">Je valide et je signe ce contrat</span>
                                        </label>
                                        <button
                                            type="submit"
                                            id="sign-btn"
                                            disabled
                                            class="w-full text-white px-8 py-4 rounded-xl font-black text-xs uppercase tracking-widest transition-all bg-gray-300 cursor-not-allowed">
                                            VALIDER &amp; SIGNER LE CONTRAT 🖋️
                                        </button>
                                        <p class="text-xs text-gray-500 text-right w-full">Cochez la case ci-dessus pour activer la signature.</p>
                                    </form>
                                @elseif($contract->isSignedByEmployer())
                                    <div class="px-8 py-3 bg-[#0F6E56] text-white font-black text-[15px] uppercase tracking-widest rounded-xl shadow-lg flex items-center gap-3">
                                        <svg class="w-5 h-5 text-guinea-gold" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        Déjà signé par vous
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
