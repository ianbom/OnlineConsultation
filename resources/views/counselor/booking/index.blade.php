<x-counselor.app>
    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="bookingTable">
        <!-- Header -->
        <div class="flex items-center p-3 overflow-x-auto panel whitespace-nowrap text-primary">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" fill="none" class="h-3.5 w-3.5">
                    <path d="M8 7V3M16 7V3M7 11H17M5 21H19C20.1 21 21 20.1 21 19V7C21 5.9 20.1 5 19 5H5C3.9 5 3 5.9 3 7V19C3 20.1 3.9 21 5 21Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Data Booking</span>
        </div>

        <div class="mt-4 md:mt-6 panel">
            <div class="flex items-center justify-between mb-4 md:mb-5">
                <h5 class="text-base md:text-lg font-semibold dark:text-white-light">Daftar Booking</h5>
            </div>

            <!-- Desktop Table View -->
            <div class="hidden lg:block table-responsive">
                <table id="tableBooking" class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Klien</th>
                            <th>Jadwal</th>
                            <th>Tipe</th>
                            <th>Status</th>
                            <th>Reschedule</th>
                            <th>Pembayaran</th>
                            <th>Dibuat Pada</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="font-medium">{{ $booking->client->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->client->email ?? '-' }}</div>
                                </td>
                                <td>
                                    @if($booking->secondSchedule)
                                        <div class="mb-2">
                                            <div class="font-medium">
                                                {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                            </div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->secondSchedule->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($booking->secondSchedule->end_time)->format('H:i') }}
                                            </div>
                                        </div>
                                    @else
                                        @if($booking->schedule)
                                            <div class="font-medium">
                                                {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500">
                                                {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                                {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                            </div>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    @endif
                                    @if($booking->status === 'rescheduled' && $booking->previousSchedule)
                                        <div class="text-xs text-yellow-600 mt-1 flex items-center">
                                            <i class="fas fa-info-circle mr-1"></i>
                                            Dijadwalkan ulang
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if ($booking->consultation_type === 'online')
                                        <span class="badge bg-info">Online</span>
                                    @else
                                        <span class="badge bg-primary">Offline</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($booking->status === 'pending_payment')
                                        <span class="badge bg-warning">Menunggu Pembayaran</span>
                                    @elseif ($booking->status === 'paid')
                                        <span class="badge bg-success">Dibayar</span>
                                    @elseif ($booking->status === 'cancelled')
                                        <span class="badge bg-danger">Dibatalkan</span>
                                    @elseif ($booking->status === 'completed')
                                        <span class="badge bg-primary">Selesai</span>
                                    @elseif ($booking->status === 'rescheduled')
                                        <span class="badge bg-info">Dijadwalkan Ulang</span>
                                    @else
                                        <span class="badge bg-purple-300">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = $booking->reschedule_status;
                                        $by = $booking->reschedule_by;
                                        $byLabel = $by ? ucfirst($by) : '-';
                                        $target = $by === 'client' ? 'Counselor' : ($by === 'counselor' ? 'Client' : null);
                                    @endphp
                                    @if ($status === 'none')
                                        <span class="badge bg-gray-500">-</span>
                                    @elseif ($status === 'pending')
                                        <span class="badge bg-warning">Pending</span>
                                    @elseif ($status === 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @elseif ($status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @else
                                        <span class="badge bg-purple-500">{{ ucfirst($status) }}</span>
                                    @endif
                                    @if($status !== 'none')
                                        <div class="text-xs text-gray-500 mt-1">
                                            Diajukan oleh: <span class="font-medium">{{ $byLabel }}</span>
                                        </div>
                                    @endif
                                    @if($status === 'pending')
                                        <div class="text-xs text-blue-600 mt-1">
                                            Menunggu {{ $target ?? '-' }}
                                        </div>
                                    @elseif($status === 'approved')
                                        <div class="text-xs text-green-600 mt-1">
                                            Disetujui oleh {{ $target ?? '-' }}
                                        </div>
                                    @elseif($status === 'rejected')
                                        <div class="text-xs text-red-600 mt-1">
                                            Ditolak oleh {{ $target ?? '-' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($booking->payment)
                                        @if ($booking->payment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($booking->payment->status === 'success')
                                            <span class="badge bg-success">Berhasil</span>
                                        @elseif ($booking->payment->status === 'failed')
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-purple-500">{{ ucfirst($booking->payment->status) }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-sm">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($booking->created_at)->format('H:i') }}
                                    </div>
                                </td>
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('counselor.booking.show', $booking->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-4">Tidak ada data booking</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="block lg:hidden space-y-4">
                @forelse($bookings as $index => $booking)
                    <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4 bg-white dark:bg-gray-800">
                        <!-- Header Card -->
                        <div class="flex justify-between items-start mb-3 pb-3 border-b border-gray-200 dark:border-gray-700">
                            <div class="flex-1">
                                <div class="font-semibold text-sm text-gray-900 dark:text-white">
                                    {{ $booking->client->name ?? '-' }}
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">
                                    {{ $booking->client->email ?? '-' }}
                                </div>
                            </div>
                            <div class="text-xs font-medium text-gray-500 ml-2">
                                #{{ $index + 1 }}
                            </div>
                        </div>

                        <!-- Jadwal -->
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-500 mb-1">Jadwal</div>
                            @if($booking->secondSchedule)
                                <div class="mb-2">
                                    <div class="font-medium text-sm">
                                        {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                    </div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->secondSchedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->secondSchedule->end_time)->format('H:i') }}
                                    </div>
                                </div>
                            @else
                                @if($booking->schedule)
                                    <div class="font-medium text-sm">
                                        {{ \Carbon\Carbon::parse($booking->schedule->date)->format('d M Y') }}
                                    </div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">
                                        {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                                        {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
                                    </div>
                                @else
                                    <span class="text-gray-400 text-sm">-</span>
                                @endif
                            @endif
                            @if($booking->status === 'rescheduled' && $booking->previousSchedule)
                                <div class="text-xs text-yellow-600 mt-1 flex items-center">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Dijadwalkan ulang
                                </div>
                            @endif
                        </div>

                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-3 mb-3">
                            <!-- Tipe Konsultasi -->
                            <div>
                                <div class="text-xs font-medium text-gray-500 mb-1">Tipe</div>
                                @if ($booking->consultation_type === 'online')
                                    <span class="badge bg-info text-xs">Online</span>
                                @else
                                    <span class="badge bg-primary text-xs">Offline</span>
                                @endif
                            </div>

                            <!-- Status Booking -->
                            <div>
                                <div class="text-xs font-medium text-gray-500 mb-1">Status</div>
                                @if ($booking->status === 'pending_payment')
                                    <span class="badge bg-warning text-xs">Menunggu Pembayaran</span>
                                @elseif ($booking->status === 'paid')
                                    <span class="badge bg-success text-xs">Dibayar</span>
                                @elseif ($booking->status === 'cancelled')
                                    <span class="badge bg-danger text-xs">Dibatalkan</span>
                                @elseif ($booking->status === 'completed')
                                    <span class="badge bg-primary text-xs">Selesai</span>
                                @elseif ($booking->status === 'rescheduled')
                                    <span class="badge bg-info text-xs">Dijadwalkan Ulang</span>
                                @else
                                    <span class="badge bg-secondary text-xs">{{ ucfirst($booking->status) }}</span>
                                @endif
                            </div>
                        </div>

                        <!-- Status Reschedule -->
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-500 mb-1">Reschedule</div>
                            @php
                                $status = $booking->reschedule_status;
                                $by = $booking->reschedule_by;
                                $byLabel = $by ? ucfirst($by) : '-';
                                $target = $by === 'client' ? 'Counselor' : ($by === 'counselor' ? 'Client' : null);
                            @endphp
                            <div>
                                @if ($status === 'none')
                                    <span class="badge bg-gray-500 text-xs">-</span>
                                @elseif ($status === 'pending')
                                    <span class="badge bg-warning text-xs">Pending</span>
                                @elseif ($status === 'approved')
                                    <span class="badge bg-success text-xs">Disetujui</span>
                                @elseif ($status === 'rejected')
                                    <span class="badge bg-danger text-xs">Ditolak</span>
                                @else
                                    <span class="badge bg-purple-500 text-xs">{{ ucfirst($status) }}</span>
                                @endif
                            </div>
                            @if($status !== 'none')
                                <div class="text-xs text-gray-500 mt-1">
                                    Diajukan oleh: <span class="font-medium">{{ $byLabel }}</span>
                                </div>
                            @endif
                            @if($status === 'pending')
                                <div class="text-xs text-blue-600 mt-1">
                                    Menunggu {{ $target ?? '-' }}
                                </div>
                            @elseif($status === 'approved')
                                <div class="text-xs text-green-600 mt-1">
                                    Disetujui oleh {{ $target ?? '-' }}
                                </div>
                            @elseif($status === 'rejected')
                                <div class="text-xs text-red-600 mt-1">
                                    Ditolak oleh {{ $target ?? '-' }}
                                </div>
                            @endif
                        </div>

                        <!-- Status Pembayaran -->
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-500 mb-1">Status Pembayaran</div>
                            @if($booking->payment)
                                @if ($booking->payment->status === 'pending')
                                    <span class="badge bg-warning text-xs">Pending</span>
                                @elseif ($booking->payment->status === 'success')
                                    <span class="badge bg-success text-xs">Berhasil</span>
                                @elseif ($booking->payment->status === 'failed')
                                    <span class="badge bg-danger text-xs">Gagal</span>
                                @else
                                    <span class="badge bg-purple-500 text-xs">{{ ucfirst($booking->payment->status) }}</span>
                                @endif
                            @else
                                <span class="text-gray-400 text-sm">-</span>
                            @endif
                        </div>

                        <!-- Dibuat Pada -->
                        <div class="mb-3">
                            <div class="text-xs font-medium text-gray-500 mb-1">Dibuat Pada</div>
                            <div class="text-sm font-medium">
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y') }}
                            </div>
                            <div class="text-xs text-gray-600 dark:text-gray-400">
                                {{ \Carbon\Carbon::parse($booking->created_at)->format('H:i') }}
                            </div>
                        </div>

                        <!-- Action Button -->
                        <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
                            <a href="{{ route('counselor.booking.show', $booking->id) }}"
                                class="btn btn-sm btn-outline-info w-full justify-center">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center p-8 text-gray-500">
                        Tidak ada data booking
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("bookingTable", () => ({
                init() {
                    // Only initialize datatable on desktop
                    if (window.innerWidth >= 1024) {
                        new simpleDatatables.DataTable('#tableBooking', {
                            searchable: true,
                            sortable: true,
                            labels: {
                                placeholder: "Cari...",
                                noRows: "Tidak ada data",
                                info: "Menampilkan {start} sampai {end} dari {rows} data",
                            }
                        });
                    }
                }
            }));
        });
    </script>

</x-counselor.app>
