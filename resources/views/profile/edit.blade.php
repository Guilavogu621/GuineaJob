<x-app-layout>
    <div class="py-12 bg-[#F1EFE8] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <!-- Header Section -->
            <div class="mb-10">
                <h2 class="text-3xl font-black text-[#2C2C2A] font-outfit tracking-tight">
                    Paramètres du <span class="text-[#0F6E56]">Profil</span>
                </h2>
                <p class="text-slate-500 font-medium mt-1">Gérez vos informations personnelles et la sécurité de votre compte.</p>
            </div>

            <div class="grid grid-cols-1 gap-8">
                <!-- Update Profile Info -->
                <div class="p-8 sm:p-10 bg-white shadow-sm border border-slate-100 rounded-[2.5rem] relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#0F6E56]/5 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="max-w-xl relative z-10">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Update Password -->
                <div class="p-8 sm:p-10 bg-white shadow-sm border border-slate-100 rounded-[2.5rem] relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-blue-50/50 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="max-w-xl relative z-10">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Delete Account -->
                <div class="p-8 sm:p-10 bg-[#FCEBEB]/30 shadow-sm border border-[#FCEBEB] rounded-[2.5rem] relative overflow-hidden group">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-[#FCEBEB]/20 rounded-full blur-2xl group-hover:scale-110 transition-transform duration-700"></div>
                    <div class="max-w-xl relative z-10">
                        @include('profile.partials.delete-user-form')
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
