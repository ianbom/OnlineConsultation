@props(['booking', 'defaultTab' => 'payment'])

<div class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm overflow-hidden" x-data="{ activeTab: '{{ $defaultTab }}' }">
    <!-- Header Tab -->
    <div class="flex border-b border-[#e6e0e0] px-6 overflow-x-auto">
        <button @click="activeTab = 'payment'" :class="activeTab === 'payment' ? 'text-[#7b1e2d] border-[#7b1e2d]' : 'text-[#83676c] border-transparent hover:text-[#171213]'" class="px-6 py-4 text-sm font-bold border-b-2 transition-colors whitespace-nowrap flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">payments</span>
            Detail Pembayaran
        </button>
        <button @click="activeTab = 'schedule'" :class="activeTab === 'schedule' ? 'text-[#7b1e2d] border-[#7b1e2d]' : 'text-[#83676c] border-transparent hover:text-[#171213]'" class="px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">calendar_month</span>
            Info Jadwal
        </button>
        <button @click="activeTab = 'cancel'" :class="activeTab === 'cancel' ? 'text-[#7b1e2d] border-[#7b1e2d]' : 'text-[#83676c] border-transparent hover:text-[#171213]'" class="px-6 py-4 text-sm font-medium border-b-2 transition-colors whitespace-nowrap flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px]">block</span>
            Pembatalan & Refund
        </button>
    </div>

    <!-- Tab Detail Pembayaran -->
    <div x-show="activeTab === 'payment'" class="p-6">
        <x-booking.tabs.payment-details :payment="$booking->payment" :booking="$booking" />
    </div>

    <!-- Tab Info Jadwal -->
    <div x-show="activeTab === 'schedule'" class="p-6" style="display: none;">
        <x-booking.tabs.schedule-details :booking="$booking" />
    </div>

    <!-- Tab Pembatalan & Refund -->
    <div x-show="activeTab === 'cancel'" class="p-6" style="display: none;">
        <x-booking.tabs.cancel-refund :booking="$booking" />
    </div>
</div>
