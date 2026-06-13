<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Page Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Gestion des Salaires</h1>
                <p class="text-[15px] text-[#888780] mt-1">Générez et gérez les fiches de paie de vos collaborateurs.</p>
            </div>
            <a href="{{ route('employer.paie.create') }}" class="btn btn-primary btn-md" style="gap: 6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Générer une fiche
            </a>
        </div>

        {{-- Flash Success --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <span class="text-[15px] font-medium">{{ session('success') }}</span>
            </div>
        @endif

        {{-- Mobile Cards --}}
        <div class="md:hidden space-y-3">
            @forelse($fiches as $fiche)
                @php
                    $avatarColors = ['#0F6E56', '#185FA5', '#BA7517', '#7C3AED', '#993C1D', '#0D9488'];
                    $colorIndex = crc32($fiche->employe->user->full_name) % count($avatarColors);
                    $avatarColor = $avatarColors[abs($colorIndex)];
                @endphp
                <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="flex items-center gap-3">
                        <div class="shrink-0 w-9 h-9 rounded-full flex items-center justify-center text-white text-[15px] font-medium" style="background-color: {{ $avatarColor }};">
                            {{ substr($fiche->employe->user->prenom, 0, 1) }}{{ substr($fiche->employe->user->nom, 0, 1) }}
                        </div>
                        <div>
                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $fiche->employe->user->full_name }}</div>
                            <div class="text-[15px] text-[#888780]">{{ $fiche->mois->translatedFormat('F Y') }}</div>
                        </div>
                    </div>

                    <div class="mt-3 grid grid-cols-2 gap-2 text-[15px]">
                        <div>
                            <div class="text-[#888780]">Brut</div>
                            <div class="text-[#2C2C2A]">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }} GNF</div>
                        </div>
                        <div>
                            <div class="text-[#888780]">Net</div>
                            <div class="text-[#0F6E56]">{{ number_format($fiche->salaire_net, 0, ',', ' ') }} GNF</div>
                        </div>
                        <div>
                            <div class="text-[#888780]">CNSS</div>
                            <div class="text-[#993C1D]">-{{ number_format($fiche->cnss, 0, ',', ' ') }} GNF</div>
                        </div>
                        <div>
                            <div class="text-[#888780]">AGUIPE</div>
                            <div class="text-[#993C1D]">-{{ number_format($fiche->aguipe, 0, ',', ' ') }} GNF</div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <a href="{{ route('employer.paie.download', $fiche) }}" class="btn btn-secondary btn-sm">Télécharger PDF</a>
                    </div>
                </div>
            @empty
                <div class="bg-white rounded-xl p-6 text-center" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <p class="text-[15px] text-[#888780]">Aucune fiche de paie générée.</p>
                </div>
            @endforelse
        </div>

        {{-- Desktop Table --}}
        <div class="table-container hidden md:block">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th style="padding: 10px 18px;">Employé</th>
                            <th style="padding: 10px 18px;">Mois</th>
                            <th style="padding: 10px 18px; text-align: right;">Brut</th>
                            <th style="padding: 10px 18px; text-align: right;">CNSS 5%</th>
                            <th style="padding: 10px 18px; text-align: right;">AGUIPE 1%</th>
                            <th style="padding: 10px 18px; text-align: right;">Net</th>
                            <th style="padding: 10px 18px; text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($fiches as $fiche)
                            <tr>
                                <td style="padding: 12px 18px;">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $avatarColors = ['#0F6E56', '#185FA5', '#BA7517', '#7C3AED', '#993C1D', '#0D9488'];
                                            $colorIndex = crc32($fiche->employe->user->full_name) % count($avatarColors);
                                            $avatarColor = $avatarColors[abs($colorIndex)];
                                        @endphp
                                        <div class="shrink-0 w-8 h-8 rounded-full flex items-center justify-center text-white text-[15px] font-medium" style="background-color: {{ $avatarColor }};">
                                            {{ substr($fiche->employe->user->prenom, 0, 1) }}{{ substr($fiche->employe->user->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $fiche->employe->user->full_name }}</div>
                                            <div class="text-[15px] text-[#888780]">
                                                <span style="background: #E1F5EE; color: #0F6E56; font-family: monospace; font-size: 11px; padding: 1px 5px; border-radius: 4px;">{{ $fiche->employe->numero_matricule }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 12px 18px;">
                                    <span class="text-[15px] text-[#888780]">{{ $fiche->mois->translatedFormat('F Y') }}</span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] font-medium text-[#2C2C2A]">{{ number_format($fiche->salaire_brut, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] text-[#993C1D]">-{{ number_format($fiche->cnss, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] text-[#993C1D]">-{{ number_format($fiche->aguipe, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <span class="text-[15px] font-medium text-[#0F6E56]">{{ number_format($fiche->salaire_net, 0, ',', ' ') }} <span class="text-[15px] text-[#888780]">GNF</span></span>
                                </td>
                                <td style="padding: 12px 18px; text-align: right;">
                                    <a href="{{ route('employer.paie.download', $fiche) }}" class="btn btn-secondary btn-sm" style="gap: 4px;">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        PDF
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucune fiche de paie générée.</p>
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
