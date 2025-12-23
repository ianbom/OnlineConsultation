@props(['booking'])

@if($booking->status === 'cancelled')
<section class="bg-white rounded-2xl border border-red-200 shadow-sm p-6">
    <h3 class="text-lg font-bold text-red-700 flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-red-600">block</span>
        Informasi Pembatalan
    </h3>
    <div class="bg-red-50 rounded-xl p-4 border border-red-200 space-y-3">
        <div>
            <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Alasan Pembatalan</p>
            <p class="text-sm text-red-800">{{ $booking->cancel_reason ?? 'Tidak ada alasan' }}</p>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Dibatalkan Oleh</p>
                <p class="text-sm text-red-800">{{ ucfirst($booking->cancelled_by ?? '-') }}</p>
            </div>
            <div>
                <p class="text-xs font-semibold text-red-600 uppercase tracking-wider mb-1">Waktu Pembatalan</p>
                <p class="text-sm text-red-800">
                    @if($booking->cancelled_at)
                    {{ \Carbon\Carbon::parse($booking->cancelled_at)->locale('id')->translatedFormat('d M Y \p\u\k\u\l H:i') }}
                    @else
                    -
                    @endif
                </p>
            </div>
        </div>
    </div>
</section>
@endif
