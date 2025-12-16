@props(['bookings'])

<!-- Recent Bookings Table -->
<div class="mb-6">
    <h2 class="text-xl font-semibold mb-4 dark:text-white-light">Booking Terbaru</h2>
    <div class="panel overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-gray-300 dark:border-gray-700">
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">ID</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Klien</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Konselor</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Status</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Pembayaran</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Dibuat pada</th>
                    <th class="px-4 py-3 text-left font-semibold dark:text-white-light">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $booking)
                    <tr class="border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-800">
                        <td class="px-4 py-3 text-sm dark:text-white-light">#{{ $booking->id }}</td>
                        <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->client->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->counselor->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-sm">
                            @if($booking->status === 'completed')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Completed</span>
                            @elseif($booking->status === 'cancelled')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Cancelled</span>
                            @elseif($booking->status === 'rescheduled')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Rescheduled</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-info/10 text-info">{{ ucfirst($booking->status) }}</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm dark:text-white-light">
                            @if($booking->payment && $booking->payment->status === 'success')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-success/10 text-success">Paid</span>
                            @elseif($booking->payment && $booking->payment->status === 'pending')
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-warning/10 text-warning">Pending</span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-semibold bg-danger/10 text-danger">Failed</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-sm dark:text-white-light">{{ $booking->created_at->format('d M Y') }}</td>
                        <td class="px-4 py-3 text-sm">
                            <a
                                href="{{ route('admin.booking.show', $booking->id) }}"
                                class="inline-flex items-center px-3 py-1 text-xs font-semibold
                                       bg-primary/10 text-primary rounded-md hover:bg-primary hover:text-white transition"
                            >
                                Lihat
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-gray-500 dark:text-gray-400">Tidak ada data booking</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
