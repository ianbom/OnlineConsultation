@props(['booking'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] mb-6">Linimasa Booking</h3>
    <div class="relative pl-4 border-l-2 border-[#e6e0e0] space-y-8">
        {{-- Permintaan Jadwal Ulang --}}
        @if($booking->reschedule_status === 'pending')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-amber-500 shadow-sm ring-2 ring-amber-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Permintaan Jadwal Ulang</p>
                <p class="text-xs text-[#83676c]">{{ $booking->updated_at->locale('id')->translatedFormat('d M, H:i') }} • Oleh {{ ucfirst($booking->reschedule_by ?? 'Klien') }}</p>

                <div class="mt-2 text-sm text-[#171213] bg-[#f8f6f6] p-3 rounded-lg border border-[#e6e0e0] space-y-2">
                    {{-- Jadwal Sebelumnya (Lama) --}}
                    @if($booking->previous_schedule_id && $booking->previousSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-red-400">event_busy</span>
                        <span class="text-[#83676c] line-through">
                            {{ \Carbon\Carbon::parse($booking->previousSchedule->date)->locale('id')->translatedFormat('d M Y') }},
                            {{ $booking->previousSchedule->start_time }} - {{ $booking->previousSchedule->end_time }}
                        </span>
                    </div>
                    @endif

                    {{-- Jadwal Kedua Sebelumnya (Lama) --}}
                    @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-red-400">event_busy</span>
                        <span class="text-[#83676c] line-through">
                            {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->locale('id')->translatedFormat('d M Y') }},
                            {{ $booking->previousSecondSchedule->start_time }} - {{ $booking->previousSecondSchedule->end_time }}
                        </span>
                    </div>
                    @endif

                    <div class="border-t border-[#e6e0e0] pt-2 mt-2"></div>

                    {{-- Jadwal Baru yang Diminta --}}
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-green-500">event_available</span>
                        <span class="text-[#171213] font-medium">
                            {{ \Carbon\Carbon::parse($booking->schedule->date)->locale('id')->translatedFormat('d M Y') }},
                            {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}
                        </span>
                    </div>

                    {{-- Jadwal Kedua Baru yang Diminta --}}
                    @if($booking->second_schedule_id && $booking->secondSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-green-500">event_available</span>
                        <span class="text-[#171213] font-medium">
                            {{ \Carbon\Carbon::parse($booking->secondSchedule->date)->locale('id')->translatedFormat('d M Y') }},
                            {{ $booking->secondSchedule->start_time }} - {{ $booking->secondSchedule->end_time }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Sesi Selesai --}}
        @if($booking->status === 'completed')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-blue-500 shadow-sm ring-2 ring-blue-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Sesi Selesai</p>
                <p class="text-xs text-[#83676c]">{{ $booking->completed_at ? \Carbon\Carbon::parse($booking->completed_at)->locale('id')->translatedFormat('d M, H:i') : $booking->updated_at->locale('id')->translatedFormat('d M, H:i') }}</p>
            </div>
        </div>
        @endif

        {{-- Pembayaran Terkonfirmasi --}}
        @if($booking->status === 'paid' || $booking->status === 'completed')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-green-500 shadow-sm ring-2 ring-green-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Pembayaran Terkonfirmasi</p>
                <p class="text-xs text-[#83676c]">{{ $booking->payment ? $booking->payment->created_at->locale('id')->translatedFormat('d M, H:i') : '-' }} • {{ $booking->payment->payment_method ?? 'Midtrans' }}</p>
            </div>
        </div>
        @endif

        {{-- Sesi Dibatalkan --}}
        @if($booking->status === 'cancelled')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-red-500 shadow-sm ring-2 ring-red-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Sesi Dibatalkan</p>
                <p class="text-xs text-[#83676c]">{{ $booking->cancelled_at ? \Carbon\Carbon::parse($booking->cancelled_at)->locale('id')->translatedFormat('d M, H:i') : $booking->updated_at->locale('id')->translatedFormat('d M, H:i') }} • Oleh {{ ucfirst($booking->cancelled_by ?? '-') }}</p>
            </div>
        </div>
        @endif

        {{-- Booking Dibuat --}}
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-gray-400 shadow-sm"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Booking Dibuat</p>
                <p class="text-xs text-[#83676c]">{{ $booking->created_at->locale('id')->translatedFormat('d M, H:i') }} • Oleh Sistem</p>
            </div>
        </div>
    </div>
</section>
