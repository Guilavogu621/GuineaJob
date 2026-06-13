<x-guest-layout>
    <div class="mb-10">
        <div class="w-16 h-16 bg-[#FAEEDA] text-[#BA7517] rounded-2xl flex items-center justify-center mb-6 border border-[#FAEEDA]">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
        </div>
        <h1 class="text-3xl font-black text-[#2C2C2A] tracking-tight">Sécurisez votre compte</h1>
        <p class="text-gray-500 mt-4 text-sm font-medium leading-relaxed">
            C'est votre première connexion. Veuillez choisir un nouveau mot de passe personnel et robuste.
        </p>
    </div>

    @if(session('info'))
        <div class="mb-8 p-4 bg-[#FAEEDA] text-[#633806] font-black text-xs rounded-2xl border border-[#FAEEDA] flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('info') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.force.update') }}">
        @csrf

        <!-- Password -->
        <div class="mb-6">
            <x-input-label for="password" :value="__('Nouveau mot de passe')" />
            <x-text-input id="password" class="block w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-10">
            <x-input-label for="password_confirmation" :value="__('Confirmer le nouveau mot de passe')" />
            <x-text-input id="password_confirmation" class="block w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password"
                            placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center py-4">
            {{ __('Mettre à jour mon mot de passe') }}
        </x-primary-button>
    </form>
</x-guest-layout>
