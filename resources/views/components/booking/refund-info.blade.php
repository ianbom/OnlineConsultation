@props(['booking'])

@if($booking->refund_status !== 'none')
<section class="bg-white rounded-2xl border border-purple-200 shadow-sm p-6">
    <h3 class="text-lg font-bold text-purple-700 flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-purple-600">currency_exchange</span>
        Refund Information
    </h3>
    <div class="bg-purple-50 rounded-xl p-4 border border-purple-200 space-y-3">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-1">Refund Status</p>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($booking->refund_status === 'requested') bg-orange-100 text-orange-700
                    @elseif($booking->refund_status === 'processed') bg-blue-100 text-blue-700
                    @elseif($booking->refund_status === 'done') bg-green-100 text-green-700
                    @endif">
                    {{ ucfirst($booking->refund_status) }}
                </span>
            </div>
            <div>
                <p class="text-xs font-semibold text-purple-600 uppercase tracking-wider mb-1">Refund Processed At</p>
                <p class="text-sm text-purple-800">
                    @if($booking->refund_processed_at)
                    {{ \Carbon\Carbon::parse($booking->refund_processed_at)->format('M d, Y \a\t h:i A') }}
                    @else
                    -
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
@endif
