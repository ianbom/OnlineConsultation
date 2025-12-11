<x-counselor.app>

<div class="container mx-auto px-4 py-6">

    <h1 class="text-2xl font-bold text-gray-800 mb-4">Jadwal Kerja Saya</h1>

    <!-- ====================== -->
    <!-- DESKTOP MODE (TABLE)  -->
    <!-- ====================== -->
    <div class="hidden md:block bg-white rounded-xl shadow-sm overflow-hidden border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px]">
                <thead>
                    <tr class="bg-white border-b border-gray-200">
                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu'] as $day)
                            <th class="px-3 py-3 bg-primary text-center text-xs font-semibold text-white uppercase tracking-wider border-r border-gray-200">
                                {{ $day }}
                            </th>
                        @endforeach
                    </tr>
                </thead>

                <tbody>
                    <tr class="align-top">
                        @foreach(['monday','tuesday','wednesday','thursday','friday','saturday','sunday'] as $day)
                            <td class="p-2 border-r border-gray-100 bg-gray-50/50 min-w-[140px]">
                                <div class="space-y-2">
                                    @foreach($counselorsWorkDays->where('day_of_week', $day) as $workDay)
                                        <div class="workday-card bg-white rounded-lg shadow-xs border border-gray-200 hover:shadow-sm transition duration-150 p-3">
                                            <div class="flex items-center justify-between">
                                                <div class="flex items-center space-x-2">
                                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                                                        <span class="text-white text-xs font-bold">
                                                            {{ strtoupper(substr($workDay->counselor->user->name, 0, 1)) }}
                                                        </span>
                                                    </div>
                                                    <div>
                                                        <h3 class="text-sm font-semibold">{{ $workDay->counselor->user->name }}</h3>
                                                    </div>
                                                </div>

                                                @if($workDay->is_active)
                                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full">Aktif</span>
                                                @else
                                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] rounded-full">Tidak aktif</span>
                                                @endif
                                            </div>

                                            <div class="text-xs text-gray-600 mt-2">
                                                <strong>{{ date('H:i', strtotime($workDay->start_time)) }}</strong>
                                                -
                                                <strong>{{ date('H:i', strtotime($workDay->end_time)) }}</strong>
                                            </div>

                                            <div class="mt-2 text-xs font-semibold bg-primary text-white px-2 py-1 rounded">
                                                Rp {{ number_format($workDay->counselor->price_per_session, 0, ',', '.') }}
                                            </div>
                                        </div>

                                    @endforeach

                                    @if($counselorsWorkDays->where('day_of_week',$day)->count() === 0)
                                        <div class="text-center py-3">
                                            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor">
                                                <path d="M9 5H7a2 2..." stroke-width="1.5"/>
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

    <!-- ====================== -->
    <!-- MOBILE MODE (LIST)    -->
    <!-- ====================== -->
    <div class="md:hidden space-y-4 mt-4">

        @php
            $days = [
                'monday' => 'Senin',
                'tuesday' => 'Selasa',
                'wednesday' => 'Rabu',
                'thursday' => 'Kamis',
                'friday' => 'Jumat',
                'saturday' => 'Sabtu',
                'sunday' => 'Minggu',
            ];
        @endphp

        @foreach($days as $key => $label)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <!-- Header Hari -->
                <div class="bg-primary text-white px-4 py-2 text-sm font-semibold">
                    {{ $label }}
                </div>

                <div class="p-3 space-y-2">
                    @foreach($counselorsWorkDays->where('day_of_week', $key) as $workDay)
                       <div class="workday-card bg-white rounded-lg shadow-xs border border-gray-200 hover:shadow-sm transition duration-150 p-3">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <div class="w-8 h-8 rounded-full bg-primary flex items-center justify-center">
                                        <span class="text-white text-xs font-bold">
                                            {{ strtoupper(substr($workDay->counselor->user->name, 0, 1)) }}
                                        </span>
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-semibold">{{ $workDay->counselor->user->name }}</h3>
                                    </div>
                                </div>
                            
                                @if($workDay->is_active)
                                    <span class="px-2 py-0.5 bg-green-100 text-green-700 text-[10px] rounded-full">Aktif</span>
                                @else
                                    <span class="px-2 py-0.5 bg-red-100 text-red-700 text-[10px] rounded-full">Tidak aktif</span>
                                @endif
                            </div>
                        
                            <div class="text-xs text-gray-600 mt-2">
                                <strong>{{ date('H:i', strtotime($workDay->start_time)) }}</strong>
                                -
                                <strong>{{ date('H:i', strtotime($workDay->end_time)) }}</strong>
                            </div>
                        
                            <div class="mt-2 text-xs font-semibold bg-primary text-white px-2 py-1 rounded">
                                Rp {{ number_format($workDay->counselor->price_per_session, 0, ',', '.') }}
                            </div>
                        </div>

                    @endforeach

                    @if($counselorsWorkDays->where('day_of_week',$key)->count() === 0)
                        <p class="text-xs text-gray-400 text-center py-3">Tidak ada jadwal</p>
                    @endif
                </div>

            </div>
        @endforeach

    </div>

</div>



</x-counselor.app>
