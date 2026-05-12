<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Connexion</h1>
        <p class="text-gray-500 mt-2 text-sm">Entrez votre email et mot de passe pour accéder à votre espace.</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Votre Email')" class="text-xs font-bold uppercase text-gray-400 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4" 
                        type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nom@entreprise.gn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-4">
            <div class="flex justify-between items-center mb-1">
                <x-input-label for="password" :value="__('Mot de passe')" class="text-xs font-bold uppercase text-gray-400" />
                @if (Route::has('password.request'))
                    <a class="text-xs text-guinea-gold hover:text-orange-700 font-bold" href="{{ route('password.request') }}">
                        {{ __('Mot de passe oublié ?') }}
                    </a>
                @endif
            </div>

            <x-text-input id="password" class="block w-full border-gray-200 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4"
                            type="password"
                            name="password"
                            required autocomplete="current-password"
                            placeholder="••••••••" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mb-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded-md border-gray-300 text-guinea-green shadow-sm focus:ring-guinea-green w-5 h-5" name="remember">
                <span class="ms-3 text-sm text-gray-500 font-medium">{{ __('Se souvenir de moi') }}</span>
            </label>
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center bg-guinea-green hover:bg-guinea-green-light text-white py-4 rounded-xl text-base font-bold tracking-widest transition-all shadow-lg shadow-guinea-green/20">
                {{ __('SE CONNECTER') }}
            </x-primary-button>

            <!-- Divider -->
            <div class="relative my-4">
                <div class="absolute inset-0 flex items-center">
                    <div class="w-full border-t border-gray-100"></div>
                </div>
                <div class="relative flex justify-center text-sm">
                    <span class="px-2 bg-white text-gray-400 font-medium italic underline decoration-guinea-gold decoration-2">GuinéaJob</span>
                </div>
            </div>

            <!-- Bouton Secondaire aux couleurs du projet -->
            <button type="button" class="w-full flex items-center justify-center gap-3 px-4 py-3 border border-gray-200 rounded-xl hover:bg-gray-50 transition-colors font-bold text-sm text-gray-700">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                CONTINUER AVEC GOOGLE
            </button>
        </div>

        <div class="mt-8 text-center">
            <p class="text-sm text-gray-500 font-medium">
                Pas encore inscrit ? 
                <a href="{{ route('register') }}" class="text-gray-900 font-bold hover:underline">Créer un compte</a>
            </p>
        </div>
    </form>
</x-guest-layout>
