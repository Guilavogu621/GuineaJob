<x-guest-layout>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Nouveau mot de passe</h1>
        <p class="text-gray-500 mt-2 text-sm">Choisissez un mot de passe robuste pour protéger votre accès à GuineaJob.</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}">
        @csrf

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div class="mb-5">
            <x-input-label for="email" :value="__('Email')" class="text-xs font-bold uppercase text-gray-400 mb-1" />
            <x-text-input id="email" class="block mt-1 w-full border-gray-200 bg-gray-50 rounded-xl py-3 px-4 text-gray-500" 
                        type="email" name="email" :value="old('email', $request->email)" required readonly />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mb-5">
            <x-input-label for="password" :value="__('Nouveau mot de passe')" class="text-xs font-bold uppercase text-gray-400 mb-1" />
            <x-text-input id="password" class="block mt-1 w-full border-gray-200 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4" 
                        type="password" name="password" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mb-8">
            <x-input-label for="password_confirmation" :value="__('Confirmer le mot de passe')" class="text-xs font-bold uppercase text-gray-400 mb-1" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full border-gray-200 focus:border-guinea-green focus:ring-guinea-green rounded-xl py-3 px-4"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" placeholder="••••••••" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <x-primary-button class="w-full justify-center bg-guinea-green hover:bg-guinea-green-light text-white py-4 rounded-xl text-base font-bold tracking-widest transition-all shadow-lg shadow-guinea-green/20">
            {{ __('RÉINITIALISER LE MOT DE PASSE') }}
        </x-primary-button>
    </form>
</x-guest-layout>

