<x-guest-layout>
    <div class="mb-8">
        <h1 class="text-2xl font-medium text-[#2C2C2A]">
            Mot de passe oublié ?
        </h1>
        <p class="text-[15px] text-[#888780] mt-2 leading-relaxed">
            Pas de panique. Indiquez votre e-mail et nous vous enverrons un lien de réinitialisation sécurisé.
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-6" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Adresse email')" />
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-[#888780]">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <x-text-input
                    id="email"
                    type="email"
                    name="email"
                    :value="old('email')"
                    required
                    autofocus
                    class="block w-full pl-9 pr-3 py-2"
                    placeholder="nom@exemple.gn"
                />
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-1" />
        </div>

        <div class="space-y-6">
            <button type="submit" class="btn btn-primary w-full justify-center py-2.5">
                {{ __('Envoyer le lien') }}
            </button>

            <div class="text-center mt-6">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-[15px] text-[#0F6E56] hover:underline font-medium">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Retour à la connexion
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
