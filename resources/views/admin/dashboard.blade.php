<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header Area matching prototype --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <h1 class="text-3xl font-bold text-[#2C2C2A]">Centre de Contrôle</h1>
            <div class="flex items-center gap-4 mt-4 md:mt-0">
                <span class="text-sm font-medium text-[#2C2C2A]">{{ now()->translatedFormat('d F, Y') }}</span>
                <a href="{{ route('admin.create-employer') }}" class="btn btn-outline btn-md bg-white">Nouvelle entreprise</a>
            </div>
        </div>

        {{-- Top KPI Row (3 columns) --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- KPI 1: Entreprises --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-base font-medium text-[#2C2C2A]">Total entreprises</h3>
                    <button class="text-[#888780] hover:text-[#2C2C2A]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
                <div class="flex justify-between items-end">
                    <div class="text-4xl font-bold text-[#2C2C2A]">{{ number_format($totalEntreprises, 0, ',', ' ') }}</div>
                    <div class="flex items-center gap-1 bg-[#F1EFE8] px-3 py-1.5 rounded-full" style="border: 0.5px solid rgba(0,0,0,0.08);">
                        <svg class="w-3.5 h-3.5 text-[#0F6E56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <span class="text-sm font-medium text-[#2C2C2A]">8.2%</span>
                    </div>
                </div>
            </div>

            {{-- KPI 2: Employés --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-base font-medium text-[#2C2C2A]">Employés actifs</h3>
                    <button class="text-[#888780] hover:text-[#2C2C2A]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
                <div class="flex justify-between items-end">
                    <div class="text-4xl font-bold text-[#2C2C2A]">{{ number_format($totalEmployes, 0, ',', ' ') }}</div>
                    <div class="flex items-center gap-1 bg-[#F1EFE8] px-3 py-1.5 rounded-full" style="border: 0.5px solid rgba(0,0,0,0.08);">
                        <svg class="w-3.5 h-3.5 text-[#0F6E56]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                        <span class="text-sm font-medium text-[#2C2C2A]">12.4%</span>
                    </div>
                </div>
            </div>

            {{-- KPI 3: Masse globale --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="flex justify-between items-start mb-4">
                    <h3 class="text-base font-medium text-[#2C2C2A]">Flux financier mensuel (GNF)</h3>
                    <button class="text-[#888780] hover:text-[#2C2C2A]">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path></svg>
                    </button>
                </div>
                <div class="flex justify-between items-end">
                    <div class="text-4xl font-bold text-[#2C2C2A]">{{ number_format($masseSalarialeGlobale, 0, ',', ' ') }}</div>
                    <div class="flex -space-x-2">
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-[#185FA5] text-white flex items-center justify-center text-xs font-medium">GU</div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-[#BA7517] text-white flex items-center justify-center text-xs font-medium">B2</div>
                        <div class="w-8 h-8 rounded-full border-2 border-white bg-[#F3F4F6] text-[#888780] flex items-center justify-center text-xs font-medium">+5</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Middle Row (2 charts) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Chart 1 --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <h3 class="text-lg font-medium text-[#2C2C2A] mb-6">Entreprises par secteur</h3>
                <div class="flex items-center h-64">
                    <div class="w-full relative h-full flex items-center justify-center">
                        @if(count($entreprisesParSecteur) > 0)
                            <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none mt-2">
                                <span class="text-3xl font-medium text-[#2C2C2A]">{{ array_sum($entreprisesParSecteur) }}</span>
                                <span class="text-xs text-[#888780] font-medium uppercase mt-1">Total</span>
                            </div>
                            <canvas id="secteurChart"></canvas>
                        @else
                            <div class="text-[#888780] text-sm">Aucune donnée disponible</div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Chart 2 --}}
            <div class="bg-white rounded-xl p-6" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <h3 class="text-lg font-medium text-[#2C2C2A] mb-6">Contrats par statut</h3>
                <div class="flex items-center h-64">
                    <div class="w-full relative h-full flex items-center justify-center">
                        @if(count($contractsByStatus) > 0)
                            <canvas id="statusChart"></canvas>
                        @else
                            <div class="text-[#888780] text-sm">Données insuffisantes</div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Bottom Row (Table) --}}
        <div class="table-container bg-white mt-8">
            <div class="p-5 flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4" style="border-bottom: 0.5px solid rgba(0,0,0,0.08);">
                <h3 class="text-lg font-medium text-[#2C2C2A]">Répertoire des entreprises</h3>

                <form action="{{ route('admin.dashboard') }}" method="GET" class="flex items-center gap-2 w-full lg:w-auto">
                    <div class="relative w-full lg:w-64">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#888780]">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Rechercher..."
                            class="block w-full pl-10 pr-3 py-2 text-sm rounded-lg" style="border: 0.5px solid rgba(0,0,0,0.1);">
                        <button type="submit" class="hidden"></button>
                    </div>
                </form>
            </div>
            <div class="overflow-x-auto">
                <table class="design-table w-full text-left">
                    <thead>
                        <tr>
                            <th class="text-sm">Entreprise</th>
                            <th class="text-sm">Secteur</th>
                            <th class="text-sm">Gestionnaire</th>
                            <th class="text-sm">Inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($entreprises as $entreprise)
                            <tr class="hover:bg-[#F1EFE8] transition-colors border-b" style="border-bottom-color: rgba(0,0,0,0.06);">
                                <td class="p-4">
                                    <div class="flex items-center gap-3">
                                        @php
                                            $avatarColors = ['#0F6E56', '#185FA5', '#BA7517', '#993C1D'];
                                            $colorIndex = crc32($entreprise->raison_sociale) % count($avatarColors);
                                            $avatarColor = $avatarColors[abs($colorIndex)];
                                        @endphp
                                        <div class="shrink-0 w-9 h-9 rounded-lg flex items-center justify-center text-white text-sm font-medium" style="background-color: {{ $avatarColor }};">
                                            {{ strtoupper(substr($entreprise->raison_sociale, 0, 2)) }}
                                        </div>
                                        <div>
                                            <div class="text-base font-medium text-[#2C2C2A]">{{ $entreprise->raison_sociale }}</div>
                                            <div class="text-sm text-[#888780] mt-0.5">ID: #{{ str_pad($entreprise->id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <span class="badge badge-info">{{ $entreprise->secteur }}</span>
                                </td>
                                <td class="p-4">
                                    <div class="text-base font-medium text-[#2C2C2A]">{{ $entreprise->user->full_name }}</div>
                                    <div class="text-sm text-[#888780] mt-0.5">{{ $entreprise->user->email }}</div>
                                </td>
                                <td class="p-4">
                                    <span class="text-base text-[#888780] font-medium">{{ $entreprise->created_at->format('d M Y') }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                        <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path></svg>
                                    </div>
                                    <p class="text-sm text-[#888780]">Aucune entreprise trouvée.</p>
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

            @if(count($entreprisesParSecteur) > 0)
                new Chart(document.getElementById('secteurChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(@json($entreprisesParSecteur)),
                        datasets: [{
                            data: Object.values(@json($entreprisesParSecteur)),
                            backgroundColor: ['#0F6E56', '#185FA5', '#BA7517', '#993C1D'],
                            hoverBackgroundColor: ['#2C2C2A', '#0f4477', '#8c5811', '#b93939'],
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

            @if(count($contractsByStatus) > 0)
                new Chart(document.getElementById('statusChart').getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: Object.keys(@json($contractsByStatus)).map(s => s.replace('_', ' ')),
                        datasets: [{
                            data: Object.values(@json($contractsByStatus)),
                            backgroundColor: ['#0F6E56', '#185FA5', '#BA7517', '#993C1D'],
                            hoverBackgroundColor: ['#2C2C2A', '#0f4477', '#8c5811', '#b93939'],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        cutout: '0%', // Pie style
                        plugins: {
                            legend: {
                                position: 'right',
                                labels: { usePointStyle: true, pointStyle: 'circle', font: { size: 14, family: "'Inter', sans-serif" }, color: '#2C2C2A', padding: 24 }
                            },
                            datalabels: { display: false }
                        },
                        layout: { padding: { left: 10, right: 10, top: 10, bottom: 10 } }
                    }
                });
            @endif
        });
    </script>
</x-app-layout>
