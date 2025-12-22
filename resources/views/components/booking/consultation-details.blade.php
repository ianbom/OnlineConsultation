@props(['booking'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] flex items-center gap-2 mb-6">
        <span class="material-symbols-outlined text-[#7b1e2d]">info</span>
        Session Details
    </h3>
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-6">
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0] text-center">
            <p class="text-xs text-[#83676c] mb-1">Type</p>
            <p class="font-bold text-[#171213] flex items-center justify-center gap-1">
                @if($booking->consultation_type === 'online')
                <span class="material-symbols-outlined text-[18px]">videocam</span>
                @else
                <span class="material-symbols-outlined text-[18px]">location_on</span>
                @endif
                {{ ucfirst($booking->consultation_type) }}
            </p>
        </div>
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0] text-center">
            <p class="text-xs text-[#83676c] mb-1">Duration</p>
            <p class="font-bold text-[#171213] flex items-center justify-center gap-1">
                <span class="material-symbols-outlined text-[18px]">timer</span> {{ $booking->duration_hours }} Hour(s)
            </p>
        </div>
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0] text-center">
            <p class="text-xs text-[#83676c] mb-1">Price</p>
            <p class="font-bold text-[#7b1e2d] text-lg">Rp {{ number_format($booking->price, 0, ',', '.') }}</p>
        </div>
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0] text-center">
            <p class="text-xs text-[#83676c] mb-1">Booking ID</p>
            <p class="font-bold text-[#171213]">#{{ $booking->id }}</p>
        </div>
    </div>

    {{-- Additional Session Info --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0]">
            <p class="text-xs text-[#83676c] mb-1">Meeting Link Status</p>
            <p class="font-medium text-[#171213]">
                @if($booking->link_status)
                <span class="inline-flex items-center gap-1">
                    @if($booking->link_status === 'sent')
                    <span class="material-symbols-outlined text-[16px] text-green-600">check_circle</span>
                    @else
                    <span class="material-symbols-outlined text-[16px] text-amber-600">pending</span>
                    @endif
                    {{ ucfirst($booking->link_status) }}
                </span>
                @else
                <span class="text-[#83676c]">Not Set</span>
                @endif
            </p>
        </div>
        <div class="bg-[#f8f6f6] p-4 rounded-xl border border-[#e6e0e0]">
            <p class="text-xs text-[#83676c] mb-1">Is Expired</p>
            <p class="font-medium text-[#171213]">
                @if($booking->is_expired)
                <span class="inline-flex items-center gap-1 text-red-600">
                    <span class="material-symbols-outlined text-[16px]">timer_off</span>
                    Yes
                </span>
                @else
                <span class="inline-flex items-center gap-1 text-green-600">
                    <span class="material-symbols-outlined text-[16px]">check</span>
                    No
                </span>
                @endif
            </p>
        </div>
    </div>
</section>
