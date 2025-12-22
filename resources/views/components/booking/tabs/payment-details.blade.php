@props(['payment', 'booking'])

@if($payment)
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Payment Summary --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">receipt</span>
            Payment Summary
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Order ID</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->order_id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Amount</span>
                <span class="text-sm font-bold text-[#7b1e2d]">Rp {{ number_format($payment->amount, 0, ',', '.') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Status</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($payment->status === 'success') bg-green-100 text-green-700
                    @elseif($payment->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($payment->status === 'failed') bg-red-100 text-red-700
                    @elseif($payment->status === 'refund' || $payment->status === 'refunded') bg-purple-100 text-purple-700
                    @endif">
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Payment Method</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->method ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Payment Type</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->payment_type ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Midtrans Details --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">payments</span>
            Midtrans Details
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Transaction ID</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->midtrans_transaction_id ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Transaction Status</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->transaction_status ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Fraud Status</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->fraud_status ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">VA Number</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->va_number ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Snap Token</span>
                <span class="text-sm font-medium text-[#171213] truncate max-w-[200px]">{{ $payment->snap_token ?? '-' }}</span>
            </div>
        </div>
    </div>
</div>

{{-- Timestamps --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">schedule</span>
            Timestamps
        </h4>
        <div class="space-y-2">
            <div>
                <p class="text-xs text-[#83676c]">Created At</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->created_at->format('M d, Y h:i A') }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Paid At</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->format('M d, Y h:i A') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Settlement Time</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->settlement_time ? \Carbon\Carbon::parse($payment->settlement_time)->format('M d, Y h:i A') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Expiry Time</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->expiry_time ? \Carbon\Carbon::parse($payment->expiry_time)->format('M d, Y h:i A') : '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Payment URL --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">link</span>
            Payment Link
        </h4>
        @if($payment->payment_url)
        <a href="{{ $payment->payment_url }}" target="_blank" class="text-sm text-[#7b1e2d] hover:underline break-all">{{ $payment->payment_url }}</a>
        @else
        <p class="text-sm text-[#83676c]">No payment URL</p>
        @endif
    </div>

    {{-- Failure Info --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">error</span>
            Failure Info
        </h4>
        <p class="text-sm text-[#171213]">{{ $payment->failure_reason ?? 'No failure' }}</p>
    </div>
</div>

{{-- Refund Info (if any) --}}
@if($payment->refund_amount || $payment->refund_reason || $payment->refund_time)
<div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
    <h4 class="text-sm font-bold text-purple-700 mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-purple-600 text-[18px]">currency_exchange</span>
        Refund Details
    </h4>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <p class="text-xs text-purple-600">Refund Amount</p>
            <p class="text-sm font-bold text-purple-800">Rp {{ number_format($payment->refund_amount ?? 0, 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="text-xs text-purple-600">Refund Reason</p>
            <p class="text-sm font-medium text-purple-800">{{ $payment->refund_reason ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-purple-600">Refund Time</p>
            <p class="text-sm font-medium text-purple-800">{{ $payment->refund_time ? \Carbon\Carbon::parse($payment->refund_time)->format('M d, Y h:i A') : '-' }}</p>
        </div>
    </div>
</div>
@endif
@else
<div class="text-center py-8">
    <span class="material-symbols-outlined text-[48px] text-[#e6e0e0]">receipt_long</span>
    <p class="text-[#83676c] mt-2">No payment records found</p>
</div>
@endif
