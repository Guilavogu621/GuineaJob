<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-5 py-2 bg-transparent text-[#0F6E56] border border-[#0F6E56] hover:bg-[#E1F5EE] rounded-lg text-sm font-medium transition-all cursor-pointer shadow-none']) }}>
    {{ $slot }}
</button>
