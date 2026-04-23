<x-admin.app>

    @php
        $currentSort = request('sort_by', 'created_at');
        $currentDir = request('sort_dir', 'desc');
        $perPage = request('per_page', 10);
    @endphp

    <div>
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

            <form method="GET" action="{{ route('admin.booking.export') }}" class="mb-5">
                <div class="rounded-md border border-primary/20 bg-primary/5 p-4">
                    <div class="flex flex-wrap items-end gap-3">
                        <div class="w-full md:w-[180px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Mulai Jadwal</label>
                            <input type="date" name="date_from" value="{{ request('date_from') }}" class="form-input w-full" />
                        </div>
                        <div class="w-full md:w-[180px]">
                            <label class="block text-xs font-medium text-gray-500 mb-1">Tanggal Akhir Jadwal</label>
                            <input type="date" name="date_to" value="{{ request('date_to') }}" class="form-input w-full" />
                        </div>
                        <div class="flex gap-2">
                            <button type="submit" name="export" value="range" class="btn btn-success h-[38px]">
                                Export Rentang Tanggal
                            </button>
                            <button type="submit" name="export" value="all" class="btn btn-outline-success h-[38px]">
                                Export Semua
                            </button>
                        </div>
                    </div>
                    <p class="mt-2 text-xs text-gray-500">
                        Export menggunakan tanggal jadwal sesi konsultasi.
                    </p>
                </div>
            </form>

            {{-- TOOLBAR: Search + Filters + Per Page --}}
            <form method="GET" action="{{ route('admin.booking.index') }}" class="mb-5">
                {{-- Preserve sort params --}}
                <input type="hidden" name="sort_by" value="{{ $currentSort }}">
                <input type="hidden" name="sort_dir" value="{{ $currentDir }}">

                <div class="flex flex-wrap items-end gap-3">
                    {{-- Search --}}
                    <div class="flex-1 min-w-[200px]">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Cari</label>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari nama klien, konselor, atau ID..."
                            class="form-input w-full" />
                    </div>

                    {{-- Status Filter --}}
                    <div class="w-[160px]">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Status</label>
                        <select name="status" class="form-select w-full">
                            <option value="">Semua Status</option>
                            <option value="pending_payment" {{ request('status') === 'pending_payment' ? 'selected' : '' }}>Pending Payment</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            <option value="rescheduled" {{ request('status') === 'rescheduled' ? 'selected' : '' }}>Rescheduled</option>
                        </select>
                    </div>

                    {{-- Type Filter --}}
                    <div class="w-[130px]">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Tipe</label>
                        <select name="type" class="form-select w-full">
                            <option value="">Semua Tipe</option>
                            <option value="online" {{ request('type') === 'online' ? 'selected' : '' }}>Online</option>
                            <option value="offline" {{ request('type') === 'offline' ? 'selected' : '' }}>Offline</option>
                        </select>
                    </div>

                    {{-- Per Page --}}
                    <div class="w-[100px]">
                        <label class="block text-xs font-medium text-gray-500 mb-1">Per Halaman</label>
                        <select name="per_page" class="form-select w-full">
                            <option value="5" {{ $perPage == '5' ? 'selected' : '' }}>5</option>
                            <option value="10" {{ $perPage == '10' ? 'selected' : '' }}>10</option>
                            <option value="50" {{ $perPage == '50' ? 'selected' : '' }}>50</option>
                            <option value="100" {{ $perPage == '100' ? 'selected' : '' }}>100</option>
                            <option value="all" {{ $perPage === 'all' ? 'selected' : '' }}>Semua</option>
                        </select>
                    </div>

                    {{-- Buttons --}}
                    <div class="flex gap-2">
                        <button type="submit" class="btn btn-primary h-[38px]">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" class="mr-1">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                                <path d="M20 20L17 17" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                            Cari
                        </button>
                        <a href="{{ route('admin.booking.index') }}" class="btn btn-outline-dark h-[38px]">Reset</a>
                    </div>
                </div>
            </form>

            <div class="table-responsive">
                <table class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Klien</th>
                            <th>Counselor</th>
                            <th>Jadwal</th>
                            <th>
                                <a href="{{ route('admin.booking.index', array_merge(request()->all(), ['sort_by' => 'duration_hours', 'sort_dir' => ($currentSort === 'duration_hours' && $currentDir === 'asc') ? 'desc' : 'asc'])) }}"
                                    class="flex items-center gap-1 hover:text-primary">
                                    Durasi
                                    @if($currentSort === 'duration_hours')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="{{ $currentDir === 'asc' ? '' : 'rotate-180' }}">
                                            <path d="M12 4l-6 8h12z"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th>Tipe</th>
                            <th>
                                <a href="{{ route('admin.booking.index', array_merge(request()->all(), ['sort_by' => 'price', 'sort_dir' => ($currentSort === 'price' && $currentDir === 'asc') ? 'desc' : 'asc'])) }}"
                                    class="flex items-center gap-1 hover:text-primary">
                                    Harga
                                    @if($currentSort === 'price')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="{{ $currentDir === 'asc' ? '' : 'rotate-180' }}">
                                            <path d="M12 4l-6 8h12z"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.booking.index', array_merge(request()->all(), ['sort_by' => 'status', 'sort_dir' => ($currentSort === 'status' && $currentDir === 'asc') ? 'desc' : 'asc'])) }}"
                                    class="flex items-center gap-1 hover:text-primary">
                                    Status
                                    @if($currentSort === 'status')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="{{ $currentDir === 'asc' ? '' : 'rotate-180' }}">
                                            <path d="M12 4l-6 8h12z"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="{{ route('admin.booking.index', array_merge(request()->all(), ['sort_by' => 'created_at', 'sort_dir' => ($currentSort === 'created_at' && $currentDir === 'asc') ? 'desc' : 'asc'])) }}"
                                    class="flex items-center gap-1 hover:text-primary">
                                    Dibuat Pada
                                    @if($currentSort === 'created_at')
                                        <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor" class="{{ $currentDir === 'asc' ? '' : 'rotate-180' }}">
                                            <path d="M12 4l-6 8h12z"/>
                                        </svg>
                                    @endif
                                </a>
                            </th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @php
                            $isCollection = $bookings instanceof \Illuminate\Support\Collection;
                            $startNum = $isCollection ? 1 : $bookings->firstItem();
                        @endphp
                        @forelse($bookings as $index => $booking)
                            <tr>
                                <td>{{ $startNum + $index }}</td>

                                {{-- KLIEN --}}
                                <td>
                                    <div class="max-w-[100px]">
                                        <div class="font-medium truncate" title="{{ $booking->client->name }}">{{ $booking->client->name }}</div>
                                        <div class="text-xs text-gray-500 truncate" title="{{ $booking->client->email }}">{{ $booking->client->email }}</div>
                                    </div>
                                </td>

                                {{-- COUNSELOR --}}
                                <td>
                                    <div class="max-w-[100px]">
                                        <div class="font-medium truncate" title="{{ $booking->counselor->user->name }}">{{ $booking->counselor->user->name }}</div>
                                        <div class="text-xs text-gray-500 truncate" title="{{ $booking->counselor->specialization }}">{{ $booking->counselor->specialization }}</div>
                                    </div>
                                </td>

                                {{-- JADWAL --}}
                                <td>
                                    <div class="font-medium">{{ \Carbon\Carbon::parse($booking->schedule->date)->format('d-m-Y') }}</div>
                                    <div class="text-xs text-gray-500">
                                        {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }}
                                    </div>
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

                                {{-- STATUS --}}
                                <td>
                                    @if ($booking->status === 'pending_payment')
                                        <span class="badge bg-warning">Pending Payment</span>
                                    @elseif ($booking->status === 'paid')
                                        <span class="badge bg-success">Paid</span>
                                    @elseif ($booking->status === 'cancelled')
                                        <span class="badge bg-danger">Cancelled</span>
                                    @elseif ($booking->status === 'completed')
                                        <span class="badge bg-primary">Completed</span>
                                    @elseif ($booking->status === 'rescheduled')
                                        <span class="badge bg-info">Rescheduled</span>
                                    @endif
                                </td>

                                {{-- DIBUAT PADA --}}
                                <td>
                                    <div class="text-xs text-gray-500">
                                        {{ optional($booking->created_at)->format('d-m-Y H:i') }}
                                    </div>
                                </td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.booking.show', $booking->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail">
                                            Detail
                                        </a>
                                    </div>
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center p-4">Tidak ada data booking</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            {{-- PAGINATION + INFO --}}
            @if(!$isCollection)
            <div class="flex flex-wrap items-center justify-between gap-3 mt-5">
                <div class="text-sm text-gray-500">
                    Menampilkan {{ $bookings->firstItem() ?? 0 }} - {{ $bookings->lastItem() ?? 0 }} dari {{ $bookings->total() }} data
                </div>
                <div>
                    {{ $bookings->links() }}
                </div>
            </div>
            @else
            <div class="mt-5 text-sm text-gray-500">
                Menampilkan semua {{ $bookings->count() }} data
            </div>
            @endif
        </div>
    </div>

</x-admin.app>
