@props(['payment', 'booking'])

@if($payment)
@php
    $paymentStatusLabel = match ($payment->status) {
        'success' => 'Berhasil',
        'pending' => 'Menunggu',
        'failed' => 'Gagal',
        'refund', 'refunded' => 'Refund',
        default => ucfirst($payment->status),
    };
@endphp
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
    {{-- Ringkasan Pembayaran --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">receipt</span>
            Ringkasan Pembayaran
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Order ID</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->order_id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Jumlah</span>
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
                    {{ $paymentStatusLabel }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Metode Pembayaran</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->method ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Tipe Pembayaran</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->payment_type ?? '-' }}</span>
            </div>
        </div>
    </div>

    {{-- Detail Midtrans --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">payments</span>
            Detail Midtrans
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">ID Transaksi</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->midtrans_transaction_id ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Status Transaksi</span>
                <span class="text-sm font-medium text-[#171213]">{{ $payment->transaction_status ?? '-' }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Status Fraud</span>
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

{{-- Waktu --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">schedule</span>
            Waktu
        </h4>
        <div class="space-y-2">
            <div>
                <p class="text-xs text-[#83676c]">Dibuat</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->created_at->locale('id')->translatedFormat('d M Y, H:i') }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Dibayar</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->paid_at ? \Carbon\Carbon::parse($payment->paid_at)->locale('id')->translatedFormat('d M Y, H:i') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Waktu Settlement</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->settlement_time ? \Carbon\Carbon::parse($payment->settlement_time)->locale('id')->translatedFormat('d M Y, H:i') : '-' }}</p>
            </div>
            <div>
                <p class="text-xs text-[#83676c]">Batas Waktu</p>
                <p class="text-sm font-medium text-[#171213]">{{ $payment->expiry_time ? \Carbon\Carbon::parse($payment->expiry_time)->locale('id')->translatedFormat('d M Y, H:i') : '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Tautan Pembayaran --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">link</span>
            Tautan Pembayaran
        </h4>
        @if($payment->payment_url)
        <a href="{{ $payment->payment_url }}" target="_blank" class="text-sm text-[#7b1e2d] hover:underline break-all">{{ $payment->payment_url }}</a>
        @else
        <p class="text-sm text-[#83676c]">Tidak ada tautan pembayaran</p>
        @endif
    </div>

    {{-- Info Gagal --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-3 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">error</span>
            Info Gagal
        </h4>
        <p class="text-sm text-[#171213]">{{ $payment->failure_reason ?? 'Tidak ada informasi kegagalan' }}</p>
    </div>
</div>

{{-- Info Refund (jika ada) --}}
@if($payment->refund_amount || $payment->refund_reason || $payment->refund_time)
<div class="bg-purple-50 rounded-xl p-4 border border-purple-200">
    <h4 class="text-sm font-bold text-purple-700 mb-4 flex items-center gap-2">
        <span class="material-symbols-outlined text-purple-600 text-[18px]">currency_exchange</span>
        Detail Refund
    </h4>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div>
            <p class="text-xs text-purple-600">Jumlah Refund</p>
            <p class="text-sm font-bold text-purple-800">Rp {{ number_format($payment->refund_amount ?? 0, 0, ',', '.') }}</p>
        </div>
        <div>
            <p class="text-xs text-purple-600">Alasan Refund</p>
            <p class="text-sm font-medium text-purple-800">{{ $payment->refund_reason ?? '-' }}</p>
        </div>
        <div>
            <p class="text-xs text-purple-600">Waktu Refund</p>
            <p class="text-sm font-medium text-purple-800">{{ $payment->refund_time ? \Carbon\Carbon::parse($payment->refund_time)->locale('id')->translatedFormat('d M Y, H:i') : '-' }}</p>
        </div>
    </div>
</div>
@endif
@else
<div class="text-center py-8">
    <span class="material-symbols-outlined text-[48px] text-[#e6e0e0]">receipt_long</span>
    <p class="text-[#83676c] mt-2">Tidak ada data pembayaran</p>
</div>
@endif
