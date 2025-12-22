<x-counselor.app>


<link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>
<style>
    .material-symbols-outlined {
        font-variation-settings:
        'FILL' 0,
        'wght' 400,
        'GRAD' 0,
        'opsz' 24;
        font-size: 20px;
    }
    .icon-filled {
        font-variation-settings: 'FILL' 1;
    }
</style>

<!-- Sub-Header / Sticky Action Bar -->
<div class="bg-white border-b border-[#e6e0e0] top-16 z-40 shadow-sm">
    <div class="max-w-[1440px] mx-auto px-4 sm:px-6 lg:px-8 py-4">
        <!-- Breadcrumbs -->
        <div class="flex items-center gap-2 text-sm text-[#83676c] mb-3">
            <a class="hover:text-[#7b1e2d]" href="{{ route('counselor.dashboard') }}">Home</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <a class="hover:text-[#7b1e2d]" href="{{ route('counselor.booking.index') }}">Bookings</a>
            <span class="material-symbols-outlined text-[16px]">chevron_right</span>
            <span class="text-[#171213] font-medium">Booking #{{ $booking->id }}</span>
        </div>
        <!-- Title, Badges & Actions -->
        <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
            <div class="flex flex-col gap-2">
                <div class="flex items-center gap-4 flex-wrap">
                    <h2 class="text-3xl font-black tracking-tight text-[#171213]">Booking #{{ $booking->id }}</h2>
                    <div class="flex gap-2 flex-wrap">
                        {{-- Booking Status Badge --}}
                        <x-booking.status-badge :status="$booking->status" size="small" />

                        {{-- Reschedule Status Badge --}}
                        @if($booking->reschedule_status !== 'none')
                        <x-booking.reschedule-status-badge :status="$booking->reschedule_status" size="small" />
                        @endif

                        {{-- Refund Status Badge --}}
                        @if($booking->refund_status !== 'none')
                        <x-booking.refund-status-badge :status="$booking->refund_status" size="small" />
                        @endif

                        {{-- Expired Badge --}}
                        @if($booking->is_expired)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 border border-gray-200">
                            <span class="material-symbols-outlined text-[16px] icon-filled">timer_off</span>
                            Expired
                        </span>
                        @endif

                        {{-- Link Status Badge --}}
                        @if($booking->link_status)
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold
                            @if($booking->link_status === 'sent') bg-green-100 text-green-800 border border-green-200
                            @else bg-gray-100 text-gray-800 border border-gray-200
                            @endif">
                            <span class="material-symbols-outlined text-[16px] icon-filled">link</span>
                            Link {{ ucfirst($booking->link_status) }}
                        </span>
                        @endif
                    </div>
                </div>
                <p class="text-sm text-[#83676c]">Created on {{ $booking->created_at->format('M d, Y') }} at {{ $booking->created_at->format('h:i A') }}</p>
            </div>
            <div class="flex flex-wrap items-center gap-3">
                @if($booking->payment && $booking->payment->payment_url)
                <a href="{{ $booking->payment->payment_url }}" target="_blank" class="h-10 px-4 rounded-xl border border-[#e6e0e0] bg-white text-[#171213] text-sm font-bold hover:bg-[#f8f6f6] transition-colors flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">open_in_new</span>
                    Payment Link
                </a>
                @endif
                @if ($booking->status == 'paid')
                <form id="completeBookingForm" method="POST" action="{{ route('counselor.booking.completeBooking', $booking->id) }}">
                    @csrf
                    @method('PUT')
                    <button type="button" onclick="confirmCompleteBooking()" class="h-10 px-6 rounded-xl bg-green-600 text-white text-sm font-bold shadow-md hover:bg-green-700 transition-colors flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        Tandai Sesi Selesai
                    </button>
                </form>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<main class="flex-grow py-8 px-4 sm:px-6 lg:px-8 max-w-[1440px] mx-auto w-full">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- LEFT COLUMN (Context) -->
        <div class="lg:col-span-7 flex flex-col gap-6">
            <!-- Client Info Card -->
            <x-booking.client-info :client="$booking->client" :showViewProfile="false" />

            <!-- Counselor Info Card -->
            <x-booking.counselor-info :counselor="$booking->counselor" :showViewProfile="false" />

            <!-- Session Details -->
            <x-booking.consultation-details :booking="$booking" />

            <!-- Client Notes -->
            <x-booking.client-notes :notes="$booking->notes" />

            <!-- Counselor Notes -->
            <x-booking.counselor-notes :booking="$booking" />

            <!-- Cancellation Info -->
            <x-booking.cancellation-info :booking="$booking" />

            <!-- Refund Information -->
            <x-booking.refund-info :booking="$booking" />
        </div>

        <!-- RIGHT COLUMN (Logistics) -->
        <div class="lg:col-span-5 flex flex-col gap-6">
            <!-- Schedule Card -->
            <x-booking.schedule-info :booking="$booking" />

            <!-- Reschedule Information Card -->
            <x-booking.reschedule-info :booking="$booking" :showActions="true" />

            <!-- Booking Timeline -->
            <x-booking.booking-timeline :booking="$booking" />

            <!-- Meeting Link -->
            <x-booking.meeting-link :booking="$booking" />

            <!-- Link Notes Form -->
            @if($booking->status === 'paid')
            <x-booking.link-notes-form :booking="$booking" :action="route('counselor.booking.inputLinkandNotes', $booking->id)" />
            @endif
        </div>

        <!-- BOTTOM SECTION (Tabs) -->
        <div class="lg:col-span-12 mt-4">
            <x-booking.booking-tabs :booking="$booking" />
        </div>
    </div>
</main>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Toast notification
        const toast = document.createElement('div');
        toast.className = 'fixed bottom-4 right-4 bg-[#171213] text-white px-4 py-2 rounded-xl shadow-lg z-50 flex items-center gap-2';
        toast.innerHTML = '<span class="material-symbols-outlined text-green-400">check_circle</span> Link berhasil disalin!';
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 2000);
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}

function confirmCompleteBooking() {
    if (confirm("Apakah Anda yakin ingin menandai sesi ini sebagai selesai? Tindakan ini tidak dapat dibatalkan.")) {
        document.getElementById('completeBookingForm').submit();
    }
}
</script>

</x-counselor.app>
