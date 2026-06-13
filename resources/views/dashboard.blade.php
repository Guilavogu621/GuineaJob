<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        {{-- Welcome Header --}}
        <div>
            <h1 class="text-xl font-medium text-[#2C2C2A]">
                Bienvenue, <span class="text-[#0F6E56]">{{ Auth::user()->prenom }}</span> 👋
            </h1>
            <p class="text-[15px] text-[#888780] mt-1">Heureux de vous revoir sur votre espace GuinéaJob.</p>
        </div>

        {{-- Main Card --}}
        <div class="bg-white rounded-xl p-6 relative overflow-hidden" style="border: 0.5px solid rgba(0,0,0,0.1);">
            <div class="max-w-2xl">
                <h3 class="text-base font-medium text-[#2C2C2A] mb-2">Votre compte est actif</h3>
                <p class="text-[15px] text-[#888780] leading-relaxed mb-5">
                    Vous êtes maintenant connecté à la plateforme GuinéaJob. Explorez les offres d'emploi ou gérez votre profil pour maximiser vos opportunités.
                </p>
                <div class="flex flex-wrap gap-3">
                    <a href="{{ route('jobboard.index') }}" class="btn btn-primary btn-md">Parcourir les emplois</a>
                    <a href="{{ route('profile.edit') }}" class="btn btn-outline btn-md">Mon profil</a>
                </div>
            </div>
        </div>

        @if(Auth::user()->hasRole('candidat'))
        {{-- Recent Applications --}}
        <div>
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-base font-medium text-[#2C2C2A]">Mes candidatures <span class="text-[#0F6E56]">récentes</span></h3>
                <span class="badge badge-gray">{{ count($candidatures) }} candidature(s)</span>
            </div>

            <div class="space-y-3">
                @forelse($candidatures as $candidature)
                    <div class="bg-white rounded-xl p-4 flex flex-col md:flex-row items-center justify-between gap-4 hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                        <div class="flex items-center gap-4 flex-1 min-w-0 w-full md:w-auto">
                            @php
                                $avatarColors = ['#0F6E56', '#185FA5', '#BA7517', '#993C1D'];
                                $companyName = $candidature->offreEmploi->entreprise->raison_sociale ?? 'G';
                                $colorIndex = crc32($companyName) % count($avatarColors);
                                $avatarColor = $avatarColors[abs($colorIndex)];
                            @endphp
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm font-medium shrink-0" style="background-color: {{ $avatarColor }};">
                                {{ substr($companyName, 0, 1) }}
                            </div>
                            <div class="min-w-0">
                                <h4 class="text-[15px] font-medium text-[#2C2C2A] truncate">{{ $candidature->offreEmploi->titre }}</h4>
                                <p class="text-[15px] text-[#888780] mt-0.5">{{ $candidature->offreEmploi->entreprise->raison_sociale }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 w-full md:w-auto justify-between md:justify-end shrink-0">
                            <div class="text-right">
                                <div class="text-[15px] text-[#888780] font-medium uppercase tracking-wide">Appliquée le</div>
                                <div class="text-[15px] font-medium text-[#2C2C2A]">{{ $candidature->created_at->format('d M Y') }}</div>
                            </div>
                            <div>
                                @php
                                    $statusBadge = match($candidature->statut) {
                                    \App\Models\Candidature::STATUS_PENDING => 'badge-pending',
                                    \App\Models\Candidature::STATUS_RETAINED => 'badge-info',
                                    \App\Models\Candidature::STATUS_INTERVIEW => 'badge-in-progress',
                                    \App\Models\Candidature::STATUS_HIRED => 'badge-active',
                                    \App\Models\Candidature::STATUS_REJECTED => 'badge-rejected',
                                    default => 'badge-gray',
                                };
                                $statusLabels = [
                                    \App\Models\Candidature::STATUS_PENDING => 'En attente',
                                    \App\Models\Candidature::STATUS_RETAINED => 'Retenu',
                                    \App\Models\Candidature::STATUS_INTERVIEW => 'Entretien',
                                    \App\Models\Candidature::STATUS_HIRED => 'Embauché',
                                    \App\Models\Candidature::STATUS_REJECTED => 'Refusé',
                                ];
                                @endphp
                                <span class="badge {{ $statusBadge }}">{{ $statusLabels[$candidature->statut] ?? ucfirst(str_replace('_', ' ', $candidature->statut)) }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-12 bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.1);">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center mx-auto mb-3" style="background: #F1EFE8; border: 0.5px solid rgba(0,0,0,0.08);">
                            <svg class="w-6 h-6 text-[#888780]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <p class="text-[15px] text-[#888780]">Vous n'avez pas encore postulé</p>
                        <a href="{{ route('jobboard.index') }}" class="mt-2 inline-block text-[15px] text-[#0F6E56] font-medium hover:underline">Découvrir les opportunités</a>
                    </div>
                @endforelse
            </div>
        </div>
        @endif

        {{-- Feature Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl p-5" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4" style="background: #E1F5EE; color: #0F6E56;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                </div>
                <div class="text-[15px] font-medium text-[#2C2C2A]">Exploration</div>
                <p class="text-[15px] text-[#888780] mt-1">Trouvez votre futur job</p>
            </div>
            <div class="bg-white rounded-xl p-5" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4" style="background: #E6F1FB; color: #185FA5;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="text-[15px] font-medium text-[#2C2C2A]">Sécurité</div>
                <p class="text-[15px] text-[#888780] mt-1">Données protégées</p>
            </div>
            <div class="bg-white rounded-xl p-5" style="border: 0.5px solid rgba(0,0,0,0.1);">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center mb-4" style="background: #FAEEDA; color: #BA7517;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                </div>
                <div class="text-[15px] font-medium text-[#2C2C2A]">Rapidité</div>
                <p class="text-[15px] text-[#888780] mt-1">Candidature en 1 clic</p>
            </div>
        </div>
    </div>
</x-app-layout>
