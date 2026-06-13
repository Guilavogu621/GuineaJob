<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header Area matching prototype --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl font-bold text-[#2C2C2A]">Tableau de bord</h1>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <span class="text-sm font-medium text-[#2C2C2A]">{{ now()->translatedFormat('d F, Y') }}</span>
                <a href="{{ route('employee.conges.create') }}" class="btn btn-primary btn-md">Demander un congé</a>
            </div>
        </div>

        {{-- Top KPI Row (3 columns) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6">
            {{-- KPI 1: Solde Congés --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 bg-[#F1EFE8] px-2 py-1 rounded text-xs font-medium text-[#2C2C2A]">
                        Dispo
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $soldeConges }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Solde de congés</div>
                </div>
            </div>

            {{-- KPI 2: Salaire Actuel --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex items-center gap-1 bg-[#F1EFE8] px-2 py-1 rounded text-xs font-medium text-[#2C2C2A]">
                        GNF
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">
                        @if($derniersBulletins->count() > 0)
                            {{ number_format($derniersBulletins->first()->salaire_net, 0, ',', ' ') }}
                        @else
                            ---
                        @endif
                    </div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Dernier salaire net</div>
                </div>
            </div>

            {{-- KPI 3: Congés Utilisés --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div class="flex -space-x-2">
                        <div class="w-6 h-6 rounded-full border-2 border-white bg-[#0F6E56] text-white flex items-center justify-center text-[10px] font-medium">C</div>
                        <div class="w-6 h-6 rounded-full border-2 border-white bg-[#185FA5] text-white flex items-center justify-center text-[10px] font-medium">P</div>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $joursUtilises }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Congés utilisés</div>
                </div>
            </div>
        </div>

        {{-- Middle Row (2 charts) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Chart 1 --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <h3 class="text-lg font-medium text-[#2C2C2A] mb-6">Évolution du salaire net</h3>
                <div class="flex items-center h-64">
                    <div class="w-full relative h-full flex items-center justify-center">
                        @if(count($historiqueSalaires) > 0)
                            <canvas id="salaryEvolutionChart"></canvas>
                        @else
                            <div class="text-[#888780] text-sm">Aucune courbe disponible</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Chart 2 --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <h3 class="text-lg font-medium text-[#2C2C2A] mb-6">Consommation des congés</h3>
                <div class="flex items-center h-64">
                    <div class="w-full relative h-full flex items-center justify-center">
                        @if($joursAcquis > 0)
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2">
                                <span class="text-3xl font-medium text-[#2C2C2A]">{{ $joursAcquis }}</span>
                                <span class="text-xs text-[#888780] font-medium uppercase mt-1">Total</span>
                            </div>
                            <canvas id="congesChart"></canvas>
                        @else
                            <div class="text-[#888780] text-sm">Pas de congés</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Row (Table/List) --}}
        <div class="table-container bg-white mt-8">
            <div class="p-5 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4" style="border-bottom: 0.5px solid rgba(0,0,0,0.08);">
                <h3 class="text-lg font-medium text-[#2C2C2A]">Mes récents bulletins de paie</h3>
                <a href="{{ route('employee.paie.index') }}" class="text-sm text-[#0F6E56] hover:underline font-medium">Afficher tout l'historique</a>
            </div>

            <div class="md:hidden px-5 pb-5 space-y-3">
                @forelse($derniersBulletins as $bulletin)
                    <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.08);">
                        <div class="flex items-center justify-between gap-2">
                            <div>
                                <div class="text-[15px] font-medium text-[#2C2C2A] capitalize">{{ $bulletin->mois->translatedFormat('F Y') }}</div>
                                <div class="text-[15px] text-[#888780]">Réf: BUL-{{ str_pad($bulletin->id, 5, '0', STR_PAD_LEFT) }}</div>
                            </div>
                            <span class="badge badge-active">Généré</span>
                        </div>
                        <div class="mt-3 text-[15px] text-[#2C2C2A]">
                            <span class="text-[#888780]">Net:</span> {{ number_format($bulletin->salaire_net, 0, ',', ' ') }} GNF
                        </div>
                        <div class="mt-3">
                            <a href="{{ route('employee.paie.download', $bulletin) }}" class="btn btn-secondary btn-sm">Télécharger</a>
                        </div>
                    </div>
                @empty
                    <div class="py-6 text-center">
                        <p class="text-sm text-[#888780]">Aucun bulletin généré.</p>
                    </div>
                @endforelse
            </div>

            <div class="overflow-x-auto hidden md:block">
                <table class="design-table w-full text-left">
                    <thead>
                        <tr>
                            <th class="text-sm">Mois concerné</th>
                            <th class="text-sm">Montant Net (GNF)</th>
                            <th class="text-sm">Statut</th>
                            <th class="text-right text-sm">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($derniersBulletins as $bulletin)
                            <tr class="hover:bg-[#F1EFE8] transition-colors border-b" style="border-bottom-color: rgba(0,0,0,0.06);">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        <div class="shrink-0 w-9 h-9 rounded-lg flex items-center justify-center text-[#185FA5] bg-[#E6F1FB]">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                        </div>
                                        <div>
                                            <div class="text-base font-medium text-[#2C2C2A] capitalize">{{ $bulletin->mois->translatedFormat('F Y') }}</div>
                                            <div class="text-sm text-[#888780]">Réf: BUL-{{ str_pad($bulletin->id, 5, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="text-base font-medium text-[#2C2C2A]">{{ number_format($bulletin->salaire_net, 0, ',', ' ') }}</span>
                                </td>
                                <td class="p-4">
                                    <span class="badge badge-active">Généré</span>
                                </td>
                                <td class="p-4 text-right">
                                    <a href="{{ route('employee.paie.download', $bulletin) }}" class="inline-flex items-center justify-center w-9 h-9 rounded-lg text-[#888780] hover:text-[#0F6E56] hover:bg-[#E1F5EE] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.08);">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                        <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <p class="text-sm text-[#888780]">Aucun bulletin généré.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Chart.js Scripts --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Chart.register(ChartDataLabels);
            Chart.defaults.font.family = "'Inter', sans-serif";
            Chart.defaults.font.weight = '400';
            Chart.defaults.color = '#888780';
            Chart.defaults.plugins.tooltip.backgroundColor = '#2C2C2A';
            Chart.defaults.plugins.tooltip.padding = 10;
            Chart.defaults.plugins.tooltip.cornerRadius = 8;

            @if($joursAcquis > 0)
                new Chart(document.getElementById('congesChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: ['Utilisés', 'Restants'],
                        datasets: [{
                            data: [{{ $joursUtilises }}, {{ $soldeConges }}],
                            backgroundColor: ['#BA7517', '#0F6E56'],
                            hoverBackgroundColor: ['#8c5811', '#2C2C2A'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        cutout: '65%',
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { usePointStyle: true, pointStyle: 'circle', font: { size: 14, family: "'Inter', sans-serif" }, color: '#2C2C2A', padding: 24 }
                            },
                            datalabels: {
                                color: '#ffffff',
                                formatter: (value, ctx) => {
                                    if(value === 0) return '';
                                    const total = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    return Math.round((value / total) * 100) + '%';
                                },
                                anchor: 'center',
                                align: 'center',
                                font: { size: 13, weight: '500' }
                            }
                        },
                        layout: { padding: { left: 20, right: 20, top: 20, bottom: 20 } }
                    }
                });
            @endif

            @if(count($historiqueSalaires) > 0)
                const histData = @json($historiqueSalaires);
                new Chart(document.getElementById('salaryEvolutionChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: Object.keys(histData),
                        datasets: [{
                            label: 'Salaire',
                            data: Object.values(histData),
                            backgroundColor: '#185FA5',
                            hoverBackgroundColor: '#2C2C2A',
                            borderRadius: 0,
                            barThickness: 32
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: {
                            legend: { display: false },
                            tooltip: { callbacks: { label: function(context) { return ' ' + new Intl.NumberFormat('fr-FR').format(context.raw) + ' GNF'; } } },
                            datalabels: { display: false }
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                border: { display: true, color: 'rgba(0,0,0,0.1)' },
                                ticks: { font: { size: 13 }, color: '#2C2C2A' }
                            },
                            y: {
                                grid: { display: true, color: 'rgba(0,0,0,0.05)', drawBorder: false },
                                border: { display: false },
                                ticks: {
                                    font: { size: 13 },
                                    color: '#888780',
                                    callback: function(value) {
                                        return value.toLocaleString('fr-FR');
                                    }
                                }
                            }
                        }
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
