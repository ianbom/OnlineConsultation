@props(['booking'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm overflow-hidden">
    <div class="bg-[#7b1e2d]/5 p-4 border-b border-[#e6e0e0] flex items-center justify-between">
        <h3 class="text-base font-bold text-[#171213] flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d]">calendar_month</span>
            Jadwal
        </h3>
    </div>
    <div class="p-6 space-y-6">
        {{-- Jadwal Utama --}}
        <div class="flex items-start gap-4">
            <div class="flex flex-col items-center justify-center w-14 h-14 bg-[#f8f6f6] rounded-xl border border-[#e6e0e0] text-center shrink-0">
                <span class="text-xs font-bold text-[#7b1e2d] uppercase">{{ \Carbon\Carbon::parse($booking->schedule->date)->locale('id')->translatedFormat('M') }}</span>
                <span class="text-xl font-black text-[#171213]">{{ \Carbon\Carbon::parse($booking->schedule->date)->format('d') }}</span>
            </div>
            <div>
                <p class="text-lg font-bold text-[#171213]">{{ \Carbon\Carbon::parse($booking->schedule->date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                <p class="text-[#83676c]">{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</p>
            </div>
        </div>

        {{-- Jadwal Kedua --}}
        @if ($booking->secondSchedule)
        <div class="flex items-start gap-4">
            <div class="flex flex-col items-center justify-center w-14 h-14 bg-[#f8f6f6] rounded-xl border border-[#e6e0e0] text-center shrink-0">
                <span class="text-xs font-bold text-[#7b1e2d] uppercase">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->locale('id')->translatedFormat('M') }}</span>
                <span class="text-xl font-black text-[#171213]">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->format('d') }}</span>
            </div>
            <div>
                <p class="text-lg font-bold text-[#171213]">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->locale('id')->translatedFormat('l, d F Y') }}</p>
                <p class="text-[#83676c]">{{ $booking->secondSchedule->start_time }} - {{ $booking->secondSchedule->end_time }}</p>
            </div>
        </div>
        @endif

        {{-- Info Jadwal Sebelumnya --}}
        @if($booking->previous_schedule_id && $booking->previousSchedule)
        <div class="border-t border-[#e6e0e0] pt-4">
            <p class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-3">Jadwal Sebelumnya</p>
            <div class="flex items-center gap-3 bg-[#f8f6f6] p-3 rounded-xl border border-[#e6e0e0]">
                <div class="flex flex-col items-center justify-center w-12 h-12 bg-white rounded-lg border border-[#e6e0e0] text-center shrink-0">
                    <span class="text-[10px] font-bold text-[#7b1e2d] uppercase">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->locale('id')->translatedFormat('M') }}</span>
                    <span class="text-base font-black text-[#171213]">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->format('d') }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-[#171213] line-through">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->locale('id')->translatedFormat('l, d M Y') }}</p>
                    <p class="text-xs text-[#83676c] line-through">{{ $booking->previousSchedule->start_time }} - {{ $booking->previousSchedule->end_time }}</p>
                </div>
            </div>
        </div>
        @endif

        {{-- Info Jadwal Kedua Sebelumnya --}}
        @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
        <div class="border-t border-[#e6e0e0] pt-4">
            <div class="flex items-center gap-3 bg-[#f8f6f6] p-3 rounded-xl border border-[#e6e0e0]">
                <div class="flex flex-col items-center justify-center w-12 h-12 bg-white rounded-lg border border-[#e6e0e0] text-center shrink-0">
                    <span class="text-[10px] font-bold text-[#7b1e2d] uppercase">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->locale('id')->translatedFormat('M') }}</span>
                    <span class="text-base font-black text-[#171213]">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->format('d') }}</span>
                </div>
                <div>
                    <p class="text-sm font-medium text-[#171213] line-through">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->locale('id')->translatedFormat('l, d M Y') }}</p>
                    <p class="text-xs text-[#83676c] line-through">{{ $booking->previousSecondSchedule->start_time }} - {{ $booking->previousSecondSchedule->end_time }}</p>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
