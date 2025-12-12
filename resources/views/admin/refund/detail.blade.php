<x-admin.app>

<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.refund.index') }}"
               class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 mb-2">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Kembali ke Daftar Refund
            </a>

            <h1 class="text-3xl font-bold text-gray-900">Detail Refund</h1>
            <p class="text-gray-600 mt-1">Order ID: {{ $paymentRefund->order_id }}</p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">

                <!-- Status Badge -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Status Refund</h2>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            @if($paymentRefund->status === 'refund') bg-warning-100 text-warning-800
                            @elseif($paymentRefund->status === 'success') bg-green-100 text-green-800
                            @elseif($paymentRefund->status === 'pending') bg-yellow-100 text-yellow-800
                            @elseif($paymentRefund->status === 'failed') bg-red-100 text-red-800
                            @endif">
                            {{ ucfirst($paymentRefund->status) }}
                        </span>
                    </div>

                    @if($paymentRefund->fraud_status === 'accept')
                    <div class="mt-3 flex items-center text-green-600">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-sm font-medium">Verified - No Fraud Detected</span>
                    </div>
                    @endif
                </div>

                <!-- Client Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Klien</h2>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($paymentRefund->booking->client->profile_pic)
                                <img src="{{ asset('storage/' . $paymentRefund->booking->client->profile_pic) }}"
                                     alt="{{ $paymentRefund->booking->client->name }}"
                                     class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($paymentRefund->booking->client->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $paymentRefund->booking->client->name }}</h3>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $paymentRefund->booking->client->email }}
                                </div>
                                @if($paymentRefund->booking->client->phone)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $paymentRefund->booking->client->phone }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Refund Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Refund</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b border-red-200">
                            <span class="text-sm font-medium text-gray-700">Jumlah Refund:</span>
                            <span class="text-xl font-bold text-red-600">
                                Rp {{ number_format($paymentRefund->refund_amount, 0, ',', '.') }}
                            </span>
                        </div>


                        @if($paymentRefund->refund_time)
                        <div class="flex justify-between items-center pb-3 border-b border-red-200">
                            <span class="text-sm font-medium text-gray-700">Waktu Refund:</span>
                            <span class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($paymentRefund->refund_time)->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->refund_reason)
                        <div class="pt-2 flex justify-between items-center">
                            <p class="text-sm font-medium text-gray-700 mb-1">Alasan Refund:</p>
                            <p class="text-gray-800">{{ $paymentRefund->refund_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Transaction Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Transaksi</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Order ID</span>
                            <span class="font-mono text-sm text-gray-900">{{ $paymentRefund->order_id }}</span>
                        </div>

                        @if($paymentRefund->midtrans_transaction_id)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Transaction ID</span>
                            <span class="font-mono text-xs text-gray-700">{{ $paymentRefund->midtrans_transaction_id }}</span>
                        </div>
                        @endif

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Booking ID</span>

                            <div class="flex items-center gap-3">
                                <span class="font-semibold text-gray-900">
                                    #{{ $paymentRefund->booking_id }}
                                </span>

                                <a href="{{ route('admin.booking.show', $paymentRefund->booking_id) }}"
                                   class="inline-flex items-center px-3 py-1.5 text-xs font-semibold
                                          bg-primary text-white rounded-md hover:bg-primary/80 transition">
                                    Detail Booking
                                </a>
                            </div>
                        </div>


                        @if($paymentRefund->payment_type)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Metode Pembayaran</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($paymentRefund->payment_type === 'bank_transfer') bg-info-100 text-info-800
                                @elseif($paymentRefund->payment_type === 'gopay') bg-green-100 text-green-800
                                @elseif($paymentRefund->payment_type === 'qris') bg-primary-100 text-primary-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ str_replace('_', ' ', ucfirst($paymentRefund->payment_type)) }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->va_number)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600 text-sm">Virtual Account Number</span>
                            <p class="font-mono text-sm text-gray-900 mt-1">{{ $paymentRefund->va_number }}</p>
                        </div>
                        @endif

                        @if($paymentRefund->transaction_status)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Transaction Status</span>
                            <span class="text-sm font-semibold text-gray-700">
                                {{ ucfirst($paymentRefund->transaction_status) }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->paid_at)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Dibayar Pada</span>
                            <span class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($paymentRefund->paid_at)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->settlement_time)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Settlement Time</span>
                            <span class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($paymentRefund->settlement_time)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Failure Reason (if any) -->
                @if($paymentRefund->failure_reason)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Alasan Kegagalan</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded">
                        <p class="text-gray-800">{{ $paymentRefund->failure_reason }}</p>
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Quick Info Card -->
               <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Ringkasan Refund
                    </h3>

                    <div class="space-y-4">

                        {{-- Total Refund --}}
                        <div>
                            <p class="text-sm text-gray-500">Total Refund</p>
                            <p class="text-2xl font-bold text-gray-900">
                                Rp {{ number_format($paymentRefund->refund_amount, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Status --}}
                        <div class="pt-4 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-sm text-gray-500">Status</span>

                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($paymentRefund->status === 'processed')
                                    bg-green-100 text-green-800
                                @elseif($paymentRefund->status === 'pending')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-gray-100 text-gray-800
                                @endif
                            ">
                                {{ ucfirst($paymentRefund->status) }}
                            </span>
                        </div>

                        {{-- Refund Time --}}
                        @if($paymentRefund->refund_time)
                        <div class="pt-4 border-t border-gray-200">
                            <p class="text-sm text-gray-500 mb-1">Diproses</p>
                            <p class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($paymentRefund->refund_time)->diffForHumans() }}
                            </p>
                        </div>
                        @endif

                    </div>
                </div>


                <!-- Payment URLs (if available) -->
                @if($paymentRefund->payment_url || $paymentRefund->snap_token)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Payment Links</h3>
                    <div class="space-y-3">
                        @if($paymentRefund->payment_url)
                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Payment URL</label>
                            <div class="flex items-center space-x-2">
                                <input type="text"
                                       value="{{ $paymentRefund->payment_url }}"
                                       readonly
                                       class="flex-1 text-xs border rounded px-2 py-1 bg-gray-50 text-gray-700">
                                <button onclick="copyToClipboard('{{ $paymentRefund->payment_url }}')"
                                        class="px-3 py-1 bg-primary text-white rounded text-xs hover:bg-primary-dark">
                                    Copy
                                </button>
                            </div>
                        </div>
                        @endif

                        @if($paymentRefund->snap_token)
                        <div>
                            <label class="text-sm text-gray-600 block mb-1">Snap Token</label>
                            <div class="flex items-center space-x-2">
                                <input type="text"
                                       value="{{ $paymentRefund->snap_token }}"
                                       readonly
                                       class="flex-1 text-xs border rounded px-2 py-1 bg-gray-50 text-gray-700">
                                <button onclick="copyToClipboard('{{ $paymentRefund->snap_token }}')"
                                        class="px-3 py-1 bg-primary text-white rounded text-xs hover:bg-primary-dark">
                                    Copy
                                </button>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Timestamps -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Timestamp</h3>
                    <div class="space-y-3 text-sm">
                        @if($paymentRefund->created_at)
                        <div class="flex justify-between pb-2 border-b">
                            <span class="text-gray-600">Dibuat</span>
                            <span class="text-gray-900">
                                {{ \Carbon\Carbon::parse($paymentRefund->created_at)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->paid_at)
                        <div class="flex justify-between pb-2 border-b">
                            <span class="text-gray-600">Dibayar</span>
                            <span class="text-gray-900">
                                {{ \Carbon\Carbon::parse($paymentRefund->paid_at)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->refund_time)
                        <div class="flex justify-between pb-2 border-b">
                            <span class="text-gray-600">Waktu Refund</span>
                            <span class="text-gray-900">
                                {{ \Carbon\Carbon::parse($paymentRefund->refund_time)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($paymentRefund->expiry_time)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Waktu Pembayaran Expired</span>
                            <span class="text-gray-900">
                                {{ \Carbon\Carbon::parse($paymentRefund->expiry_time)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>

                @if(in_array($paymentRefund->status, ['refund']))
                    <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">
                            Aksi Refund
                        </h3>

                        <div class="flex flex-col gap-3">

                            {{-- APPROVE REFUND --}}
                            <form method="POST"
                                  action="{{ route('admin.payment.changeRefundStatus', $paymentRefund->id) }}"
                                  onsubmit="return confirm('Yakin ingin MENYETUJUI refund ini? Dana akan dikembalikan ke klien.')">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="refundStatus" value="approved">

                                <button type="submit"
                                        class="w-full inline-flex items-center justify-center gap-2
                                               px-4 py-2 bg-green-600 text-white rounded-lg
                                               hover:bg-green-700 transition font-semibold">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Approve Refund
                                </button>
                            </form>

                        </div>
                    </div>
                    @endif


            </div>
        </div>
    </div>
</div>

<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        alert('Berhasil disalin ke clipboard!');
    }, function(err) {
        console.error('Gagal menyalin: ', err);
    });
}
</script>

</x-admin.app>
