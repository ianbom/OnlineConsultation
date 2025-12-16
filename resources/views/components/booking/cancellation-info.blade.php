@props(['booking'])

@if($booking->status === 'cancelled')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembatalan</h2>
    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded space-y-2">
        @if($booking->cancelled_by)
        <div class="flex items-center">
            <span class="text-sm text-gray-600 mr-2">Dibatalkan oleh:</span>
            <span class="font-semibold text-gray-900">{{ ucfirst($booking->cancelled_by) }}</span>
        </div>
        @endif

        @if($booking->cancelled_at)
        <p class="text-sm text-gray-600">
            Waktu pembatalan:
            {{ \Carbon\Carbon::parse($booking->cancelled_at)->format('d M Y, H:i') }}
        </p>
        @endif

        @if($booking->cancel_reason)
        <div class="mt-3">
            <p class="text-sm text-gray-600 mb-1">Alasan:</p>
            <p class="text-gray-800">{{ $booking->cancel_reason }}</p>
        </div>
        @endif
    </div>
</div>
@endif
