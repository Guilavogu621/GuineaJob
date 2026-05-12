<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Récupération</h1>
        <p class="text-gray-500 mt-2 text-sm">
            {{ __('Pas de panique. Indiquez-nous votre adresse e-mail et nous vous enverrons un lien de réinitialisation.') }}
        </p>
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('password.email') }}">
        @csrf

        <!-- Email Address -->
        <div class="mb-6">
            <x-input-label for="email" :value="__('Votre Email')" class="text-xs font-bold uppercase text-gray-400 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4" 
                        type="email" name="email" :value="old('email')" required autofocus placeholder="nom@entreprise.gn" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div class="flex flex-col gap-4">
            <x-primary-button class="w-full justify-center bg-guinea-green hover:bg-guinea-green-light text-white py-4 rounded-xl text-base font-bold tracking-widest transition-all shadow-lg shadow-guinea-green/20">
                {{ __('ENVOYER LE LIEN') }}
            </x-primary-button>

            <div class="mt-4 text-center">
                <a href="{{ route('login') }}" class="text-sm text-gray-500 font-medium hover:text-guinea-green transition-colors">
                    <i class="fas fa-arrow-left mr-1"></i> Retour à la connexion
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>

