<x-app-layout>
    <div class="space-y-6 px-4 sm:px-6 lg:px-8 py-6">
        
        <div class="mb-6">
            <a href="{{ route('candidate.jobs.show', $offre) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-500 hover:text-[#0F6E56] transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                Retour aux détails de l'offre
            </a>
        </div>

        <div class="max-w-3xl mx-auto">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gray-50/50">
                    <h1 class="text-2xl font-bold text-gray-900 mb-2">
                        Postuler pour : {{ $offre->titre }}
                    </h1>
                    <p class="text-sm font-semibold text-[#0F6E56]">{{ $offre->entreprise->raison_sociale }}</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('candidate.jobs.store', $offre) }}" method="POST" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        
                        <!-- Upload CV -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Curriculum Vitae (CV) <span class="text-red-500">*</span></label>
                            <div class="relative group">
                                <input type="file" name="cv" required id="cv-upload"
                                    class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center gap-4 px-5 py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl group-hover:border-[#0F6E56] group-hover:bg-[#E1F5EE]/30 transition-all duration-300">
                                    <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-gray-400 group-hover:text-[#0F6E56] transition-colors shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-bold text-gray-700 group-hover:text-[#0F6E56] transition-colors" id="cv-filename">Sélectionnez votre CV</p>
                                        <p class="text-[12px] font-semibold text-gray-400 mt-0.5 uppercase tracking-wider">PDF ou DOC (Max 5Mo)</p>
                                    </div>
                                </div>
                            </div>
                            @error('cv') <p class="text-red-500 text-sm font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Upload Lettre de Motivation -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Lettre de Motivation <span class="text-gray-400 font-normal italic">(Optionnel)</span></label>
                            <div class="relative group">
                                <input type="file" name="lettre_motivation" id="lm-upload"
                                    class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center gap-4 px-5 py-4 bg-gray-50 border-2 border-dashed border-gray-200 rounded-xl group-hover:border-[#0F6E56] group-hover:bg-[#E1F5EE]/30 transition-all duration-300">
                                    <div class="w-10 h-10 bg-white rounded-lg shadow-sm flex items-center justify-center text-gray-400 group-hover:text-[#0F6E56] transition-colors shrink-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-bold text-gray-700 group-hover:text-[#0F6E56] transition-colors" id="lm-filename">Lettre de motivation</p>
                                        <p class="text-[12px] font-semibold text-gray-400 mt-0.5 uppercase tracking-wider">PDF ou DOC</p>
                                    </div>
                                </div>
                            </div>
                            @error('lettre_motivation') <p class="text-red-500 text-sm font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Message -->
                        <div class="space-y-3">
                            <label class="block text-sm font-bold text-gray-700">Message pour l'employeur <span class="text-gray-400 font-normal italic">(Optionnel)</span></label>
                            <textarea name="commentaire" rows="4" 
                                class="block w-full px-4 py-3 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-900 placeholder:text-gray-400 focus:ring-2 focus:ring-[#0F6E56]/20 focus:border-[#0F6E56] transition-all duration-300" 
                                placeholder="Partagez quelques mots sur vos motivations..."></textarea>
                            @error('commentaire') <p class="text-red-500 text-sm font-medium mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Boutons d'action -->
                        <div class="pt-4 flex items-center gap-4 border-t border-gray-100">
                            <button type="submit" class="px-6 py-2.5 bg-[#0F6E56] text-white font-bold text-sm rounded-lg shadow-sm hover:bg-[#0A5A45] transition-colors flex items-center gap-2">
                                Confirmer la candidature
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            <a href="{{ route('candidate.jobs.show', $offre) }}" class="px-6 py-2.5 text-gray-600 font-bold text-sm hover:text-gray-900 transition-colors">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('cv-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Sélectionnez votre CV";
            document.getElementById('cv-filename').textContent = fileName;
        });
        document.getElementById('lm-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Lettre de motivation";
            document.getElementById('lm-filename').textContent = fileName;
        });
    </script>
</x-app-layout>
