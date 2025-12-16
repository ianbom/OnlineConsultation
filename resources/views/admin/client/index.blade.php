<x-admin.app>

    <script src="/assets/js/simple-datatables.js"></script>

    <div x-data="clientTable">
        <div class="flex items-center p-3 overflow-x-auto panel whitespace-nowrap text-primary">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" fill="none" class="h-3.5 w-3.5">
                    <path d="M16 7C16 9.2 14.2 11 12 11C9.8 11 8 9.2 8 7C8 4.8 9.8 3 12 3C14.2 3 16 4.8 16 7Z"
                        stroke="currentColor" stroke-width="1.5" />
                    <path d="M12 14C8.1 14 5 17.1 5 21H19C19 17.1 15.9 14 12 14Z"
                        stroke="currentColor" stroke-width="1.5" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Data Client</span>
        </div>

        <div class="mt-6 panel">
            <div class="flex items-center justify-between mb-5">
                <h5 class="text-lg font-semibold dark:text-white-light">Daftar Client</h5>
            </div>

            <div class="table-responsive">
                <table id="tableClient" class="whitespace-nowrap table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Status Email</th>
                            <th>Bergabung</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($clients as $index => $client)
                            <tr>
                                <td>{{ $index + 1 }}</td>

                                {{-- NAMA --}}
                                <td>
                                    <div class="font-medium">{{ $client->name }}</div>
                                </td>

                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone ?? '-' }}</td>

                                {{-- STATUS EMAIL --}}
                                <td>
                                    @if ($client->email_verified_at)
                                        <span class="badge bg-success">Terverifikasi</span>
                                    @else
                                        <span class="badge bg-warning">Belum Verifikasi</span>
                                    @endif
                                </td>

                                {{-- TANGGAL BERGABUNG --}}
                                <td>{{ $client->created_at->format('d M Y') }}</td>

                                {{-- AKSI --}}
                                <td class="text-center">
                                    <div class="flex items-center justify-center gap-2">
                                        <a href="{{ route('admin.client.show', $client->id) }}"
                                            class="btn btn-sm btn-outline-info" title="Detail">
                                            Detail
                                        </a>
                                    </div>
                                </td>
                            </tr>

                        @empty
                            <tr>
                                <td colspan="8" class="text-center p-4">Tidak ada data client</td>
                            </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("clientTable", () => ({
                init() {
                    new simpleDatatables.DataTable('#tableClient', {});
                }
            }));
        });
    </script>

</x-admin.app>
