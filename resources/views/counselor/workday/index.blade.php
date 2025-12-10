<x-counselor.app>

<div class="container mx-auto px-4 py-6">
    <div class="mb-6 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 mb-1">Jadwal Kerja Saya</h1>
        </div>
    </div>


    <!-- Weekly Schedule Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px]">
                <thead>
                    <tr class="bg-white border-b border-gray-200">
                        @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'] as $day)
                        <th class="px-3 py-3 bg-primary text-center text-xs font-semibold text-white uppercase tracking-wider border-r border-gray-200">
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
                                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">
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
                                                <span class="inline-block w-full px-2 py-1 bg-primary text-white text-xs font-semibold rounded">
                                                   Harga : Rp {{ number_format($workDay->counselor->price_per_session, 0, ',', '.') }}
                                                </span>
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


</x-counselor.app>
