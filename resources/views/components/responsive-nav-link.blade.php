@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full ps-3 pe-4 py-2 border-l-4 border-[#0F6E56] text-start text-base font-medium text-[#0F6E56] bg-[#E1F5EE] focus:outline-none focus:text-[#0A5A45] focus:bg-[#E1F5EE] focus:border-[#0A5A45] transition duration-150 ease-in-out'
            : 'block w-full ps-3 pe-4 py-2 border-l-4 border-transparent text-start text-base font-medium text-[#888780] hover:text-[#0F6E56] hover:bg-[#F1EFE8] hover:border-[#D3D1C7] focus:outline-none focus:text-[#0F6E56] focus:bg-[#F1EFE8] focus:border-[#D3D1C7] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
