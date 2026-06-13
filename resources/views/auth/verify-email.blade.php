<x-guest-layout>
    <div class="mb-10">
        <div class="w-16 h-16 bg-[#0F6E56]/10 text-[#0F6E56] rounded-2xl flex items-center justify-center mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
        </div>
        <h1 class="text-3xl font-black text-[#2C2C2A] tracking-tight">Vérifiez votre email</h1>
        <p class="text-gray-500 mt-4 text-sm font-medium leading-relaxed">
            Merci pour votre inscription ! Pour commencer, veuillez confirmer votre adresse email en cliquant sur le lien que nous venons de vous envoyer.
        </p>
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-8 p-4 bg-[#E1F5EE] text-[#0F6E56] font-black text-xs rounded-2xl border border-[#E1F5EE] flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ __('Un nouveau lien de vérification a été envoyé à l\'adresse email fournie.') }}
        </div>
    @endif

    <div class="mt-4 flex flex-col gap-6">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf
            <x-primary-button class="w-full justify-center py-4">
                {{ __('Renvoyer l\'email de vérification') }}
            </x-primary-button>
        </form>

        <form method="POST" action="{{ route('logout') }}" class="text-center">
            @csrf
            <button type="submit" class="text-xs font-black text-slate-400 uppercase tracking-widest hover:text-[#993C1D] transition-colors">
                {{ __('Se déconnecter') }}
            </button>
        </form>
    </div>
</x-guest-layout>
