@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'h-[44px] px-4 bg-white border border-[#D3D1C7] rounded-[10px] text-[15px] font-normal text-[#2C2C2A] placeholder:text-[#B5B4AA] focus:border-[#0F6E56] focus:ring-4 focus:ring-[#0F6E56]/10 focus:outline-none focus:bg-white transition-all duration-200 shadow-none w-full']) }}>
