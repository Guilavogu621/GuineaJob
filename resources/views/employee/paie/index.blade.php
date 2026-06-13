<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Mes Bulletins de Paie</h1>
                <p class="text-[15px] text-[#888780] mt-1">Consultez et téléchargez vos fiches de paie mensuelles.</p>
            </div>
        </div>

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($fiches as $fiche)
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-start justify-between gap-2">
                        <div>
                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $fiche->mois->translatedFormat('F Y') }}</div>
                            <div class="text-[15px] text-[#888780]">{{ $fiche->contrat->type_contrat }}</div>
                        </div>
                        <span class="badge badge-active">Généré</span>
                    </div>

                    <div class="mt-3 text-[15px] text-[#2C2C2A]">
                        <div><span class="text-[#888780]">Contrat:</span> {{ $fiche->contrat->numero_contrat }}</div>
                        <div class="mt-1"><span class="text-[#888780]">Brut:</span> {{ number_format($fiche->salaire_brut, 0, ',', ' ') }} GNF</div>
                        <div class="mt-1"><span class="text-[#888780]">Net:</span> <span class="text-[#0F6E56]">{{ number_format($fiche->salaire_net, 0, ',', ' ') }} GNF</span></div>
                    </div>

                    <div class="mt-3">
                        <a href="{{ route('employee.paie.download', $fiche) }}" class="btn btn-secondary btn-sm">Télécharger PDF</a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucun bulletin de paie disponible.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px;">Mois</th>
                            <th style="padding: 10px 18px;">Contrat</th>
                            <th style="padding: 10px 18px; text-align: right;">Salaire brut</th>
                            <th style="padding: 10px 18px; text-align: right;">Salaire net</th>
                            <th style="padding: 10px 18px; text-align: right;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fiches as $fiche)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ $fiche->mois->translatedFormat('F Y') }}</span>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $fiche->contrat->type_contrat }}</div>
                                    <div class="text-[15px] text-[#888780] mt-0.5">
                                        N° <span style="background: #E1F5EE; color: #0F6E56; font-family: monospace; font-size: 11px; padding: 1px 5px; border-radius: 4px;">{{ $fiche->contrat->numero_contrat }}</span>
                                    </div>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] font-medium text-[#0F6E56]">{{ number_format($fiche->salaire_net, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <a href="{{ route('employee.paie.download', $fiche) }}" class="btn btn-secondary btn-sm" style="gap: 4px;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucun bulletin de paie disponible.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
