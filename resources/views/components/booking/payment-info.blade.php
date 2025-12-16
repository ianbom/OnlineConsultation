@props(['payment', 'booking'])

@if($payment)
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
    <div class="space-y-3">
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Status</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if($payment->payment_status === 'paid') bg-green-100 text-green-800
                @elseif($payment->payment_status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($payment->payment_status === 'failed') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($payment->payment_status) }}
            </span>
        </div>

        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Jumlah</span>
            <span class="font-semibold text-gray-900">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
        </div>

        @if($payment->payment_type)
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Metode</span>
            <span class="text-gray-900">{{ str_replace('_', ' ', ucfirst($payment->payment_type)) }}</span>
        </div>
        @endif

        @if($payment->va_number)
        <div class="pb-3 border-b">
            <span class="text-gray-600 text-sm">VA Number</span>
            <p class="font-mono text-sm text-gray-900 mt-1">{{ $payment->va_number }}</p>
        </div>
        @endif

        @if($payment->paid_at)
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Dibayar</span>
            <span class="text-sm text-gray-700">
                {{ \Carbon\Carbon::parse($payment->paid_at)->format('d M Y, H:i') }}
            </span>
        </div>
        @endif

        @if($payment->transaction_status)
        <div class="flex justify-between items-center">
            <span class="text-gray-600 text-sm">Transaction Status</span>
            <span class="text-sm text-gray-700">{{ ucfirst($payment->transaction_status) }}</span>
        </div>
        @endif
    </div>

    <!-- Refund Information -->
    @if($booking->refund_status !== 'none')
    <div class="mt-4 pt-4 border-t">
        <h3 class="font-semibold text-gray-900 mb-2">Refund</h3>
        <div class="bg-purple-50 border-l-4 border-purple-500 p-3 rounded space-y-1">
            <p class="text-sm">
                Status: <span class="font-semibold">{{ ucfirst($booking->refund_status) }}</span>
            </p>
            @if($booking->refund_processed_at)
            <p class="text-sm text-gray-600">
                Diproses: {{ \Carbon\Carbon::parse($booking->refund_processed_at)->format('d M Y, H:i') }}
            </p>
            @endif
        </div>
    </div>
    @endif
</div>
@endif
