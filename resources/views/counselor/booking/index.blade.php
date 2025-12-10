<x-counselor.app>
    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="bookingTable">
        <div class="flex items-center p-3 overflow-x-auto panel whitespace-nowrap text-primary">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" fill="none" class="h-3.5 w-3.5">
                    <path d="M8 7V3M16 7V3M7 11H17M5 21H19C20.1 21 21 20.1 21 19V7C21 5.9 20.1 5 19 5H5C3.9 5 3 5.9 3 7V19C3 20.1 3.9 21 5 21Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Data Booking</span>
        </div>

        <div class="mt-6 panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Daftar Booking</h5>
            </div>

            <div class="table-responsive">
                <table id="tableBooking" class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Klien</th>
                            <th>Jadwal</th>
                            <th>Durasi</th>
                            <th>Tipe</th>
                            <th>Harga</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- KLIEN --}}
                                <td>
                                    <div class="font-medium">{{ $booking->client->name ?? '-' }}</div>
                                    <div class="text-xs text-gray-500">{{ $booking->client->email ?? '-' }}</div>
                                </td>

                                {{-- JADWAL --}}
                                <td>
                                    @php
                                        $schedule = $booking->secondSchedule ?? $booking->schedule;
                                    @endphp

                                    @if($schedule)
                                        <div class="font-medium">
                                            {{ \Carbon\Carbon::parse($schedule->date)->format('d M Y') }}
                                        </div>

                                        <div class="text-xs text-gray-500">
                                            {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                        </div>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif


                                    {{-- Tampilkan info jika di-reschedule --}}
                                    @if($booking->status === 'rescheduled' && $booking->previousSchedule)
                                        <div class="text-xs text-warning mt-1">
                                            <i class="fas fa-info-circle"></i> Dijadwalkan ulang
                                        </div>
                                    @endif
                                </td>

                                {{-- DURASI --}}
                                <td>{{ $booking->duration_hours }} jam</td>

                                {{-- TIPE KONSULTASI --}}
                                <td>
                                    @if ($booking->consultation_type === 'online')
                                        <span class="badge bg-info">Online</span>
                                    @else
                                        <span class="badge bg-primary">Offline</span>
                                    @endif
                                </td>

                                {{-- HARGA --}}
                                <td>Rp {{ number_format($booking->price, 0, ',', '.') }}</td>

                                {{-- STATUS BOOKING --}}
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
                                        <span class="badge bg-secondary">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>

                                {{-- STATUS PEMBAYARAN --}}
                                <td>
                                    @if($booking->payment)
                                        @if ($booking->payment->status === 'pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif ($booking->payment->status === 'success')
                                            <span class="badge bg-success">Berhasil</span>
                                        @elseif ($booking->payment->status === 'failed')
                                            <span class="badge bg-danger">Gagal</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($booking->payment->status) }}</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                                {{-- AKSI --}}
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
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("bookingTable", () => ({
                init() {
                    new simpleDatatables.DataTable('#tableBooking', {
                        searchable: true,
                        sortable: true,
                        perPage: 10,
                        perPageSelect: [10, 25, 50, 100],
                        labels: {
                            placeholder: "Cari...",
                            perPage: "data per halaman",
                            noRows: "Tidak ada data",
                            info: "Menampilkan {start} sampai {end} dari {rows} data",
                        }
                    });
                }
            }));
        });
    </script>

</x-counselor.app>
