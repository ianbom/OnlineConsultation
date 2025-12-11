<x-counselor.app>


<div class="min-h-screen py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6 flex items-center justify-between">
                {{-- Left Section --}}
                <div>
                    <a href="{{ route('counselor.booking.index') }}"
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
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <div class="flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-gray-900">Status Booking</h2>
                        <span class="px-4 py-2 rounded-full text-sm font-semibold
                            @if($booking->status === 'completed') bg-green-100 text-green-800
                            @elseif($booking->status === 'paid') bg-blue-100 text-blue-800
                            @elseif($booking->status === 'pending_payment') bg-yellow-100 text-yellow-800
                            @elseif($booking->status === 'cancelled') bg-red-100 text-red-800
                            @elseif($booking->status === 'rescheduled') bg-purple-100 text-purple-800
                            @else bg-gray-100 text-gray-800
                            @endif">
                            {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                        </span>
                    </div>
                </div>

                <!-- Client Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Klien</h2>
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0">
                            @if($booking->client->profile_pic)
                                <img src="{{ asset('storage/' . $booking->client->profile_pic) }}"
                                     alt="{{ $booking->client->name }}"
                                     class="w-16 h-16 rounded-full object-cover border-2 border-gray-200">
                            @else
                                <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                                    <span class="text-2xl font-bold text-white">
                                        {{ substr($booking->client->name, 0, 1) }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1">
                            <h3 class="text-xl font-semibold text-gray-900">{{ $booking->client->name }}</h3>
                            <div class="mt-3 space-y-2">
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    {{ $booking->client->email }}
                                </div>
                                @if($booking->client->phone)
                                <div class="flex items-center text-gray-600">
                                    <svg class="w-5 h-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                    </svg>
                                    {{ $booking->client->phone }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Schedule Information -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Konsultasi</h2>

                    <!-- Current Schedule -->
                    <div class="border-l-4 border-primary pl-4 py-2 mb-4">
                        <p class="text-sm text-gray-500 mb-1">Jadwal Aktif</p>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->schedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2 mt-2">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>

                    @if($booking->second_schedule_id)
                    <!-- Second Schedule -->
                    <div class="border-l-4 border-green-500 pl-4 py-2 mb-4">
                        <p class="text-sm text-gray-500 mb-1">Jadwal Kedua</p>
                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="font-semibold text-gray-900">
                                {{ \Carbon\Carbon::parse($booking->secondSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>
                        <div class="flex items-center space-x-2 mt-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->secondSchedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->secondSchedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @endif

                                        {{-- Previous MAIN Schedule --}}
                    @if($booking->previous_schedule_id && $booking->previousSchedule)
                    <div class="border-l-4 border-gray-400 pl-4 py-2 bg-gray-50 mb-3">
                        <p class="text-sm text-gray-500 mb-1">Jadwal Sebelumnya (Dirubah)</p>

                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-700 line-through">
                                {{ \Carbon\Carbon::parse($booking->previousSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-600 line-through">
                                {{ \Carbon\Carbon::parse($booking->previousSchedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->previousSchedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @endif

                    {{-- Previous SECOND Schedule (Jika Ada) --}}
                    @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
                    <div class="border-l-4 border-gray-400 pl-4 py-2 bg-gray-50">
                        <p class="text-sm text-gray-500 mb-1">Jadwal Kedua Sebelumnya (Dirubah)</p>

                        <div class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="font-medium text-gray-700 line-through">
                                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
                            </span>
                        </div>

                        <div class="flex items-center space-x-2 mt-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <span class="text-gray-600 line-through">
                                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->start_time)->format('H:i') }} -
                                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->end_time)->format('H:i') }}
                            </span>
                        </div>
                    </div>
                    @endif

                </div>

                <!-- Reschedule Information -->
               @if($booking->reschedule_status !== 'none')
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Reschedule</h2>

                    {{-- STATUS KETERSEDIAAN JADWAL --}}
                    @php
                        $mainAvailable = $booking->schedule?->is_available;
                        $secondAvailable = $booking->secondSchedule?->is_available;

                        $anyUnavailable =
                            ($booking->schedule && !$booking->schedule->is_available) ||
                            ($booking->secondSchedule && !$booking->secondSchedule->is_available);

                        $allAvailable =
                            ($booking->schedule && $booking->schedule->is_available) &&
                            (!$booking->secondSchedule || $booking->secondSchedule->is_available);
                    @endphp

                    {{-- Jika PENDING dan ada jadwal tidak tersedia --}}
                    @if($booking->reschedule_status === 'pending' && $anyUnavailable)
                        <div class="mt-3 p-3 bg-red-100 border border-red-300 rounded-lg">
                            <p class="text-sm font-semibold text-red-700">
                                Jadwal ini sudah dipesan orang lain. Anda tidak bisa mengubah jadwal ini.
                            </p>
                        </div>
                    @endif

                    {{-- Jika PENDING dan semua jadwal tersedia --}}
                    @if($booking->reschedule_status === 'pending' && $allAvailable)
                        <div class="mt-3 p-3 bg-green-100 border border-green-300 rounded-lg">
                            <p class="text-sm font-semibold text-green-700">
                                Jadwal masih tersedia. Anda bisa menyetujui permintaan reschedule ini.
                            </p>
                        </div>
                    @endif


                    <div class="space-y-3 mt-4">

                        {{-- Status --}}
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Status Reschedule</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->reschedule_status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->reschedule_status === 'approved') bg-green-100 text-green-800
                                @elseif($booking->reschedule_status === 'rejected') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ ucfirst($booking->reschedule_status) }}
                            </span>
                        </div>

                        {{-- Requested by --}}
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Diminta Oleh</span>
                            <span class="font-semibold text-gray-900">
                                {{ $booking->reschedule_by ? ucfirst($booking->reschedule_by) : '-' }}
                            </span>
                        </div>

                        {{-- Reason --}}
                        @if($booking->reschedule_reason)
                        <div class="pb-3 border-b">
                            <span class="text-gray-600 text-sm">Alasan Reschedule</span>
                            <p class="mt-1 text-gray-800">{{ $booking->reschedule_reason }}</p>
                        </div>
                        @endif

                    </div>

                    {{-- APPROVE / REJECT BUTTONS --}}
                    @if($booking->reschedule_status === 'pending')
                    <div class="mt-4 flex flex-col md:flex-row gap-3">

                        {{-- Approve --}}
                        <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="statusReschedule" value="approved">

                            <button
                                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition w-full md:w-auto"
                                @if($anyUnavailable) disabled @endif
                            >
                                Setujui Reschedule
                            </button>
                        </form>

                        {{-- Reject --}}
                        <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="statusReschedule" value="rejected">

                            <input
                                type="text"
                                name="reason"
                                placeholder="Alasan penolakan..."
                                class="border rounded-lg px-3 py-2 w-full md:w-60 text-sm"
                            >

                            <button
                                class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition w-full md:w-auto">
                                Tolak Reschedule
                            </button>
                        </form>

                    </div>
                    @endif
                </div>
                @endif




                <!-- Notes -->
                @if($booking->notes)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Catatan Klien</h2>
                    <div class="bg-secondary border-l-4 border-primary p-4 rounded">
                        <p class="text-gray-700">{{ $booking->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Counselor Notes -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-3">Catatan Konselor</h2>
                    @if($booking->counselor_notes)
                        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
                            <p class="text-gray-700">{{ $booking->counselor_notes }}</p>
                        </div>
                    @else
                        <p class="text-gray-500 italic">Belum ada catatan dari konselor</p>
                        @if($booking->status === 'completed')
                        <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            Tambah Catatan
                        </button>
                        @endif
                    @endif
                </div>

                <!-- Cancellation Info -->
                @if($booking->status === 'cancelled')
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembatalan</h2>
                    <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded space-y-2">
                        @if($booking->cancelled_by)
                        <div class="flex items-center">
                            <span class="text-sm font-medium text-gray-700 mr-2">Dibatalkan oleh:</span>
                            <span class="px-2 py-1 bg-red-200 text-red-800 rounded text-sm font-semibold">
                                {{ ucfirst($booking->cancelled_by) }}
                            </span>
                        </div>
                        @endif

                        @if($booking->cancelled_at)
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Waktu:</span>
                            {{ \Carbon\Carbon::parse($booking->cancelled_at)->isoFormat('dddd, D MMMM YYYY HH:mm') }}
                        </p>
                        @endif

                        @if($booking->cancel_reason)
                        <div class="mt-3">
                            <p class="text-sm font-medium text-gray-700 mb-1">Alasan:</p>
                            <p class="text-gray-700">{{ $booking->cancel_reason }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            <!-- Sidebar -->
            <div class="space-y-6">

                <!-- Consultation Details -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Konsultasi</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Tipe Konsultasi</span>
                            <span class="flex items-center space-x-2">
                                @if($booking->consultation_type === 'online')
                                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                    </svg>
                                    <span class="font-semibold text-blue-600">Online</span>
                                @else
                                    <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                    </svg>
                                    <span class="font-semibold text-green-600">Offline</span>
                                @endif
                            </span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Durasi</span>
                            <span class="font-semibold text-gray-900">{{ $booking->duration_hours }} Jam</span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Harga</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($booking->price, 0, ',', '.') }}</span>
                        </div>

                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">Dibuat</span>
                            <span class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->created_at)->isoFormat('D MMM YYYY') }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- Meeting Link -->
                @if($booking->consultation_type === 'online' && $booking->meeting_link)
                <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
                    <h2 class="text-lg font-semibold mb-3">Link Meeting</h2>
                    <div class="bg-white bg-opacity-20 rounded-lg p-3 mb-3">
                        <p class="text-sm break-all">{{ $booking->meeting_link }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ $booking->meeting_link }}" target="_blank"
                           class="flex-1 bg-white text-blue-600 text-center py-2 px-4 rounded-lg font-semibold hover:bg-blue-50 transition">
                            Buka Link
                        </a>
                        <button onclick="copyToClipboard('{{ $booking->meeting_link }}')"
                                class="bg-white bg-opacity-20 hover:bg-opacity-30 py-2 px-4 rounded-lg transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                        </button>
                    </div>
                    @if($booking->link_status)
                    <p class="text-xs mt-3 text-blue-100">
                        Status: {{ ucfirst($booking->link_status) }}
                    </p>
                    @endif
                </div>
                @endif

                <!-- Payment Information -->
                @if($booking->payment)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Pembayaran</h2>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Status</span>
                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                @if($booking->payment->status === 'success') bg-green-100 text-green-800
                                @elseif($booking->payment->status === 'pending') bg-yellow-100 text-yellow-800
                                @elseif($booking->payment->status === 'failed') bg-red-100 text-red-800
                                @elseif($booking->payment->status === 'refund') bg-purple-100 text-purple-800
                                @endif">
                                {{ ucfirst($booking->payment->status) }}
                            </span>
                        </div>

                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Jumlah</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($booking->payment->amount, 0, ',', '.') }}</span>
                        </div>

                        @if($booking->payment->payment_type)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Metode</span>
                            <span class="text-gray-900">{{ str_replace('_', ' ', ucfirst($booking->payment->payment_type)) }}</span>
                        </div>
                        @endif

                        @if($booking->payment->va_number)
                        <div class="pb-3 border-b">
                            <span class="text-gray-600 text-sm">VA Number</span>
                            <p class="font-mono text-sm text-gray-900 mt-1">{{ $booking->payment->va_number }}</p>
                        </div>
                        @endif

                        @if($booking->payment->paid_at)
                        <div class="flex justify-between items-center pb-3 border-b">
                            <span class="text-gray-600">Dibayar</span>
                            <span class="text-sm text-gray-700">
                                {{ \Carbon\Carbon::parse($booking->payment->paid_at)->isoFormat('D MMM YYYY HH:mm') }}
                            </span>
                        </div>
                        @endif

                        @if($booking->payment->transaction_status)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600 text-sm">Transaction Status</span>
                            <span class="text-sm text-gray-700">{{ ucfirst($booking->payment->transaction_status) }}</span>
                        </div>
                        @endif
                    </div>

                    <!-- Refund Information -->
                    @if($booking->refund_status !== 'none')
                    <div class="mt-4 pt-4 border-t">
                        <h3 class="font-semibold text-gray-900 mb-2">Refund</h3>
                        <div class="bg-purple-50 border-l-4 border-purple-500 p-3 rounded space-y-1">
                            <p class="text-sm">
                                <span class="font-medium">Status:</span>
                                <span class="text-purple-700 font-semibold">{{ ucfirst($booking->refund_status) }}</span>
                            </p>
                            @if($booking->refund_processed_at)
                            <p class="text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($booking->refund_processed_at)->isoFormat('D MMM YYYY HH:mm') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>
                @endif



                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Input Link Meeting & Catatan Konselor</h2>

                    <form action="{{ route('counselor.booking.inputLinkandNotes', $booking->id) }}" method="POST" class="space-y-4">
                        @csrf
                        @method('PUT')
                        {{-- Meeting Link --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Link Meeting
                            </label>
                            <input type="text"
                                   name="meeting_link"
                                   value="{{ old('meeting_link', $booking->meeting_link) }}"
                                   placeholder="Masukkan link meeting jika online"
                                   class="w-full border rounded-lg px-3 py-2 focus:ring-primary focus:border-primary text-sm">
                        </div>

                        {{-- Link Status --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Status Link
                            </label>
                            <select name="link_status"
                                    class="w-full border rounded-lg px-3 py-2 text-sm focus:ring-primary focus:border-primary">
                                <option value="pending" {{ $booking->link_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="sent" {{ $booking->link_status === 'sent' ? 'selected' : '' }}>Terkirim</option>
                            </select>
                        </div>

                        {{-- Counselor Notes --}}
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Catatan Konselor
                            </label>
                            <textarea name="counselor_notes"
                                      rows="4"
                                      placeholder="Tulis catatan untuk klien..."
                                      class="w-full border rounded-lg px-3 py-2 focus:ring-primary focus:border-primary text-sm">{{ old('counselor_notes', $booking->counselor_notes) }}</textarea>
                        </div>

                        {{-- Submit Button --}}
                        <div class="flex justify-end">
                            <button type="submit"
                                    class="px-4 py-2 bg-primary text-white rounded-lg hover:bg-primary/80 transition">
                                Simpan
                            </button>
                        </div>

                    </form>
                </div>




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


</x-counselor.app>
