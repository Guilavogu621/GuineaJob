<x-guest-layout>
    <div class="mb-4 text-center">
        <h2 class="text-2xl font-bold text-[#BA7517]">Sécurisez votre compte</h2>
        <p class="text-sm text-gray-600">C'est votre première connexion. Veuillez choisir un nouveau mot de passe personnel.</p>
    </div>

    @if(session('info'))
        <div class="mb-4 p-3 bg-[#FAEEDA] border-l-4 border-[#BA7517] text-[#633806] text-sm">
            {{ session('info') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
        @csrf

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirmer le nouveau mot de passe')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-6">
            <x-primary-button class="w-full justify-center bg-[#0F6E56] hover:bg-[#085041]">
                {{ __('Mettre à jour et accéder à mon espace') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
