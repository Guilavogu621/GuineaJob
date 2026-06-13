<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-medium text-[#2C2C2A]">
            Créer un compte
        </h1>
        <p class="text-[15px] text-[#888780] mt-2">
            Rejoignez l'écosystème RH numéro 1 en Guinée.
        </p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-5" x-data="{
        role: '{{ old('role', 'candidat') }}',
        roleDropdownOpen: false,
        roleLabels: {
            'candidat': 'Chercheur d\'emploi (Candidat)',
            'prestataire': 'Prestataire (Entreprise)'
        },
        selectRole(value) {
            this.role = value;
            this.roleDropdownOpen = false;
        }
    }">
        @csrf

        <!-- Names -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label for="prenom" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Prénom') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <input
                        id="prenom"
                        type="text"
                        name="prenom"
                        value="{{ old('prenom') }}"

                        autofocus
                        class="block w-full auth-input focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="Ex: Moussa"
                    />
                </div>
                <x-input-error :messages="$errors->get('prenom')" class="mt-1" />
            </div>

            <div>
                <label for="nom" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Nom') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                        </svg>
                    </div>
                    <input
                        id="nom"
                        type="text"
                        name="nom"
                        value="{{ old('nom') }}"

                        class="block w-full auth-input focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="Ex: Camara"
                    />
                </div>
                <x-input-error :messages="$errors->get('nom')" class="mt-1" />
            </div>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                {{ __('Adresse email') }}
            </label>
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                    <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="username"
                    class="block w-full auth-input focus:outline-none"
                    style="padding-left: 48px !important;"
                    placeholder="nom@exemple.gn"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        <!-- Role -->
        <div>
            <label for="role-button" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                {{ __('Type de compte') }}
            </label>
            <input type="hidden" name="role" :value="role" value="{{ old('role', 'candidat') }}" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                    <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-6h2v6zm0-8h-2V7h2v2z"/>
                    </svg>
                </div>
                <!-- Bouton qui ouvre le dropdown -->
                <button
                    id="role-button"
                    type="button"
                    @click="roleDropdownOpen = !roleDropdownOpen"
                    @click.away="roleDropdownOpen = false"
                    class="block w-full auth-input focus:outline-none cursor-pointer text-left"
                    style="padding-left: 48px !important; padding-right: 48px !important;"
                    aria-haspopup="listbox"
                    :aria-expanded="roleDropdownOpen"
                >
                    <span x-text="roleLabels[role]"></span>
                </button>
                <!-- Flèche -->
                <div class="absolute inset-y-0 right-0 flex items-center pr-4 pointer-events-none text-[#0F6E56]">
                    <svg class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': roleDropdownOpen }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </div>
                <!-- Options dropdown -->
                <div
                    x-show="roleDropdownOpen"
                    x-transition:enter="transition ease-out duration-150"
                    x-transition:enter-start="opacity-0 -translate-y-1"
                    x-transition:enter-end="opacity-100 translate-y-0"
                    x-transition:leave="transition ease-in duration-100"
                    x-transition:leave-start="opacity-100 translate-y-0"
                    x-transition:leave-end="opacity-0 -translate-y-1"
                    class="absolute left-0 right-0 mt-2 bg-white border-2 border-[#0F6E56] rounded-2xl shadow-lg z-50 overflow-hidden"
                    style="display: none;"
                >
                    <button
                        type="button"
                        @click="selectRole('candidat')"
                        class="w-full text-left px-5 py-3 text-[15px] hover:bg-[#E1F5EE] transition-colors"
                        :class="{ 'bg-[#E1F5EE] text-[#0F6E56] font-medium': role === 'candidat', 'text-[#2C2C2A]': role !== 'candidat' }"
                    >
                        Chercheur d'emploi (Candidat)
                    </button>
                    <button
                        type="button"
                        @click="selectRole('prestataire')"
                        class="w-full text-left px-5 py-3 text-[15px] hover:bg-[#E1F5EE] transition-colors border-t border-[#D3D1C7]/50"
                        :class="{ 'bg-[#E1F5EE] text-[#0F6E56] font-medium': role === 'prestataire', 'text-[#2C2C2A]': role !== 'prestataire' }"
                    >
                        Prestataire (Entreprise)
                    </button>
                </div>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-1.5" />
        </div>

        <!-- Informations Prestataire -->
        <div x-show="role === 'prestataire'" x-cloak class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="md:col-span-2">
                <label for="raison_sociale" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Raison sociale') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm10 12h-2v-2h2v2zm0-4h-2v-2h2v2zm0-4h-2V9h2v2zm0-4h-2V5h2v2zm6 12h-2v-2h2v2zm0-4h-2v-2h2v2z"/>
                        </svg>
                    </div>
                    <input
                        id="raison_sociale"
                        type="text"
                        name="raison_sociale"
                        value="{{ old('raison_sociale') }}"
                        class="block w-full auth-input focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="Ex: Guinée Services SARL"
                    />
                </div>
                <x-input-error :messages="$errors->get('raison_sociale')" class="mt-1" />
            </div>
            <div>
                <label for="secteur" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Secteur d\'activité') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M21.41 11.58l-9-9C12.05 2.22 11.55 2 11 2H4c-1.1 0-2 .9-2 2v7c0 .55.22 1.05.59 1.42l9 9c.36.36.86.58 1.41.58.55 0 1.05-.22 1.41-.59l7-7c.37-.36.59-.86.59-1.41 0-.55-.23-1.06-.59-1.42zM5.5 8.25c-.97 0-1.75-.78-1.75-1.75s.78-1.75 1.75-1.75 1.75.78 1.75 1.75-.78 1.75-1.75 1.75z"/>
                        </svg>
                    </div>
                    <input
                        id="secteur"
                        type="text"
                        name="secteur"
                        value="{{ old('secteur') }}"
                        class="block w-full auth-input focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="Ex: BTP, Informatique"
                    />
                </div>
                <x-input-error :messages="$errors->get('secteur')" class="mt-1" />
            </div>
            <div>
                <label for="telephone" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Téléphone') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                        </svg>
                    </div>
                    <input
                        id="telephone"
                        type="tel"
                        name="telephone"
                        value="{{ old('telephone') }}"
                        class="block w-full auth-input focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="Ex: +224 620 00 00 00"
                    />
                </div>
                <x-input-error :messages="$errors->get('telephone')" class="mt-1" />
            </div>
        </div>

        <!-- Password -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 !mt-8">
            <div x-data="{ showPassword: false }">
                <label for="password" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Mot de passe') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                        </svg>
                    </div>
                    <input
                        id="password"
                        x-bind:type="showPassword ? 'text' : 'password'"
                        name="password"

                        autocomplete="new-password"
                        class="block w-full auth-input pr-12 focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="••••••••"
                    />
                    <button
                        type="button"
                        @click="showPassword = !showPassword"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#0F6E56] hover:text-[#0A5A45] focus:outline-none transition-colors"
                        aria-label="Afficher le mot de passe"
                    >
                        <svg x-show="!showPassword" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        <svg x-show="showPassword" style="display:none;" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0-4.5c-5 0-9.27 3.11-11 7.5 1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            <div x-data="{ showPasswordConf: false }">
                <label for="password_confirmation" class="block text-[12.5px] font-medium text-[#2C2C2A] mb-1.5 tracking-[0.1px]">
                    {{ __('Confirmation') }}
                </label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                        <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                        </svg>
                    </div>
                    <input
                        id="password_confirmation"
                        x-bind:type="showPasswordConf ? 'text' : 'password'"
                        name="password_confirmation"

                        autocomplete="new-password"
                        class="block w-full auth-input pr-12 focus:outline-none"
                        style="padding-left: 48px !important;"
                        placeholder="••••••••"
                    />
                    <button
                        type="button"
                        @click="showPasswordConf = !showPasswordConf"
                        class="absolute right-4 top-1/2 -translate-y-1/2 text-[#0F6E56] hover:text-[#0A5A45] focus:outline-none transition-colors"
                        aria-label="Afficher le mot de passe"
                    >
                        <svg x-show="!showPasswordConf" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                        </svg>
                        <svg x-show="showPasswordConf" style="display:none;" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zm0-4.5c-5 0-9.27 3.11-11 7.5 1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z"/>
                        </svg>
                    </button>
                </div>
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full py-[11px] mt-2 bg-[#0F6E56] hover:bg-[#0A5A45] active:scale-[0.99] text-white text-[14.5px] font-medium rounded-[10px] transition duration-150 tracking-[0.1px] flex justify-center items-center gap-2">
            {{ __('Créer mon compte') }} <span aria-hidden="true">&rarr;</span>
        </button>

        <div class="mt-6 text-center">
            <p class="text-[15px] text-[#888780]">
                Déjà inscrit sur GuinéaJob ?
                <a href="{{ route('login') }}" class="text-[#0F6E56] hover:underline">
                    Se connecter
                </a>
            </p>
        </div>
    </form>
</x-guest-layout>
