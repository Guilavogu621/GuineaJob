{{-- ============================================================
     resources/views/auth/login.blade.php
     Page de connexion — injectée dans x-guest (guest.blade.php)
     ============================================================ --}}
<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- Badge connexion sécurisée --}}
    <div class="mb-5">
        <span class="inline-flex items-center gap-1.5 text-[11.5px] font-medium
                     text-[#0F6E56] bg-[#E1F5EE] rounded-full px-3 py-1">
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24"
                 stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
            </svg>
            Connexion sécurisée
        </span>
    </div>



    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        {{-- ── Champ Email ── --}}
        <div>
            <div class="relative">
                {{-- Icône utilisateur (comme dans la maquette) --}}
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                    <svg class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Adresse email"
                    class="block w-full auth-input transition duration-150 focus:outline-none"
                    style="padding-left: 48px !important;"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1.5" />
        </div>

        {{-- ── Champ Mot de passe avec toggle affichage ── --}}
        <div x-data="{ showPassword: false }">
            <div class="relative">
                {{-- Icône cadenas --}}
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-[#0F6E56]">
                    <svg class="w-[18px] h-[18px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M18 8h-1V6c0-2.76-2.24-5-5-5S7 3.24 7 6v2H6c-1.1 0-2 .9-2 2v10c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2V10c0-1.1-.9-2-2-2zM9 6c0-1.66 1.34-3 3-3s3 1.34 3 3v2H9V6zm9 14H6V10h12v10zm-6-3c1.1 0 2-.9 2-2s-.9-2-2-2-2 .9-2 2 .9 2 2 2z"/>
                    </svg>
                </div>
                <input
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Mot de passe"
                    class="block w-full auth-input pr-12 transition duration-150 focus:outline-none"
                    style="padding-left: 48px !important;"
                />
                {{-- Bouton toggle affichage mot de passe --}}
                <button
                    type="button"
                    @click="showPassword = !showPassword"
                    class="absolute right-4 top-1/2 -translate-y-1/2 text-[#0F6E56] hover:text-[#0A5A45] focus:outline-none transition-colors"
                    aria-label="Afficher le mot de passe"
                >
                    {{-- Icône œil ouvert --}}
                    <svg x-show="!showPassword" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 4.5C7 4.5 2.73 7.61 1 12c1.73 4.39 6 7.5 11 7.5s9.27-3.11 11-7.5c-1.73-4.39-6-7.5-11-7.5zM12 17c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5zm0-8c-1.66 0-3 1.34-3 3s1.34 3 3 3 3-1.34 3-3-1.34-3-3-3z"/>
                    </svg>
                    {{-- Icône œil barré --}}
                    <svg x-show="showPassword" style="display:none;" class="w-[20px] h-[20px]" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 7c2.76 0 5 2.24 5 5 0 .65-.13 1.26-.36 1.83l2.92 2.92c1.51-1.26 2.7-2.89 3.43-4.75-1.73-4.39-6-7.5-11-7.5-1.4 0-2.74.25-3.98.7l2.16 2.16C10.74 7.13 11.35 7 12 7zM2.01 3.87l2.68 2.68C3.06 7.83 1.77 9.53 1 12c1.73 4.39 6 7.5 11 7.5 1.55 0 3.03-.3 4.38-.84l4.25 4.25 1.27-1.27-19.89-19.89-1.00 1.12zM12 17c-2.76 0-5-2.24-5-5 0-.84.22-1.62.59-2.29l6.12 6.12c-.67.37-1.45.59-2.29.59zM15.42 15.42l-1.41-1.41L11.59 11.59 10.17 10.17c.54-.53 1.26-.88 2.05-.88 1.66 0 3 1.34 3 3 0 .79-.35 1.51-.88 2.05z"/>
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-1.5" />
        </div>

        {{-- ── Options : Se souvenir / Mot de passe oublié ── --}}
        <div class="flex items-center justify-between pt-1 px-2">
            {{-- Case à cocher "Se souvenir de moi" --}}
            <label for="remember_me" class="inline-flex items-center gap-2 cursor-pointer">
                <input
                    id="remember_me"
                    type="checkbox"
                    name="remember"
                    class="w-[15px] h-[15px] rounded cursor-pointer accent-[#0F6E56]"
                >
                <span class="text-[15px] text-[#2C2C2A]">
                    {{ __('Se souvenir de moi') }}
                </span>
            </label>

            {{-- Lien mot de passe oublié --}}
            @if (Route::has('password.request'))
                <a class="text-[15px] font-medium text-[#0F6E56] hover:underline"
                   href="{{ route('password.request') }}">
                    {{ __('Mot de passe oublié ?') }}
                </a>
            @endif
        </div>

        {{-- ── Bouton de connexion principal ── --}}
        <button
            type="submit"
            class="w-full h-[52px] mt-4 bg-[#0F6E56] hover:bg-[#0A5A45]
                               active:scale-[0.99] text-white text-[16px] font-medium tracking-wide uppercase
                               rounded-full transition duration-150 shadow-md"
        >
            {{ __('SE CONNECTER') }}
        </button>

        {{-- ── Séparateur "ou continuer avec" ── --}}
        <div class="relative flex items-center gap-3 py-1">
            <div class="flex-grow h-px bg-black/[0.07]"></div>
            <span class="text-[15px] text-[#B4B2A9] whitespace-nowrap">ou continuer avec</span>
            <div class="flex-grow h-px bg-black/[0.07]"></div>
        </div>

        {{-- ── Bouton Google OAuth ── --}}
        <button
            type="button"
            class="w-full py-[10px] flex items-center justify-center gap-2 bg-white
                   border border-black/[0.08] rounded-[10px] text-[15px] font-medium
                   text-[#2C2C2A] hover:bg-[#F1EFE8] hover:border-black/[0.14] transition duration-150"
        >
            {{-- Logo Google SVG officiel --}}
            <svg class="w-4 h-4" viewBox="0 0 24 24">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
            </svg>
            {{ __('Continuer avec Google') }}
        </button>

    </form>

    {{-- ── Lien vers la page d'inscription ── --}}
    <div class="mt-6 text-center">
        <p class="text-[15px] text-[#888780]">
            {{ __('Pas encore de compte ?') }}
            <a href="{{ route('register') }}"
               class="text-[#0F6E56] font-medium hover:underline">
                {{ __('Créer un compte') }}
            </a>
        </p>
    </div>

</x-guest-layout>
