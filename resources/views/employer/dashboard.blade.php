<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header Area --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-8">
            <div>
                <h1 class="text-3xl font-bold text-gray-900">Tableau de bord</h1>
                <p class="text-[15px] text-gray-500 mt-2">
                    Content de vous revoir, {{ $user->prenom }}. Voici ce qui se passe aujourd'hui.
                </p>
            </div>
            <div class="flex flex-wrap items-center gap-3 mt-4 md:mt-0">
                <a href="{{ route('employer.employees.create') }}" class="btn btn-primary btn-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path></svg>
                    Ajouter un employé
                </a>
                <a href="{{ route('employer.recrutement.create') }}" class="btn btn-outline btn-md">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 00-3.375-3.375h-1.5A1.125 1.125 0 0113.5 7.125v-1.5a3.375 3.375 0 00-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 00-9-9z"></path></svg>
                    Publier une offre
                </a>
                <a href="{{ route('employer.conges.index') }}" class="btn btn-outline btn-md">
                    <svg class="w-4 h-4 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Valider un congé
                </a>
            </div>
        </div>

        {{-- Top KPI Row (6 columns) --}}
        <div class="grid grid-cols-2 md:grid-cols-3 xl:grid-cols-6 gap-4 md:gap-6">
            {{-- KPI 1: Total Employees --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $totalEmployees }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Total Employés</div>
                </div>
            </div>

            {{-- KPI 2: New Hires --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $newHires }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Nouveaux recrutés</div>
                </div>
            </div>

            {{-- KPI 3: Open Positions --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-teal-50 flex items-center justify-center text-teal-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $openPositions }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Offres actives</div>
                </div>
            </div>

            {{-- KPI 4: Attendance Rate --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-indigo-50 flex items-center justify-center text-indigo-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $attendanceRate }}%</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Taux de présence</div>
                </div>
            </div>

            {{-- KPI 5: Pending Leaves --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-pink-50 flex items-center justify-center text-pink-600">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $congesEnAttente }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Congés en attente</div>
                </div>
            </div>

            {{-- KPI 6: Upcoming Reviews --}}
            <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 flex flex-col justify-between">
                <div class="flex justify-between items-start mb-2">
                    <div class="w-8 h-8 rounded-lg bg-[#E1F5EE] flex items-center justify-center text-[#0F6E56]">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    </div>
                </div>
                <div>
                    <div class="text-4xl font-bold text-gray-900">{{ $recentApplicationsCount }}</div>
                    <div class="text-sm text-gray-500 font-medium mt-1.5">Candidatures</div>
                </div>
            </div>
        </div>

        {{-- Middle Row (2 charts using ApexCharts) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Chart 1: Headcount Trend --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Évolution des effectifs</h3>
                <div id="headcountChart" class="w-full h-72"></div>
            </div>

            {{-- Chart 2: Department Distribution --}}
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex flex-col">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Répartition par département</h3>
                <div class="flex-1 flex items-center justify-center">
                    @if(count($deptLabels) > 0)
                        <div id="departmentChart" class="w-full h-64"></div>
                    @else
                        <div class="text-gray-400 text-sm">Pas assez de données.</div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Bottom Row (Activity & Events) --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Activity --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C2C2A]">Activités récentes</h3>
                </div>
                <div class="p-2">
                    @forelse($recentActivities as $activity)
                    <div class="flex items-start gap-4 p-4 hover:bg-[#F1EFE8] rounded-lg transition-colors cursor-pointer">
                        @php
                            $avatarColors = ['bg-[#0F6E56]', 'bg-[#185FA5]', 'bg-[#BA7517]', 'bg-[#993C1D]'];
                            $colorClass = $avatarColors[crc32($activity->user->nom ?? 'A') % count($avatarColors)];
                        @endphp
                        <div class="shrink-0 w-10 h-10 rounded-full flex items-center justify-center text-white text-sm font-medium {{ $colorClass }}">
                            {{ substr($activity->user->prenom, 0, 1) }}{{ substr($activity->user->nom, 0, 1) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="text-sm font-medium text-[#2C2C2A]">Nouvelle candidature: {{ $activity->offre->titre }}</h4>
                                <span class="text-sm text-[#888780] whitespace-nowrap">{{ $activity->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-[#888780] mt-1 truncate">
                                {{ $activity->user->full_name }} a soumis une candidature.
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="p-8 text-center text-[#888780] text-sm">Aucune activité récente.</div>
                    @endforelse
                </div>
            </div>

            {{-- Upcoming Events --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                <div class="p-6 pb-4 border-b border-gray-100">
                    <h3 class="text-lg font-semibold text-[#2C2C2A]">Événements à venir</h3>
                </div>
                <div class="p-6 space-y-4">
                    @forelse($upcomingEvents as $event)
                    <div class="flex items-start gap-4 border border-gray-100 p-4 rounded-lg">
                        <div class="shrink-0 w-10 h-10 rounded-lg bg-[#FAEEDA] flex items-center justify-center text-[#BA7517]">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-start">
                                <h4 class="text-sm font-medium text-[#2C2C2A] truncate">Congé : {{ $event->employe->user->full_name }}</h4>
                                <span class="text-sm font-medium text-[#888780] whitespace-nowrap">{{ $event->date_debut->format('M d') }}</span>
                            </div>
                            <p class="text-sm text-[#888780] mt-1">
                                Du {{ $event->date_debut->format('d/m') }} au {{ $event->date_fin->format('d/m/Y') }}
                            </p>
                            <span class="inline-block mt-2 px-2 py-0.5 bg-[#FCEBEB] text-[#993C1D] text-[15px] font-semibold rounded-full uppercase tracking-wide">
                                Absence
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 text-center text-gray-500 text-sm">Aucun événement à venir.</div>
                    @endforelse
                </div>
            </div>
        </div>

    </div>

    {{-- ApexCharts Scripts --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Headcount Trend (Line Chart)
            const headcountOptions = {
                series: [{
                    name: 'Headcount',
                    data: @json($headcountTrend)
                }],
                chart: {
                    type: 'area',
                    height: 280,
                    fontFamily: 'Inter, sans-serif',
                    toolbar: { show: false },
                    zoom: { enabled: false }
                },
                colors: ['#0F6E56'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.4,
                        opacityTo: 0.05,
                        stops: [0, 100]
                    }
                },
                dataLabels: { enabled: false },
                stroke: {
                    curve: 'smooth',
                    width: 2
                },
                xaxis: {
                    categories: @json($headcountMonths),
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: { colors: '#9CA3AF', fontSize: '12px' }
                    }
                },
                yaxis: {
                    labels: {
                        style: { colors: '#9CA3AF', fontSize: '12px' }
                    }
                },
                grid: {
                    borderColor: '#F3F4F6',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: false } },
                    yaxis: { lines: { show: true } },
                    padding: { top: 0, right: 0, bottom: 0, left: 10 }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function (val) { return val + " employés" } }
                }
            };

            const headcountChart = new ApexCharts(document.querySelector("#headcountChart"), headcountOptions);
            headcountChart.render();

            // Department Distribution (Donut Chart)
            @if(count($deptLabels) > 0)
            const deptOptions = {
                series: @json($deptSeries),
                chart: {
                    type: 'donut',
                    height: 280,
                    fontFamily: 'Inter, sans-serif',
                },
                labels: @json($deptLabels),
                colors: ['#0F6E56', '#1D9E75', '#BA7517', '#185FA5', '#993C1D', '#2C2C2A', '#E1F5EE'],
                plotOptions: {
                    pie: {
                        donut: {
                            size: '65%',
                            labels: {
                                show: false
                            }
                        }
                    }
                },
                dataLabels: { enabled: false },
                stroke: { show: true, colors: '#ffffff', width: 2 },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    markers: { radius: 12 },
                    itemMargin: { horizontal: 10, vertical: 5 },
                    fontSize: '12px',
                    fontWeight: 500,
                    labels: { colors: '#4B5563' }
                },
                tooltip: {
                    theme: 'light',
                    y: { formatter: function (val) { return val + " employés" } }
                }
            };

            const deptChart = new ApexCharts(document.querySelector("#departmentChart"), deptOptions);
            deptChart.render();
            @endif
        });
    </script>
</x-app-layout>
