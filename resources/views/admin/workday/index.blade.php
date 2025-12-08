<x-admin.app>

<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Jadwal Kerja Konselor</h1>
            <p class="text-gray-600 text-sm">Kelola dan lihat jadwal kerja konselor</p>
        </div>

        <!-- Create Button -->
        <a href="{{ route('admin.workday.create') }}"
           class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </a>
    </div>


    <!-- Filter Section -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-4 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label for="filterCounselor" class="block text-sm font-medium text-gray-700 mb-1">
                    Filter Konselor
                </label>
                <input
                    type="text"
                    id="filterCounselor"
                    placeholder="Cari nama konselor..."
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                />
            </div>
            <div>
                <label for="filterDay" class="block text-sm font-medium text-gray-700 mb-1">
                    Filter Hari
                </label>
                <select
                    id="filterDay"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                >
                    <option value="">Semua Hari</option>
                    <option value="monday">Senin</option>
                    <option value="tuesday">Selasa</option>
                    <option value="wednesday">Rabu</option>
                    <option value="thursday">Kamis</option>
                    <option value="friday">Jumat</option>
                    <option value="saturday">Sabtu</option>
                    <option value="sunday">Minggu</option>
                </select>
            </div>
        </div>
    </div>

    <!-- Weekly Schedule Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-white border-b border-gray-200">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <th class="px-3 py-3 text-center text-xs font-semibold text-gray-800 uppercase tracking-wider border-r border-gray-200">
                            {{ $day }}
                        </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr class="align-top">
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'] as $day)
                        <td class="p-2 border-r border-gray-100 bg-gray-50/50 min-w-[140px]" data-day="{{ $day }}">
                            <div class="space-y-2" id="{{ $day }}-column">
                                @foreach($counselorsWorkDays as $workDay)
                                    @if($workDay->day_of_week === $day)
                                    <div class="workday-card bg-white rounded-lg shadow-xs border border-gray-200 hover:shadow-sm transition-shadow duration-200"
                                         data-counselor="{{ strtolower($workDay->counselor->user->name) }}"
                                         data-day="{{ $workDay->day_of_week }}">

                                        <!-- Card Header -->
                                        <div class="p-3 border-b border-gray-100">
                                            <div class="flex items-start justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-indigo-500 flex items-center justify-center">
                                                        <span class="text-black text-xs font-bold">
                                                            {{ strtoupper(substr($workDay->counselor->user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-sm font-semibold text-gray-900 leading-tight">
                                                            {{ \Illuminate\Support\Str::limit($workDay->counselor->user->name, 12) }}
                                                        </h3>

                                                    </div>
                                                </div>
                                                {{-- BADGE STATUS --}}
                                                @if ($workDay->is_active)
                                                    <!-- ACTIVE (Centang Hijau) -->
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px]
                                                                 font-medium bg-green-100 text-green-800">
                                                        <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                        </svg>
                                                    </span>
                                                @else
                                                    <!-- INACTIVE (Silang Merah) -->
                                                    <span class="inline-flex items-center px-1.5 py-0.5 rounded-full text-[10px]
                                                                 font-medium bg-red-100 text-red-800">
                                                        <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                            <path fill-rule="evenodd"
                                                                  d="M10 8.586l4.95-4.95a1 1 0 111.414 1.414L11.414 10l4.95 4.95a1 1 0 01-1.414 1.414L10 11.414l-4.95 4.95a1 1 0 01-1.414-1.414L8.586 10l-4.95-4.95A1 1 0 115.05 3.636L10 8.586z"/>
                                                        </svg>
                                                    </span>
                                                @endif

                                            </div>
                                        </div>

                                        <!-- Card Body -->
                                        <div class="p-3">
                                            <!-- Time Section -->
                                            <div class="flex items-center justify-between mb-3 text-xs text-gray-600">
                                                <div class="flex items-center space-x-1">
                                                    <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                    </svg>
                                                    <span class="font-medium">{{ date('H:i', strtotime($workDay->start_time)) }}</span>
                                                    <span class="text-gray-400">-</span>
                                                    <span class="font-medium">{{ date('H:i', strtotime($workDay->end_time)) }}</span>
                                                </div>
                                            </div>

                                            <!-- Price -->
                                            <div class="mb-3">
                                                <span class="inline-block w-full px-2 py-1 bg-blue-50 text-blue-700 text-xs font-semibold rounded">
                                                   Harga : Rp {{ number_format($workDay->counselor->price_per_session, 0, ',', '.') }}
                                                </span>
                                            </div>

                                            <!-- Actions -->
                                            <div class="flex space-x-1">
                                                <a href="{{ route('admin.workday.edit', $workDay->id) }}"
                                                   class="flex-1 bg-gray-50 hover:bg-gray-100 text-gray-700 font-medium py-1.5 px-2 rounded text-xs text-center transition-colors duration-150 border border-gray-200">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.workday.destroy', $workDay->id) }}" method="POST" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            onclick="return confirm('Yakin ingin menghapus jadwal ini?')"
                                                            class="w-full bg-gray-50 hover:bg-red-300 text-gray-700 font-medium py-1.5 px-2 rounded text-xs transition-colors duration-150 border border-gray-200">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endforeach

                                @if(!$counselorsWorkDays->where('day_of_week', $day)->count())
                                <div class="text-center py-3">
                                    <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                    </svg>
                                    <p class="text-xs text-gray-400">Tidak ada jadwal</p>
                                </div>
                                @endif
                            </div>
                        </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</div>

{{-- FILTER SCRIPT --}}
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterCounselor = document.getElementById('filterCounselor');
        const filterDay = document.getElementById('filterDay');
        const workDayCards = document.querySelectorAll('.workday-card');
        const noResults = document.getElementById('noResults');
        const dayColumns = document.querySelectorAll('td[data-day]');

        function filterCards() {
            const counselorValue = filterCounselor.value.toLowerCase();
            const dayValue = filterDay.value.toLowerCase();
            let visibleCount = 0;

            // Reset all columns to show empty state
            dayColumns.forEach(column => {
                const day = column.getAttribute('data-day');
                const hasVisibleCards = Array.from(column.querySelectorAll('.workday-card'))
                    .some(card => {
                        const counselorName = card.getAttribute('data-counselor');
                        const cardDay = card.getAttribute('data-day');

                        const matchCounselor = counselorName.includes(counselorValue);
                        const matchDay = dayValue === '' || cardDay === dayValue;

                        return matchCounselor && matchDay;
                    });

                // Show/hide cards in this column
                column.querySelectorAll('.workday-card').forEach(card => {
                    const counselorName = card.getAttribute('data-counselor');
                    const cardDay = card.getAttribute('data-day');

                    const matchCounselor = counselorName.includes(counselorValue);
                    const matchDay = dayValue === '' || cardDay === dayValue;

                    if (matchCounselor && matchDay) {
                        card.style.display = 'block';
                        visibleCount++;
                    } else {
                        card.style.display = 'none';
                    }
                });

                // Show/hide empty state for this column
                const emptyState = column.querySelector('.text-center.py-3');
                if (emptyState) {
                    emptyState.style.display = hasVisibleCards ? 'none' : 'block';
                }
            });

            // Show/hide global no results message
            noResults.classList.toggle('hidden', visibleCount !== 0);
        }

        filterCounselor.addEventListener('input', filterCards);
        filterDay.addEventListener('change', filterCards);

        // Initial filter check
        filterCards();
    });
</script>

</x-admin.app>
