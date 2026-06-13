<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-5 py-2 bg-[#993C1D] text-white border-none hover:bg-[#7E3219] rounded-lg text-sm font-medium transition-all cursor-pointer shadow-none']) }}>
    {{ $slot }}
</button>
