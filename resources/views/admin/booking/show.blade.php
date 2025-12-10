<x-admin.app>
    <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-6">
            <a href="{{ route('admin.booking.index') }}" class="text-blue-600 hover:text-blue-800 mb-4 inline-block">
                &larr; Kembali ke Daftar Booking
            </a>
            <h1 class="text-3xl font-bold text-gray-800">Detail Booking #{{ $booking->id }}</h1>
        </div>

        <!-- Status Badge -->
        <div class="mb-6">
            <span class="px-4 py-2 rounded-full text-sm font-semibold
                @if($booking->status == 'paid') bg-green-100 text-green-800
                @elseif($booking->status == 'pending_payment') bg-yellow-100 text-yellow-800
                @elseif($booking->status == 'cancelled') bg-red-100 text-red-800
                @elseif($booking->status == 'completed') bg-blue-100 text-blue-800
                @elseif($booking->status == 'rescheduled') bg-purple-100 text-purple-800
                @endif">
                {{ strtoupper(str_replace('_', ' ', $booking->status)) }}
            </span>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Informasi Client -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Client</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama</label>
                        <p class="text-gray-800">{{ $booking->client->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-800">{{ $booking->client->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Telepon</label>
                        <p class="text-gray-800">{{ $booking->client->phone ?? '-' }}</p>
                    </div>
                </div>
            </div>

            <!-- Informasi Counselor -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Counselor</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Nama</label>
                        <p class="text-gray-800">{{ $booking->counselor->user->name }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Email</label>
                        <p class="text-gray-800">{{ $booking->counselor->user->email }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Spesialisasi</label>
                        <p class="text-gray-800">{{ $booking->counselor->specialization }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Pendidikan</label>
                        <p class="text-gray-800">{{ $booking->counselor->education }}</p>
                    </div>
                </div>
            </div>

            <!-- Detail Booking -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Detail Booking</h2>
                <div class="space-y-3">
                    <div>
                        <label class="text-sm font-medium text-gray-500">Harga</label>
                        <p class="text-gray-800 font-semibold">Rp {{ number_format($booking->price, 0, ',', '.') }}</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Durasi</label>
                        <p class="text-gray-800">{{ $booking->duration_hours }} Jam</p>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Tipe Konsultasi</label>
                        <p class="text-gray-800 capitalize">{{ $booking->consultation_type }}</p>
                    </div>
                    @if($booking->meeting_link)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Link Meeting</label>
                        <a href="{{ $booking->meeting_link }}" target="_blank" class="text-blue-600 hover:underline break-all">
                            {{ $booking->meeting_link }}
                        </a>
                    </div>
                    <div>
                        <label class="text-sm font-medium text-gray-500">Status Link</label>
                        <p class="text-gray-800 capitalize">{{ $booking->link_status ?? '-' }}</p>
                    </div>
                    @endif
                    @if($booking->notes)
                    <div>
                        <label class="text-sm font-medium text-gray-500">Catatan</label>
                        <p class="text-gray-800">{{ $booking->notes }}</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Jadwal Aktif -->
            <div class="bg-white rounded-lg shadow-md p-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Jadwal Konsultasi</h2>
                <div class="space-y-4">
                    <div class="bg-blue-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-700 mb-2">Jadwal Pertama</h3>
                        <div class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal</label>
                                <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Waktu</label>
                                <p class="text-gray-800">{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Status</label>
                                <p class="text-gray-800">{{ $booking->schedule->is_available ? 'Tersedia' : 'Tidak Tersedia' }}</p>
                            </div>
                        </div>
                    </div>

                    @if($booking->secondSchedule)
                    <div class="bg-green-50 p-4 rounded-lg">
                        <h3 class="font-semibold text-gray-700 mb-2">Jadwal Kedua</h3>
                        <div class="space-y-2">
                            <div>
                                <label class="text-sm font-medium text-gray-500">Tanggal</label>
                                <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->format('d M Y') }}</p>
                            </div>
                            <div>
                                <label class="text-sm font-medium text-gray-500">Waktu</label>
                                <p class="text-gray-800">{{ $booking->secondSchedule->start_time }} - {{ $booking->secondSchedule->end_time }}</p>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Jadwal Sebelumnya (Jika Ada Reschedule) -->
        @if($booking->previousSchedule || $booking->previousSecondSchedule)
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Jadwal Sebelumnya (Rescheduled)</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @if($booking->previousSchedule)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Jadwal Pertama (Lama)</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Waktu</label>
                            <p class="text-gray-800">{{ $booking->previousSchedule->start_time }} - {{ $booking->previousSchedule->end_time }}</p>
                        </div>
                    </div>
                </div>
                @endif

                @if($booking->previousSecondSchedule)
                <div class="bg-gray-50 p-4 rounded-lg">
                    <h3 class="font-semibold text-gray-700 mb-2">Jadwal Kedua (Lama)</h3>
                    <div class="space-y-2">
                        <div>
                            <label class="text-sm font-medium text-gray-500">Tanggal</label>
                            <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->format('d M Y') }}</p>
                        </div>
                        <div>
                            <label class="text-sm font-medium text-gray-500">Waktu</label>
                            <p class="text-gray-800">{{ $booking->previousSecondSchedule->start_time }} - {{ $booking->previousSecondSchedule->end_time }}</p>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Informasi Pembayaran -->
        @if($booking->payment)
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Pembayaran</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Order ID</label>
                    <p class="text-gray-800 font-mono">{{ $booking->payment->order_id }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Jumlah</label>
                    <p class="text-gray-800 font-semibold">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Status Pembayaran</label>
                    <span class="px-3 py-1 rounded-full text-sm font-semibold
                        @if($booking->payment->status == 'success') bg-green-100 text-green-800
                        @elseif($booking->payment->status == 'pending') bg-yellow-100 text-yellow-800
                        @elseif($booking->payment->status == 'failed') bg-red-100 text-red-800
                        @elseif($booking->payment->status == 'refund') bg-gray-100 text-gray-800
                        @endif">
                        {{ strtoupper($booking->payment->status) }}
                    </span>
                </div>
                @if($booking->payment->method)
                <div>
                    <label class="text-sm font-medium text-gray-500">Metode Pembayaran</label>
                    <p class="text-gray-800">{{ $booking->payment->method }}</p>
                </div>
                @endif
                @if($booking->payment->payment_type)
                <div>
                    <label class="text-sm font-medium text-gray-500">Tipe Pembayaran</label>
                    <p class="text-gray-800">{{ $booking->payment->payment_type }}</p>
                </div>
                @endif
                @if($booking->payment->va_number)
                <div>
                    <label class="text-sm font-medium text-gray-500">Nomor VA</label>
                    <p class="text-gray-800 font-mono">{{ $booking->payment->va_number }}</p>
                </div>
                @endif
                @if($booking->payment->midtrans_transaction_id)
                <div>
                    <label class="text-sm font-medium text-gray-500">Transaction ID</label>
                    <p class="text-gray-800 font-mono text-sm">{{ $booking->payment->midtrans_transaction_id }}</p>
                </div>
                @endif
                @if($booking->payment->fraud_status)
                <div>
                    <label class="text-sm font-medium text-gray-500">Fraud Status</label>
                    <p class="text-gray-800">{{ $booking->payment->fraud_status }}</p>
                </div>
                @endif
                @if($booking->payment->paid_at)
                <div>
                    <label class="text-sm font-medium text-gray-500">Tanggal Pembayaran</label>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->payment->paid_at)->format('d M Y H:i') }}</p>
                </div>
                @endif
                @if($booking->payment->settlement_time)
                <div>
                    <label class="text-sm font-medium text-gray-500">Waktu Settlement</label>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->payment->settlement_time)->format('d M Y H:i') }}</p>
                </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Timestamp -->
        <div class="bg-white rounded-lg shadow-md p-6 mt-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4 border-b pb-2">Informasi Waktu</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-500">Dibuat Pada</label>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y H:i:s') }}</p>
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-500">Terakhir Diupdate</label>
                    <p class="text-gray-800">{{ \Carbon\Carbon::parse($booking->updated_at)->format('d M Y H:i:s') }}</p>
                </div>
            </div>
        </div>
    </div>
</x-admin.app>
