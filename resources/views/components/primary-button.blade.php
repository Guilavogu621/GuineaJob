<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center justify-center px-6 py-2.5 h-[44px] bg-[#0F6E56] hover:bg-[#0A5A45] active:scale-[0.99] border-none rounded-[10px] text-[15px] font-medium text-white transition-all duration-200 cursor-pointer shadow-none']) }}>
    {{ $slot }}
</button>
