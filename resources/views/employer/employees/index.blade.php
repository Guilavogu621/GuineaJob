<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">

        {{-- Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-xl font-medium text-[#2C2C2A]">Gestion des Employés</h1>
                <p class="text-[15px] text-[#888780] mt-1">Déclarez et gérez les dossiers de vos collaborateurs actifs.</p>
            </div>
            <a href="{{ route('employer.employees.create') }}" class="btn btn-primary btn-md" style="gap: 6px;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                Déclarer un employé
            </a>
        </div>

        {{-- Flash --}}
        @if(session('success'))
            <div class="alert alert-success">
                <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                <div>
                    <span class="text-[15px] font-medium">{{ session('success') }}</span>
                    @if(session('temp_password'))
                        <div class="mt-3 p-3 bg-white rounded-lg" style="border: 0.5px solid rgba(0,0,0,0.08);">
                            <p class="text-[15px] font-medium text-[#2C2C2A] mb-1">Identifiants à transmettre à l'employé :</p>
                            <p class="font-mono text-[15px]">Email : <span class="font-medium">{{ session('new_employee_email') }}</span></p>
                            <p class="font-mono text-[15px]">Mot de passe provisoire : <span class="font-medium text-[#993C1D]" style="background: #FCEBEB; padding: 2px 6px; border-radius: 4px;">{{ session('temp_password') }}</span></p>
                            <p class="text-[15px] text-[#888780] mt-2">Ce mot de passe ne sera plus affiché. Copiez-le maintenant.</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif

        {{-- KPIs --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #0F6E56;">
                <p class="text-[13px] text-[#888780] font-medium uppercase tracking-wide">Total employés</p>
                <p class="text-2xl font-medium text-[#2C2C2A] mt-1">{{ $employees->count() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #185FA5;">
                <p class="text-[13px] text-[#888780] font-medium uppercase tracking-wide">Avec contrat</p>
                <p class="text-2xl font-medium text-[#2C2C2A] mt-1">{{ $employees->filter(fn($e) => $e->contrats->count() > 0)->count() }}</p>
            </div>
            <div class="bg-white rounded-xl p-4" style="border: 0.5px solid rgba(0,0,0,0.1); border-left: 3px solid #BA7517;">
                <p class="text-[13px] text-[#888780] font-medium uppercase tracking-wide">Sans contrat</p>
                <p class="text-2xl font-medium text-[#2C2C2A] mt-1">{{ $employees->filter(fn($e) => $e->contrats->count() === 0)->count() }}</p>
            </div>
        </div>

        {{-- Filters Bar --}}
        <div class="bg-white rounded-xl p-3" style="border: 0.5px solid rgba(0,0,0,0.1);">
            <form action="{{ route('employer.employees.index') }}" method="GET"
                  class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">

                {{-- Search --}}
                <div class="relative w-full lg:w-80">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-4 w-4 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Rechercher un employé..."
                           class="w-full h-[44px] bg-[#F9F8F5] border border-[#D3D1C7] rounded-[10px] text-[15px] text-[#2C2C2A] placeholder:text-[#B5B4AA] pl-9 pr-3 focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all">
                    <button type="submit" class="hidden"></button>
                </div>

                {{-- Right filters --}}
                <div class="flex flex-wrap items-center gap-2">
                    {{-- Sort select --}}
                    <select name="sort" onchange="this.form.submit()"
                            class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all cursor-pointer"
                            style="width: auto; min-width: 140px;">
                        <option value="">Trier : Tous</option>
                        <option value="recent" {{ request('sort') == 'recent' ? 'selected' : '' }}>Plus récents</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Plus anciens</option>
                    </select>

                    {{-- Type filter --}}
                    <select name="type" onchange="this.form.submit()"
                            class="h-[44px] px-4 border border-[#D3D1C7] bg-white rounded-[10px] text-[15px] text-[#2C2C2A] focus:outline-none focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 transition-all cursor-pointer"
                            style="width: auto; min-width: 140px;">
                        <option value="">Contrat : Tous</option>
                        <option value="CDI"       {{ request('type') == 'CDI'       ? 'selected' : '' }}>CDI</option>
                        <option value="CDD"       {{ request('type') == 'CDD'       ? 'selected' : '' }}>CDD</option>
                        <option value="Stage"     {{ request('type') == 'Stage'     ? 'selected' : '' }}>Stage</option>
                        <option value="Prestation"{{ request('type') == 'Prestation'? 'selected' : '' }}>Prestation</option>
                    </select>

                    {{-- Reset --}}
                    @if(request()->anyFilled(['search', 'sort', 'type']))
                        <a href="{{ route('employer.employees.index') }}"
                           class="h-[44px] px-4 inline-flex items-center gap-2 border border-[#D3D1C7] rounded-[10px] text-[15px] text-[#993C1D] hover:bg-[#FCEBEB] transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                            Réinitialiser
                        </a>
                    @endif
                </div>
            </form>
        </div>

        {{-- Table --}}
        <div class="table-container">
            <div class="overflow-x-auto">
                <table class="design-table">
                    <thead>
                        <tr>
                            <th>Matricule</th>
                            <th>Employé</th>
                            <th>Poste</th>
                            <th>Type</th>
                            <th>Statut Contrat</th>
                            <th style="text-align: right;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employe)
                            <tr>
                                <td><span class="matricule-pill">{{ $employe->numero_matricule }}</span></td>
                                <td>
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 rounded-full bg-[#E1F5EE] flex items-center justify-center text-[14px] font-medium text-[#0F6E56]">
                                            {{ substr($employe->user->prenom, 0, 1) }}{{ substr($employe->user->nom, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-[15px] font-medium text-[#2C2C2A]">{{ $employe->user->prenom }} {{ $employe->user->nom }}</p>
                                            <p class="text-[13px] text-[#888780]">{{ $employe->user->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-[15px] text-[#2C2C2A]">{{ $employe->poste }}</td>
                                <td class="text-[15px] text-[#888780]">{{ $employe->type_contrat }}</td>
                                <td>
                                    @php
                                        $activeContract = $employe->contrats->whereIn('statut', ['Actif', 'Envoyé', 'Signé employeur', 'Signé employé'])->first();
                                    @endphp
                                    @if($activeContract)
                                        @if($activeContract->statut === 'Actif')
                                            <span class="badge badge-active">Actif</span>
                                        @elseif($activeContract->statut === 'Envoyé')
                                            <span class="badge badge-pending">En attente employé</span>
                                        @else
                                            <span class="badge badge-info">{{ $activeContract->statut }}</span>
                                        @endif
                                    @else
                                        <span class="badge badge-danger">Sans contrat</span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <div class="table-actions justify-end">
                                        <a href="{{ route('employer.employees.edit', $employe) }}" class="table-btn-edit flex items-center gap-1">
                                            Éditer
                                        </a>
                                        @if(!$activeContract)
                                            <a href="{{ route('employer.contracts.create', ['employe_id' => $employe->id]) }}" class="table-btn-create-contract flex items-center gap-1">
                                                Nouveau contrat
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 48px 18px; text-align: center;">
                                    <div class="flex flex-col items-center">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        </div>
                                        <p class="text-[15px] text-[#888780]">Aucun employé trouvé.</p>
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
