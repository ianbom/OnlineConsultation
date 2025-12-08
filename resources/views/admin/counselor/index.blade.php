<x-admin.app>

    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="counselorTable">
        <div class="flex items-center p-3 overflow-x-auto panel whitespace-nowrap text-primary">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" fill="none" class="h-3.5 w-3.5">
                    <path d="M16 7C16 9.2 14.2 11 12 11C9.8 11 8 9.2 8 7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7Z"
                        stroke="currentColor" stroke-width="1.5" />
                    <path d="M12 14C8.1 14 5 17.1 5 21H19C19 17.1 15.9 14 12 14Z"
                        stroke="currentColor" stroke-width="1.5" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Data Counselor</span>
        </div>

        <div class="mt-6 panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Daftar Counselor</h5>
                <a href="{{ route('admin.counselor.create') }}" class="btn btn-primary">
                    <svg width="24" height="24" fill="none" class="w-4.5 h-4.5 ltr:mr-2 rtl:ml-2">
                        <path d="M16 7C16 9.2 14.2 11 12 11C9.8 11 8 9.2 8 7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7Z"
                            stroke="currentColor" stroke-width="1.5" />
                        <path d="M12 14C8.1 14 5 17.1 5 21H19C19 17.1 15.9 14 12 14Z"
                            stroke="currentColor" stroke-width="1.5" />
                    </svg>
                    Tambah Counselor
                </a>
            </div>

            <div class="table-responsive">
                <table id="tableCounselor" class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Counselor</th>
                            <th>Email</th>
                            <th>Spesialisasi</th>
                            <th>Harga Sesi</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($counselors as $index => $counselor)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- FOTO + NAMA --}}
                                <td>
                                    <div class="flex items-center">
                                        <div>
                                            <div class="font-medium">{{ $counselor->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $counselor->education }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $counselor->user->email }}</td>
                                <td>{{ $counselor->specialization }}</td>

                                <td>Rp {{ number_format($counselor->price_per_session, 0, ',', '.') }}</td>

                                <td>
                                    @if ($counselor->status === 'active')
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-warning">Nonaktif</span>
                                    @endif
                                </td>

                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.counselor.show', $counselor->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail">
                                            Detail
                                        </a>

                                        <a href="{{ route('admin.counselor.edit', $counselor->id) }}"
                                            class="btn btn-sm btn-outline-warning" title="Edit">
                                            Edit
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="7" class="text-center p-4">Tidak ada data counselor</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("counselorTable", () => ({
                init() {
                    new simpleDatatables.DataTable('#tableCounselor', {});
                }
            }));
        });
    </script>

</x-admin.app>
