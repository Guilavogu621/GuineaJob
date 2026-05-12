<div {{ $attributes->merge(['class' => 'flex items-center gap-3']) }}>
    <!-- Icône GJ (Section 8.1 CDC) -->
    <div class="flex items-center justify-center bg-[#0F6E56] rounded-[10px] w-10 h-10 shrink-0">
        <span class="text-white font-bold text-lg">GJ</span>
    </div>

    <!-- Texte GuinéaJob -->
    <div class="flex flex-col">
        <div class="flex items-baseline">
            <span class="text-[#0F6E56] font-bold text-2xl leading-none">Guinéa</span>
            <span class="text-[#0F6E56] font-normal text-2xl leading-none">Job</span>
        </div>
        <!-- Bande tricolore guinéenne (Section 8.1) -->
        <div class="flex h-[3px] w-full mt-1">
            <div class="bg-[#993C1D] flex-1"></div> <!-- Rouge -->
            <div class="bg-[#BA7517] flex-1"></div> <!-- Or -->
            <div class="bg-[#0F6E56] flex-1"></div> <!-- Vert -->
        </div>
    </div>
</div>
