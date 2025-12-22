@props(['booking'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Cancellation Details --}}
    <div class="bg-red-50 rounded-xl p-4 border border-red-200">
        <h4 class="text-sm font-bold text-red-700 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-red-600 text-[18px]">block</span>
            Cancellation Details
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-red-600">Status</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($booking->status === 'cancelled') bg-red-100 text-red-700
                    @else bg-gray-100 text-gray-700
                    @endif">
                    {{ $booking->status === 'cancelled' ? 'Cancelled' : 'Active' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-red-600">Cancelled By</span>
                <span class="text-sm font-medium text-red-800">{{ ucfirst($booking->cancelled_by ?? '-') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-red-600">Cancelled At</span>
                <span class="text-sm font-medium text-red-800">
                    {{ $booking->cancelled_at ? \Carbon\Carbon::parse($booking->cancelled_at)->format('M d, Y h:i A') : '-' }}
                </span>
            </div>
            <div>
                <p class="text-sm text-red-600 mb-1">Cancel Reason</p>
                <p class="text-sm text-red-800 bg-white rounded p-2 border border-red-200">{{ $booking->cancel_reason ?? 'No reason provided' }}</p>
            </div>
        </div>
    </div>

    {{-- Refund Details --}}
    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
        <h4 class="text-sm font-bold text-purple-700 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-purple-600 text-[18px]">currency_exchange</span>
            Refund Details
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-purple-600">Refund Status</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($booking->refund_status === 'none') bg-gray-100 text-gray-700
                    @elseif($booking->refund_status === 'requested') bg-orange-100 text-orange-700
                    @elseif($booking->refund_status === 'processed') bg-blue-100 text-blue-700
                    @elseif($booking->refund_status === 'done') bg-green-100 text-green-700
                    @endif">
                    {{ ucfirst($booking->refund_status) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-purple-600">Refund Processed At</span>
                <span class="text-sm font-medium text-purple-800">
                    {{ $booking->refund_processed_at ? \Carbon\Carbon::parse($booking->refund_processed_at)->format('M d, Y h:i A') : '-' }}
                </span>
            </div>
            @if($booking->payment)
            <div class="flex justify-between">
                <span class="text-sm text-purple-600">Payment Refund Amount</span>
                <span class="text-sm font-bold text-purple-800">Rp {{ number_format($booking->payment->refund_amount ?? 0, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-purple-600">Payment Refund Reason</span>
                <span class="text-sm font-medium text-purple-800">{{ $booking->payment->refund_reason ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-purple-600">Payment Refund Time</span>
                <span class="text-sm font-medium text-purple-800">
                    {{ $booking->payment->refund_time ? \Carbon\Carbon::parse($booking->payment->refund_time)->format('M d, Y h:i A') : '-' }}
                </span>
            </div>
            @endif
        </div>
    </div>
</div>
