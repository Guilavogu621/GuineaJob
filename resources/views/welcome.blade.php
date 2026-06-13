<x-public-layout>
    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-48 lg:pb-32 bg-[#F1EFE8]">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <span class="inline-flex items-center gap-2 px-3 py-1 bg-white text-[#0F6E56] text-[15px] font-medium uppercase tracking-wide rounded-full mb-6" style="border: 0.5px solid rgba(26,122,74,0.2);">
                        <span class="w-2 h-2 rounded-full" style="background: #0F6E56;"></span>
                        Innovation RH en Guinée
                    </span>
                    <h1 class="text-4xl lg:text-5xl font-medium text-[#2C2C2A] leading-tight mb-6">
                        La plateforme RH et emploi <span class="text-[#0F6E56]">nouvelle génération</span>
                    </h1>
                    <p class="text-base text-[#888780] font-medium leading-relaxed mb-10 max-w-xl">
                        Digitalisez votre gestion. Recrutement, contrats, paie et marchés B2B réunis sur un seul et même écosystème conçu pour la croissance de votre entreprise.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row items-center gap-4">
                        <a href="{{ route('jobboard.index') }}" class="btn btn-primary btn-lg w-full sm:w-auto justify-center">
                            Trouver un emploi
                        </a>
                        <a href="{{ route('appels.public.index') }}" class="btn btn-outline btn-lg w-full sm:w-auto justify-center" style="background: white;">
                            Voir les marchés B2B
                        </a>
                    </div>
                </div>
                
                <div class="lg:w-1/2">
                    <div class="bg-white p-3 rounded-xl relative" style="border: 0.5px solid rgba(0,0,0,0.1);">
                        <img src="{{ asset('images/hero.jpg') }}" alt="Professionnels en Guinée" class="rounded-lg object-cover w-full h-[450px]">
                        
                        <!-- Floating Trust Badge -->
                        <div class="absolute -bottom-6 -left-6 bg-white p-4 rounded-xl flex items-center gap-4" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0" style="background: #E1F5EE; color: #0F6E56;">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <div class="text-[15px] font-medium text-[#2C2C2A]">Sécurité & Conformité</div>
                                <div class="text-[15px] text-[#888780] font-medium uppercase tracking-wide mt-0.5">100% Légal en Guinée</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Grid -->
    <section id="services" class="py-24 bg-white">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-[#0F6E56] font-medium tracking-wide uppercase text-[15px] mb-3 block">Nos Services</span>
                <h2 class="text-3xl lg:text-4xl font-medium text-[#2C2C2A] mb-4">Un Écosystème <span class="text-[#0F6E56]">Complet</span></h2>
                <p class="text-[#888780] font-medium max-w-2xl mx-auto text-[15px]">Centralisez vos opérations RH et vos affaires sur un outil unique, pensé pour l'efficacité.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-6" style="background: #E6F1FB; color: #185FA5;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h4 class="text-[16px] font-medium text-[#2C2C2A] mb-3">Recrutement</h4>
                    <p class="text-[15px] text-[#888780] leading-relaxed">Trouvez les meilleurs talents en Guinée grâce à nos outils de matching intelligents.</p>
                </div>

                <div class="bg-white p-6 rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-6" style="background: #E1F5EE; color: #0F6E56;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    </div>
                    <h4 class="text-[16px] font-medium text-[#2C2C2A] mb-3">RH & Contrats</h4>
                    <p class="text-[15px] text-[#888780] leading-relaxed">Digitalisez vos contrats et signez-les électroniquement avec un cryptage de haut niveau.</p>
                </div>

                <div class="bg-white p-6 rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-6" style="background: #FAEEDA; color: #BA7517;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h4 class="text-[16px] font-medium text-[#2C2C2A] mb-3">Paie & Salaires</h4>
                    <p class="text-[15px] text-[#888780] leading-relaxed">Gérez vos bulletins de paie et l'historique financier de vos employés en un clic.</p>
                </div>

                <div class="bg-white p-6 rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center mb-6" style="background: #F4F4F5; color: #52525B;">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1l1 1h5l1-1h1m-1 4h.01M9 16h.01M13 16h.01M17 16h.01M9 12h.01M13 12h.01M17 12h.01"></path></svg>
                    </div>
                    <h4 class="text-[16px] font-medium text-[#2C2C2A] mb-3">Marchés B2B</h4>
                    <p class="text-[15px] text-[#888780] leading-relaxed">Développez votre réseau d'affaires en accédant aux appels d'offres publics et privés.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Why Choose GuinéaJob -->
    <section class="py-24 bg-[#2C2C2A] text-white">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2">
                    <h3 class="text-3xl lg:text-4xl font-medium mb-8">Notre mission : sécuriser et simplifier l'emploi.</h3>
                    <ul class="space-y-6">
                        <li class="flex items-start gap-4">
                            <div class="bg-white/10 p-3 rounded-lg shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg mb-1">Plateforme 100% Guinéenne</h4>
                                <p class="text-white/70 text-[15px] leading-relaxed">Conçue sur mesure pour répondre aux réalités économiques et aux réglementations locales de la Guinée.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-white/10 p-3 rounded-lg shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg mb-1">Sécurité et Conformité</h4>
                                <p class="text-white/70 text-[15px] leading-relaxed">Vos données sont hébergées de manière sécurisée et les documents certifiés conformes au code du travail.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="bg-white/10 p-3 rounded-lg shrink-0 mt-0.5">
                                <svg class="w-5 h-5 text-[#1D9E75]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-medium text-lg mb-1">Gain de Temps Centralisé</h4>
                                <p class="text-white/70 text-[15px] leading-relaxed">Oubliez les multiples fichiers Excel. Gérez tout au même endroit avec nos tableaux de bord intelligents.</p>
                            </div>
                        </li>
                    </ul>
                </div>
                
                <div class="lg:w-1/2">
                    <span class="text-[#1D9E75] font-medium tracking-wide uppercase text-[15px] mb-3 block">Partenaires de Croissance</span>
                    <h2 class="text-3xl lg:text-4xl font-medium mb-6">La confiance au cœur de notre écosystème</h2>
                    <p class="text-[15px] text-white/70 font-medium leading-relaxed mb-8">
                        Nous avons bâti GuinéaJob pour offrir aux entreprises un environnement fiable où la gestion des talents et le développement des affaires s'effectuent en toute fluidité. Concentrez-vous sur l'essentiel : <strong class="text-white">votre croissance</strong>.
                    </p>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="p-6 bg-white/5 rounded-xl border border-white/10">
                            <div class="text-4xl font-medium text-[#1D9E75] mb-2">98%</div>
                            <div class="text-[15px] text-white/60 font-medium uppercase tracking-wide">De satisfaction client</div>
                        </div>
                        <div class="p-6 bg-white/5 rounded-xl border border-white/10">
                            <div class="text-4xl font-medium text-white mb-2">24/7</div>
                            <div class="text-[15px] text-white/60 font-medium uppercase tracking-wide">Support technique dédié</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Recent Opportunities -->
    <section class="py-24 bg-[#F1EFE8]">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-6">
                <div>
                    <span class="text-[#0F6E56] font-medium tracking-wide uppercase text-[15px] mb-3 block">Marché du Travail</span>
                    <h2 class="text-3xl lg:text-4xl font-medium text-[#2C2C2A]">Opportunités <span class="text-[#0F6E56]">Récentes</span></h2>
                    <p class="text-[#888780] font-medium text-[15px] mt-2">Les derniers postes et appels d'offres publiés par les entreprises guinéennes.</p>
                </div>
                <a href="{{ route('jobboard.index') }}" class="btn btn-outline btn-md bg-white">
                    Explorer le catalogue
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Jobs -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-[#185FA5]" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#2C2C2A]">Emplois Récents</h3>
                    </div>
                    
                    @forelse($dernieresOffres as $offre)
                        <a href="{{ route('jobboard.show', $offre) }}" class="block p-5 bg-white rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <h4 class="text-[15px] font-medium text-[#2C2C2A] mb-1">{{ $offre->titre }}</h4>
                                    <div class="flex items-center gap-3 text-[15px] font-medium text-[#888780]">
                                        <span>{{ $offre->entreprise->raison_sociale }}</span>
                                        <span>•</span>
                                        <span>{{ $offre->lieu }}</span>
                                    </div>
                                </div>
                                <span class="badge badge-gray">{{ $offre->type_contrat }}</span>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <p class="text-[15px] text-[#888780] font-medium">Aucune offre publiée pour le moment.</p>
                        </div>
                    @endforelse
                </div>

                <!-- Tenders -->
                <div class="space-y-4">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center text-[#52525B]" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                        </div>
                        <h3 class="text-xl font-medium text-[#2C2C2A]">Derniers Appels d'Offres</h3>
                    </div>
                    
                    @forelse($derniersAppels as $appel)
                        <a href="{{ route('appels.show', $appel) }}" class="block p-5 bg-white rounded-xl hover:bg-[#F1EFE8] transition-colors" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                                <div>
                                    <h4 class="text-[15px] font-medium text-[#2C2C2A] mb-1">{{ $appel->titre }}</h4>
                                    <div class="flex items-center gap-3 text-[15px] font-medium text-[#888780]">
                                        <span>{{ $appel->entreprise->raison_sociale }}</span>
                                        <span>•</span>
                                        <span class="truncate max-w-[150px]">{{ $appel->secteur_activite }}</span>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="text-[15px] font-medium text-[#993C1D] uppercase tracking-wide">Date Limite</div>
                                    <div class="text-[15px] font-medium text-[#993C1D]">{{ $appel->date_limite->format('d/m/Y') }}</div>
                                </div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center bg-white rounded-xl" style="border: 0.5px solid rgba(0,0,0,0.1);">
                            <p class="text-[15px] text-[#888780] font-medium">Aucun appel d'offre publié pour le moment.</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Stats -->
    <section class="py-24 bg-white" style="border-top: 0.5px solid rgba(0,0,0,0.1);">
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-4xl lg:text-5xl font-medium mb-2 text-[#2C2C2A]">500+</div>
                    <div class="text-[15px] uppercase font-medium tracking-wide text-[#888780]">Entreprises inscrites</div>
                </div>
                <div>
                    <div class="text-4xl lg:text-5xl font-medium mb-2 text-[#0F6E56]">12K+</div>
                    <div class="text-[15px] uppercase font-medium tracking-wide text-[#888780]">Talents qualifiés</div>
                </div>
                <div>
                    <div class="text-4xl lg:text-5xl font-medium mb-2 text-[#2C2C2A]">350+</div>
                    <div class="text-[15px] uppercase font-medium tracking-wide text-[#888780]">Offres Actives</div>
                </div>
                <div>
                    <div class="text-4xl lg:text-5xl font-medium mb-2 text-[#0F6E56]">1.2B</div>
                    <div class="text-[15px] uppercase font-medium tracking-wide text-[#888780]">Volume B2B (GNF)</div>
                </div>
            </div>
        </div>
    </section>

</x-public-layout>
