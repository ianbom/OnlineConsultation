<x-admin.app>

<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
            {{-- Left Section --}}
            <div>
                <a href="{{ route('admin.booking.index') }}"
                   class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-2">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M15 19l-7-7 7-7"/>
                    </svg>
                    Kembali ke Daftar Booking
                </a>

                <h1 class="text-3xl font-bold text-gray-900">Detail Booking</h1>
                <p class="text-gray-600 mt-1">Booking ID: #{{ $booking->id }}</p>
            </div>

            @if ($booking->status == 'paid')
            <form id="completeBookingForm"
                  method="POST"
                  action="{{ route('counselor.booking.completeBooking', $booking->id) }}">
                @csrf
                @method('PUT')
                <button type="button"
                    onclick="confirmCompleteBooking()"
                    class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-lg shadow hover:bg-green-700 transition">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                    Tandai Sesi Selesai
                </button>
            </form>
            @endif
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Status Badge -->
                <x-booking.status-badge :status="$booking->status" />

                <!-- Client Information -->
                <x-booking.client-info :client="$booking->client" />

                <!-- Counselor Information -->
                <x-booking.counselor-info :counselor="$booking->counselor" />


                <!-- Schedule Information -->
                <x-booking.schedule-info :booking="$booking" />

                <!-- Reschedule Information -->
                <x-booking.reschedule-info :booking="$booking" />


                <!-- Notes -->
                <x-booking.client-notes :notes="$booking->notes" />

                <!-- Counselor Notes -->
                <x-booking.counselor-notes :booking="$booking" />

                <!-- Cancellation Info -->
                <x-booking.cancellation-info :booking="$booking" />

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Consultation Details -->
                <x-booking.consultation-details :booking="$booking" />

                <!-- Meeting Link -->
                <x-booking.meeting-link :booking="$booking" />

                <!-- Payment Information -->
                <x-booking.payment-info :payment="$booking->payment" :booking="$booking" />

                <!-- Input Link Meeting & Catatan Konselor -->
                <x-booking.link-notes-form :booking="$booking" />




            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Link berhasil disalin!');
    }, function(err) {
        console.error('Gagal menyalin link: ', err);
    });
}
</script>

<script>
function confirmCompleteBooking() {
    if (confirm("Apakah Anda yakin ingin menandai sesi ini sebagai selesai? Tindakan ini tidak dapat dibatalkan.")) {
        document.getElementById('completeBookingForm').submit();
    }
}
</script>


</x-admin.app>
