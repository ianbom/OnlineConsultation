@props(['booking', 'showActions' => true])

@if($booking->reschedule_status !== 'none')
@php
    $mainAvailable = $booking->schedule?->is_available;
    $secondAvailable = $booking->secondSchedule?->is_available;

    $anyUnavailable =
        ($booking->schedule && !$booking->schedule->is_available) ||
        ($booking->secondSchedule && !$booking->secondSchedule->is_available);

    $allAvailable =
        ($booking->schedule && $booking->schedule->is_available) &&
        (!$booking->secondSchedule || $booking->secondSchedule->is_available);
@endphp

<section class="bg-white rounded-2xl border border-amber-200 shadow-sm overflow-hidden">
    <div class="bg-amber-50 p-4 border-b border-amber-200 flex items-center justify-between">
        <h3 class="text-base font-bold text-amber-800 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-600">event_repeat</span>
            Informasi Jadwal Ulang
        </h3>
        <span class="px-3 py-1 rounded-full text-xs font-semibold
            @if($booking->reschedule_status === 'pending') bg-yellow-100 text-yellow-800 border border-yellow-200
            @elseif($booking->reschedule_status === 'approved') bg-green-100 text-green-800 border border-green-200
            @elseif($booking->reschedule_status === 'rejected') bg-red-100 text-red-800 border border-red-200
            @else bg-gray-100 text-gray-800 border border-gray-200
            @endif">
            @if($booking->reschedule_status === 'pending') Menunggu
            @elseif($booking->reschedule_status === 'approved') Disetujui
            @elseif($booking->reschedule_status === 'rejected') Ditolak
            @else {{ ucfirst($booking->reschedule_status) }}
            @endif
        </span>
    </div>
    <div class="p-6">
        {{-- Alert Status Ketersediaan Jadwal --}}
        @if($booking->reschedule_status === 'pending' && $anyUnavailable)
        <div class="p-3 bg-red-50 border border-red-200 rounded-xl mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-red-500">warning</span>
            <p class="text-sm text-red-700">Jadwal yang diminta tidak tersedia. Silakan hubungi klien untuk memilih jadwal lain.</p>
        </div>
        @elseif($booking->reschedule_status === 'pending' && $allAvailable)
        <div class="p-3 bg-green-50 border border-green-200 rounded-xl mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-green-500">check_circle</span>
            <p class="text-sm text-green-700">Jadwal yang diminta tersedia. Anda bisa menyetujui permintaan ini.</p>
        </div>
        @endif

        {{-- Info Grid --}}
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div class="bg-[#f8f6f6] p-3 rounded-xl border border-[#e6e0e0]">
                <p class="text-xs text-[#83676c] mb-1">Diminta Oleh</p>
                <p class="text-sm font-semibold text-[#171213]">{{ ucfirst($booking->reschedule_by ?? $booking->reschedule_requested_by ?? '-') }}</p>
            </div>
            <div class="bg-[#f8f6f6] p-3 rounded-xl border border-[#e6e0e0]">
                <p class="text-xs text-[#83676c] mb-1">Status</p>
                <p class="text-sm font-semibold text-[#171213]">
                    @if($booking->reschedule_status === 'pending') Menunggu
                    @elseif($booking->reschedule_status === 'approved') Disetujui
                    @elseif($booking->reschedule_status === 'rejected') Ditolak
                    @else {{ ucfirst($booking->reschedule_status) }}
                    @endif
                </p>
            </div>
        </div>

        {{-- APPROVE / REJECT BUTTONS --}}
        @if($showActions && $booking->reschedule_status === 'pending')
        <div class="border-t border-[#e6e0e0] pt-4">
            <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-3">Aksi</p>
            <div class="flex flex-col gap-3">
                {{-- Approve Button --}}
                <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="statusReschedule" value="approved">
                    <button
                        type="submit"
                        class="w-full h-11 rounded-xl bg-green-600 text-white text-sm font-bold shadow-md hover:bg-green-700 transition-colors flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed"
                        @if($anyUnavailable) disabled @endif
                    >
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Setujui Jadwal Ulang
                    </button>
                </form>

                {{-- Reject Form --}}
                <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}" class="space-y-2">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="statusReschedule" value="rejected">
                    <input
                        type="text"
                        name="rejection_reason"
                        placeholder="Alasan penolakan (opsional)"
                        class="w-full h-11 px-4 border border-[#e6e0e0] rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-red-200 focus:border-red-400"
                    >
                    <button
                        type="submit"
                        class="w-full h-11 rounded-xl bg-red-600 text-white text-sm font-bold shadow-md hover:bg-red-700 transition-colors flex items-center justify-center gap-2"
                    >
                        <span class="material-symbols-outlined text-[18px]">cancel</span>
                        Tolak Jadwal Ulang
                    </button>
                </form>
            </div>
        </div>
        @endif
    </div>
</section>
@endif
