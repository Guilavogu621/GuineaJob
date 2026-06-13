<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="font-bold text-xl text-[#2C2C2A] leading-tight">
                    {{ __('Statistiques et Reporting') }}
                </h2>
                <p class="text-sm text-[#888780] mt-1">Vue globale de la plateforme GuinéaJob</p>
            </div>
            <button onclick="window.print()" class="text-sm font-semibold text-[#0F6E56] bg-[#0F6E56]/10 px-5 py-2.5 rounded-xl hover:bg-[#0F6E56] hover:text-white transition-all duration-200 flex items-center gap-2 shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                Exporter (PDF)
            </button>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <!-- Bloc 1 : Finance (Masse Salariale) — Carte Hero -->
            <div class="overflow-hidden sm:rounded-2xl p-8 card-animated card-hover shadow-lg" style="background: linear-gradient(135deg, #0F6E56 0%, #1D9E75 100%)">
                <div class="flex items-start justify-between">
                    <div>
                        <h3 class="text-sm font-semibold text-white/70 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Masse Salariale Globale
                        </h3>
                        <div class="flex items-end gap-3">
                            <div class="text-4xl md:text-5xl font-black text-white">
                                {{ number_format($masseSalariale, 0, ',', ' ') }}
                            </div>
                            <div class="text-lg font-bold text-white/50 mb-1">GNF / mois</div>
                        </div>
                        <p class="text-sm text-white/60 mt-3 max-w-lg">Somme totale des salaires bruts mensuels de tous les contrats actifs sur la plateforme.</p>
                    </div>
                    <div class="hidden md:flex items-center justify-center w-16 h-16 bg-white/10 rounded-2xl">
                        <svg class="w-8 h-8 text-white/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                    </div>
                </div>
            </div>

            <!-- Bloc 2 : Graphiques côte à côte -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Graphique : Répartition Utilisateurs -->
                <div class="bg-white overflow-hidden sm:rounded-2xl border border-gray-200/60 p-6 card-animated card-hover shadow-sm">
                    <h3 class="text-xs font-bold text-[#888780] uppercase tracking-widest mb-6">Répartition des Utilisateurs</h3>
                    <div class="relative h-72 w-full flex items-center justify-center">
                        <canvas id="usersChart"></canvas>
                    </div>
                </div>

                <!-- Graphique : État du Parc des Contrats -->
                <div class="bg-white overflow-hidden sm:rounded-2xl border border-gray-200/60 p-6 card-animated card-hover shadow-sm">
                    <h3 class="text-xs font-bold text-[#888780] uppercase tracking-widest mb-6">État Global des Contrats</h3>
                    <div class="relative h-72 w-full flex items-center justify-center">
                        @if(count($contractsByStatus) > 0)
                            <canvas id="contractsGlobalChart"></canvas>
                        @else
                            <p class="text-sm text-gray-400 italic">Aucun contrat sur la plateforme</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Script d'initialisation des diagrammes -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // 1. Graphique : Utilisateurs (Doughnut)
            const usersData = @json($usersByRole);
            new Chart(document.getElementById('usersChart').getContext('2d'), {
                type: 'doughnut',
                data: {
                    labels: ['Administrateurs', 'Employeurs', 'Employés', 'Candidats', 'Prestataires'],
                    datasets: [{
                        data: [usersData.admin || 0, usersData.employeur || 0, usersData.employe || 0, usersData.candidat || 0, usersData.prestataire || 0],
                        backgroundColor: ['#993C1D', '#0F6E56', '#185FA5', '#2C2C2A', '#BA7517'],
                        borderWidth: 0, hoverOffset: 8
                    }]
                },
                options: {
                    responsive: true, maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { size: 12, family: 'Inter', weight: '600' }
                            }
                        }
                    },
                    cutout: '65%'
                }
            });

            // 2. Graphique : Contrats Globaux (Bar Chart)
            @if(count($contractsByStatus) > 0)
                const contractsData = @json($contractsByStatus);
                const statusLabels = {
                    'Actif': 'Actifs',
                    'Brouillon': 'Brouillons',
                    'Envoyé': 'Envoyés',
                    'Signé employeur': 'Signés Employeur',
                    'Signé employé': 'Signés Employé',
                    'Annulé': 'Annulés'
                };
                const statusColors = {
                    'Actif': '#0F6E56',
                    'Brouillon': '#888780',
                    'Envoyé': '#BA7517',
                    'Signé employeur': '#BA7517',
                    'Signé employé': '#BA7517',
                    'Annulé': '#993C1D'
                };
                const labels = Object.keys(contractsData).map(s => statusLabels[s] || s.toUpperCase());
                const values = Object.values(contractsData);
                const colors = Object.keys(contractsData).map(s => statusColors[s] || '#0F6E56');

                new Chart(document.getElementById('contractsGlobalChart').getContext('2d'), {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Contrats',
                            data: values,
                            backgroundColor: colors,
                            borderRadius: 8,
                            barThickness: 36
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { beginAtZero: true, grid: { color: 'rgba(0,0,0,0.04)', borderDash: [3, 3] }, ticks: { stepSize: 1, font: { family: 'Inter', weight: '600', size: 11 }, color: '#9CA3AF' } },
                            x: { grid: { display: false }, ticks: { font: { size: 11, family: 'Inter', weight: '600' }, color: '#6B7280' } }
                        }
                    }
                });
            @endif

        });
    </script>
</x-app-layout>
