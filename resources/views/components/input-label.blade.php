@props(['value'])

<label {{ $attributes->merge(['class' => 'block text-[14px] font-medium text-[#2C2C2A] mb-2']) }}>
    {{ $value ?? $slot }}
</label>
