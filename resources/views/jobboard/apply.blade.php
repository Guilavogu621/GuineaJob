<x-public-layout>
    <!-- Apply Header Hero -->
    <section class="relative pt-32 pb-16 lg:pt-40 lg:pb-20 overflow-hidden bg-white border-b border-slate-50">
        <div class="absolute top-0 right-0 -z-10 w-1/3 h-full bg-gradient-to-bl from-[#F1EFE8] to-white rounded-bl-[200px]"></div>
        
        <div class="max-w-[90rem] mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center md:text-left max-w-4xl">
                <span class="inline-flex items-center gap-2 px-4 py-2 bg-[#E1F5EE] text-[#0F6E56] text-[15px] font-black uppercase tracking-[0.2em] rounded-full mb-6 border border-[#E1F5EE]">
                    Formulaire de Candidature
                </span>
                <h1 class="text-3xl lg:text-5xl font-black text-[#2C2C2A] font-outfit tracking-tight leading-tight mb-4">
                    Postuler pour <span class="text-[#0F6E56]">{{ $offre->titre }}</span>
                </h1>
                <p class="text-xl text-slate-400 font-bold font-outfit uppercase tracking-widest">{{ $offre->entreprise->raison_sociale }}</p>
            </div>
        </div>
    </section>

    <div class="py-16 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="bg-white rounded-[2.5rem] shadow-[0_20px_60px_rgba(11,23,54,0.05)] border border-slate-100 overflow-hidden relative">
                <!-- Décoration interne -->
                <div class="absolute -right-20 -bottom-20 w-64 h-64 bg-[#0F6E56]/5 rounded-full blur-3xl -z-10"></div>
                
                <div class="p-10 lg:p-14">
                    <form action="{{ route('jobboard.store', $offre) }}" method="POST" enctype="multipart/form-data" class="space-y-10">
                        @csrf
                        
                        <!-- Upload CV -->
                        <div class="space-y-4">
                            <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Curriculum Vitae (CV) <span class="text-[#993C1D]">*</span></label>
                            <div class="relative group">
                                <input type="file" name="cv" required id="cv-upload"
                                    class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center gap-4 px-6 py-5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl group-hover:border-[#0F6E56] group-hover:bg-[#0F6E56]/5 transition-all duration-300 peer-focus:ring-2 peer-focus:ring-[#0F6E56]/20">
                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400 group-hover:text-[#0F6E56] transition-colors shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-black text-[#2C2C2A] group-hover:text-[#0F6E56] transition-colors" id="cv-filename">Sélectionnez votre CV</p>
                                        <p class="text-[15px] font-bold text-slate-400 mt-1 uppercase tracking-widest">PDF ou DOC (Max 5Mo)</p>
                                    </div>
                                    <div class="hidden sm:block text-[15px] font-black text-[#0F6E56] opacity-0 group-hover:opacity-100 uppercase transition-opacity">Parcourir</div>
                                </div>
                            </div>
                            @error('cv') <p class="text-[#993C1D] text-[15px] font-black mt-2">{{ $message }}</p> @enderror
                        </div>

                        <!-- Upload Lettre de Motivation -->
                        <div class="space-y-4">
                            <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Lettre de Motivation <span class="text-slate-400 italic">(Optionnel)</span></label>
                            <div class="relative group">
                                <input type="file" name="lettre_motivation" id="lm-upload"
                                    class="peer absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10">
                                <div class="flex items-center gap-4 px-6 py-5 bg-slate-50 border-2 border-dashed border-slate-200 rounded-2xl group-hover:border-[#0F6E56] group-hover:bg-[#0F6E56]/5 transition-all duration-300 peer-focus:ring-2 peer-focus:ring-[#0F6E56]/20">
                                    <div class="w-12 h-12 bg-white rounded-xl shadow-sm flex items-center justify-center text-slate-400 group-hover:text-[#0F6E56] transition-colors shrink-0">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                                    </div>
                                    <div class="flex-grow">
                                        <p class="text-sm font-black text-[#2C2C2A] group-hover:text-[#0F6E56] transition-colors" id="lm-filename">Lettre de motivation</p>
                                        <p class="text-[15px] font-bold text-slate-400 mt-1 uppercase tracking-widest">Document PDF ou Image</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Message -->
                        <div class="space-y-4">
                            <label class="block text-[15px] font-black text-slate-400 uppercase tracking-[0.2em] ml-1">Message pour l'employeur</label>
                            <textarea name="commentaire" rows="5" 
                                class="block w-full px-6 py-5 bg-slate-50 border-none rounded-[1.5rem] text-base font-medium text-[#2C2C2A] placeholder:text-slate-300 focus:ring-2 focus:ring-[#0F6E56]/20 focus:bg-white transition-all duration-300 shadow-inner" 
                                placeholder="Partagez quelques mots sur vos motivations..."></textarea>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="flex flex-col md:flex-row items-center gap-6 pt-6">
                            <button type="submit" class="w-full md:w-2/3 py-5 bg-[#0F6E56] text-white font-black text-[15px] uppercase tracking-[0.3em] rounded-2xl shadow-2xl shadow-[#0F6E56]/30 hover:bg-[#0A5A45] hover:-translate-y-1 transition-all active:translate-y-0 flex items-center justify-center gap-3">
                                Envoyer mon dossier
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                            <a href="{{ route('jobboard.show', $offre) }}" class="w-full md:w-1/3 py-5 text-center text-slate-400 font-black text-[15px] uppercase tracking-[0.2em] hover:text-[#993C1D] transition-colors">
                                Annuler
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <p class="text-center mt-12 text-xs font-bold text-slate-400 uppercase tracking-widest">
                En postulant, vous acceptez les <a href="#" class="text-[#0F6E56] hover:underline underline-offset-4">Conditions d'Utilisation</a> de GuinéaJob.
            </p>
        </div>
    </div>

    <script>
        // Scripts simples pour améliorer l'UX des uploads
        document.getElementById('cv-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Sélectionnez votre CV";
            document.getElementById('cv-filename').textContent = fileName;
        });
        document.getElementById('lm-upload').addEventListener('change', function(e) {
            const fileName = e.target.files[0] ? e.target.files[0].name : "Lettre de motivation";
            document.getElementById('lm-filename').textContent = fileName;
        });
    </script>
</x-public-layout>
