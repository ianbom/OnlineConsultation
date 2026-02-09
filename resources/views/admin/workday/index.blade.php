<x-admin.app>

<div class="container mx-auto px-4 py-6">
    {{-- HEADER --}}
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Jadwal Kerja Konselor</h1>
            <p class="text-gray-600 text-sm">Kelola dan lihat jadwal kerja konselor</p>
        </div>

        {{-- CREATE BUTTON --}}
        <a href="{{ route('admin.workday.create') }}"
           class="inline-flex items-center px-4 py-2 bg-primary hover:bg-primary/80 text-white text-sm font-semibold rounded-lg shadow-sm transition">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Jadwal
        </a>
    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-4 border border-gray-200">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Filter Konselor
                </label>
                <input
                    type="text"
                    id="filterCounselor"
                    placeholder="Cari nama konselor..."
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-primary focus:border-transparent"
                />
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Filter Hari
                </label>
                <select
                    id="filterDay"
                    class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg
                           focus:ring-2 focus:ring-primary focus:border-transparent"
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

    {{-- TABLE --}}
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="border-b">
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                            <th class="px-3 py-3 text-center text-xs font-semibold text-gray-800 uppercase border-r">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr class="align-top">
                        @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                        <td class="p-2 border-r bg-gray-50/50 min-w-[140px]" data-day="{{ $day }}">
                            <div class="space-y-2">

                                @foreach($counselorsWorkDays as $workDay)
                                    @if($workDay->day_of_week === $day)

                                    <div class="workday-card bg-white rounded-lg border hover:shadow-sm transition"
                                         data-counselor="{{ strtolower($workDay->counselor->user->name) }}"
                                         data-day="{{ $workDay->day_of_week }}">

                                        {{-- HEADER --}}
                                        <div class="p-3 border-b flex justify-between">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-full bg-gradient-to-r from-primary to-primary/80 flex items-center justify-center">
                                                    <span class="text-white text-xs font-bold">
                                                        {{ strtoupper(substr($workDay->counselor->user->name,0,1)) }}
                                                    </span>
                                                </div>
                                                <span class="text-sm font-semibold text-gray-900">
                                                    {{ \Illuminate\Support\Str::limit($workDay->counselor->user->name,12) }}
                                                </span>
                                            </div>

                                            {{-- STATUS --}}
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

                                        {{-- BODY --}}
                                        <div class="p-3 space-y-2">
                                            <div class="text-xs text-gray-600 flex items-center gap-1">
                                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                </svg>
                                                {{ date('H:i', strtotime($workDay->start_time)) }}
                                                -
                                                {{ date('H:i', strtotime($workDay->end_time)) }}
                                            </div>

                                            <span class="block text-xs font-semibold px-2 py-1 rounded bg-primary/10 text-primary">
                                                Offline : Rp {{ number_format($workDay->counselor->price_per_session,0,',','.') }}
                                            </span>
                                            <span class="block text-xs font-semibold px-2 py-1 rounded bg-green-100 text-green-700 mt-1">
                                                Online : Rp {{ number_format($workDay->counselor->online_price_per_session,0,',','.') }}
                                            </span>

                                            {{-- SCHEDULES SECTION --}}
                                            @php
                                                $futureSchedules = $workDay->schedules->filter(function($schedule) {
                                                    return \Carbon\Carbon::parse($schedule->date)->isFuture() || 
                                                           \Carbon\Carbon::parse($schedule->date)->isToday();
                                                })->take(5);
                                            @endphp

                                            @if($futureSchedules->count() > 0)
                                                <div class="mt-3 pt-3 border-t border-gray-200">
                                                    <details class="group">
                                                        <summary class="cursor-pointer text-xs font-semibold text-gray-700 flex items-center justify-between hover:text-primary">
                                                            <span class="flex items-center gap-1">
                                                                <svg class="w-3.5 h-3.5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                                </svg>
                                                                Jadwal ({{ $futureSchedules->count() }})
                                                            </span>
                                                            <svg class="w-3 h-3 transition-transform group-open:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                                            </svg>
                                                        </summary>
                                                        
                                                        <div class="mt-2 space-y-1.5 max-h-48 overflow-y-auto">
                                                            @foreach($futureSchedules as $schedule)
                                                                <div class="text-[10px] p-2 rounded border {{ $schedule->is_available ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                                                                    <div class="flex items-center justify-between">
                                                                        <span class="font-medium text-gray-700">
                                                                            {{ \Carbon\Carbon::parse($schedule->date)->format('D, d M Y') }}
                                                                        </span>
                                                                        @if($schedule->is_available)
                                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full bg-green-100 text-green-700">
                                                                                <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                                                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                                                                                </svg>
                                                                                Tersedia
                                                                            </span>
                                                                        @else
                                                                            <span class="inline-flex items-center px-1.5 py-0.5 rounded-full bg-gray-100 text-gray-600">
                                                                                <svg class="w-2.5 h-2.5 mr-0.5" fill="currentColor" viewBox="0 0 20 20">
                                                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                                                                                </svg>
                                                                                Tidak Tersedia
                                                                            </span>
                                                                        @endif
                                                                    </div>
                                                                    <div class="text-gray-600 mt-1 flex items-center gap-1">
                                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                                                        </svg>
                                                                        {{ \Carbon\Carbon::parse($schedule->start_time)->format('H:i') }} 
                                                                        - 
                                                                        {{ \Carbon\Carbon::parse($schedule->end_time)->format('H:i') }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </details>
                                                </div>
                                            @endif

                                            <div class="flex gap-1">
                                                <a href="{{ route('admin.workday.edit',$workDay->id) }}"
                                                   class="flex-1 text-xs py-1.5 text-center rounded border hover:bg-gray-100">
                                                    Edit
                                                </a>
                                                <form method="POST" action="{{ route('admin.workday.destroy',$workDay->id) }}" class="flex-1">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button onclick="return confirm('Hapus jadwal ini?')"
                                                            class="w-full text-xs py-1.5 rounded border hover:bg-red-100">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </div>

                                    </div>
                                    @endif
                                @endforeach

                                @if(!$counselorsWorkDays->where('day_of_week',$day)->count())
                                    <div class="text-center py-4 text-xs text-gray-400">
                                        Tidak ada jadwal
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
