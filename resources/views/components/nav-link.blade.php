@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-[#0F6E56] text-sm font-medium leading-5 text-[#2C2C2A] focus:outline-none focus:border-[#0A5A45] transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-[#888780] hover:text-[#0F6E56] hover:border-[#D3D1C7] focus:outline-none focus:text-[#0F6E56] focus:border-[#D3D1C7] transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
