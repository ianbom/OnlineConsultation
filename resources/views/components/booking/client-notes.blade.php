@props(['notes'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[#7b1e2d]">notes</span>
        Catatan Klien
    </h3>
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <p class="text-sm text-[#171213]">{{ $notes ?? 'Tidak ada catatan dari klien.' }}</p>
    </div>
</section>
