<x-admin.app>

    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="refundTable">
        <div class="flex items-center p-3 overflow-x-auto panel whitespace-nowrap text-primary">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" fill="none" class="h-3.5 w-3.5">
                    <path d="M12 8V12L15 15M21 12C21 16.9706 16.9706 21 12 21C7.02944 21 3 16.9706 3 12C3 7.02944 7.02944 3 12 3C16.9706 3 21 7.02944 21 12Z"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Data Refund</span>
        </div>

        <div class="mt-6 panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Daftar Refund</h5>
            </div>

            <div class="table-responsive">
                <table id="tableRefund" class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Order ID</th>
                            <th>Klien</th>
                            <th>Jumlah Refund</th>
                            <th>Alasan</th>
                            <th>Metode Pembayaran</th>
                            <th>Status Transaksi</th>
                            <th>Waktu Refund</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($paymentRefunds as $index => $refund)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- ORDER ID --}}
                                <td>
                                    <div class="font-medium">{{ $refund->order_id }}</div>
                                    <div class="text-xs text-gray-500">Booking #{{ $refund->booking_id }}</div>
                                </td>

                                {{-- KLIEN --}}
                                <td>
                                    <div class="font-medium">{{ $refund->booking->client->name }}</div>
                                    <div class="text-xs text-gray-500">{{ $refund->booking->client->email }}</div>
                                </td>

                                {{-- JUMLAH REFUND --}}
                                <td>
                                    <div class="font-semibold text-danger">Rp {{ number_format($refund->refund_amount, 0, ',', '.') }}</div>

                                </td>

                                {{-- ALASAN REFUND --}}
                                <td>
                                    <div class="max-w-xs">
                                        {{ Str::limit($refund->refund_reason, 50) }}
                                    </div>
                                </td>

                                {{-- METODE PEMBAYARAN --}}
                                <td>
                                    @if ($refund->payment_type === 'bank_transfer')
                                        <span class="badge bg-info">Bank Transfer</span>
                                        @if($refund->va_number)
                                            <div class="text-xs text-gray-500 mt-1">VA: {{ substr($refund->va_number, 0, 10) }}...</div>
                                        @endif
                                    @elseif ($refund->payment_type === 'gopay')
                                        <span class="badge bg-success">GoPay</span>
                                    @elseif ($refund->payment_type === 'qris')
                                        <span class="badge bg-primary">QRIS</span>
                                    @else
                                        <span class="badge bg-secondary">{{ ucfirst($refund->payment_type ?? 'N/A') }}</span>
                                    @endif
                                </td>

                                {{-- STATUS TRANSAKSI --}}
                                <td>
                                    @if ($refund->status === 'refund')
                                        <span class="badge bg-warning">Refund</span>
                                    @elseif ($refund->status === 'success')
                                        <span class="badge bg-success">Success</span>
                                    @elseif ($refund->status === 'pending')
                                        <span class="badge bg-info">Pending</span>
                                    @elseif ($refund->status === 'failed')
                                        <span class="badge bg-danger">Failed</span>
                                    @endif

                                    @if($refund->fraud_status === 'accept')
                                        <div class="text-xs text-success mt-1">✓ Verified</div>
                                    @endif
                                </td>

                                {{-- WAKTU REFUND --}}
                                <td>
                                    <div class="font-medium">{{ \Carbon\Carbon::parse($refund->refund_time)->format('d/m/Y') }}</div>
                                    <div class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($refund->refund_time)->format('H:i') }}</div>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.refund.show', $refund->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="9" class="text-center p-4">Tidak ada data refund</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("refundTable", () => ({
                init() {
                    new simpleDatatables.DataTable('#tableRefund', {
                        searchable: true,
                        sortable: true,
                        perPage: 10,
                        perPageSelect: [10, 25, 50, 100]
                    });
                }
            }));
        });
    </script>

</x-admin.app>
