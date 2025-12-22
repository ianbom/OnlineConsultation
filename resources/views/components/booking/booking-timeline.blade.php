@props(['booking'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] mb-6">Booking Timeline</h3>
    <div class="relative pl-4 border-l-2 border-[#e6e0e0] space-y-8">
        {{-- Reschedule Requested --}}
        @if($booking->reschedule_status === 'pending')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-amber-500 shadow-sm ring-2 ring-amber-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Reschedule Requested</p>
                <p class="text-xs text-[#83676c]">{{ $booking->updated_at->format('M d, h:i A') }} • By {{ ucfirst($booking->reschedule_by ?? 'Client') }}</p>

                <div class="mt-2 text-sm text-[#171213] bg-[#f8f6f6] p-3 rounded-lg border border-[#e6e0e0] space-y-2">
                    {{-- Previous Schedule (Old) --}}
                    @if($booking->previous_schedule_id && $booking->previousSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-red-400">event_busy</span>
                        <span class="text-[#83676c] line-through">
                            {{ \Carbon\Carbon::parse($booking->previousSchedule->date)->format('M d, Y') }},
                            {{ $booking->previousSchedule->start_time }} - {{ $booking->previousSchedule->end_time }}
                        </span>
                    </div>
                    @endif

                    {{-- Previous Second Schedule (Old) --}}
                    @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-red-400">event_busy</span>
                        <span class="text-[#83676c] line-through">
                            {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->format('M d, Y') }},
                            {{ $booking->previousSecondSchedule->start_time }} - {{ $booking->previousSecondSchedule->end_time }}
                        </span>
                    </div>
                    @endif

                    <div class="border-t border-[#e6e0e0] pt-2 mt-2"></div>

                    {{-- New Requested Schedule --}}
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-green-500">event_available</span>
                        <span class="text-[#171213] font-medium">
                            {{ \Carbon\Carbon::parse($booking->schedule->date)->format('M d, Y') }},
                            {{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}
                        </span>
                    </div>

                    {{-- New Requested Second Schedule --}}
                    @if($booking->second_schedule_id && $booking->secondSchedule)
                    <div class="flex items-center gap-2">
                        <span class="material-symbols-outlined text-[16px] text-green-500">event_available</span>
                        <span class="text-[#171213] font-medium">
                            {{ \Carbon\Carbon::parse($booking->secondSchedule->date)->format('M d, Y') }},
                            {{ $booking->secondSchedule->start_time }} - {{ $booking->secondSchedule->end_time }}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
        @endif

        {{-- Session Completed --}}
        @if($booking->status === 'completed')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-blue-500 shadow-sm ring-2 ring-blue-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Session Completed</p>
                <p class="text-xs text-[#83676c]">{{ $booking->completed_at ? \Carbon\Carbon::parse($booking->completed_at)->format('M d, h:i A') : $booking->updated_at->format('M d, h:i A') }}</p>
            </div>
        </div>
        @endif

        {{-- Payment Confirmed --}}
        @if($booking->status === 'paid' || $booking->status === 'completed')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-green-500 shadow-sm ring-2 ring-green-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Payment Confirmed</p>
                <p class="text-xs text-[#83676c]">{{ $booking->payment ? $booking->payment->created_at->format('M d, h:i A') : '-' }} • {{ $booking->payment->payment_method ?? 'Midtrans' }}</p>
            </div>
        </div>
        @endif

        {{-- Session Cancelled --}}
        @if($booking->status === 'cancelled')
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-red-500 shadow-sm ring-2 ring-red-100"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Session Cancelled</p>
                <p class="text-xs text-[#83676c]">{{ $booking->cancelled_at ? \Carbon\Carbon::parse($booking->cancelled_at)->format('M d, h:i A') : $booking->updated_at->format('M d, h:i A') }} • By {{ ucfirst($booking->cancelled_by ?? '-') }}</p>
            </div>
        </div>
        @endif

        {{-- Booking Created --}}
        <div class="relative">
            <div class="absolute -left-[23px] top-0 h-4 w-4 rounded-full border-2 border-white bg-gray-400 shadow-sm"></div>
            <div class="flex flex-col gap-1">
                <p class="text-sm font-bold text-[#171213]">Booking Created</p>
                <p class="text-xs text-[#83676c]">{{ $booking->created_at->format('M d, h:i A') }} • By System</p>
            </div>
        </div>
    </div>
</section>
