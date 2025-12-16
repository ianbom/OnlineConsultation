@props(['booking'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Jadwal Konsultasi</h2>

    <!-- Current Schedule -->
    <div class="border-l-4 border-primary pl-4 py-2 mb-4">
        <p class="text-sm text-gray-500 mb-1">Jadwal Aktif</p>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-semibold text-gray-900">
                {{ \Carbon\Carbon::parse($booking->schedule->date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        <div class="flex items-center space-x-2 mt-2">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-700">
                {{ \Carbon\Carbon::parse($booking->schedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($booking->schedule->end_time)->format('H:i') }}
            </span>
        </div>
    </div>

    @if($booking->second_schedule_id)
    <!-- Second Schedule -->
    <div class="border-l-4 border-green-500 pl-4 py-2 mb-4">
        <p class="text-sm text-gray-500 mb-1">Jadwal Kedua</p>
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-semibold text-gray-900">
                {{ \Carbon\Carbon::parse($booking->secondSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>
        <div class="flex items-center space-x-2 mt-2">
            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-700">
                {{ \Carbon\Carbon::parse($booking->secondSchedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($booking->secondSchedule->end_time)->format('H:i') }}
            </span>
        </div>
    </div>
    @endif

    {{-- Previous MAIN Schedule --}}
    @if($booking->previous_schedule_id && $booking->previousSchedule)
    <div class="border-l-4 border-gray-400 pl-4 py-2 bg-gray-50 mb-3">
        <p class="text-sm text-gray-500 mb-1">Jadwal Sebelumnya (Dirubah)</p>

        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-medium text-gray-700 line-through">
                {{ \Carbon\Carbon::parse($booking->previousSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>

        <div class="flex items-center space-x-2 mt-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-600 line-through">
                {{ \Carbon\Carbon::parse($booking->previousSchedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($booking->previousSchedule->end_time)->format('H:i') }}
            </span>
        </div>
    </div>
    @endif

    {{-- Previous SECOND Schedule (Jika Ada) --}}
    @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
    <div class="border-l-4 border-gray-400 pl-4 py-2 bg-gray-50">
        <p class="text-sm text-gray-500 mb-1">Jadwal Kedua Sebelumnya (Dirubah)</p>

        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span class="font-medium text-gray-700 line-through">
                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->isoFormat('dddd, D MMMM YYYY') }}
            </span>
        </div>

        <div class="flex items-center space-x-2 mt-2">
            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="text-gray-600 line-through">
                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->start_time)->format('H:i') }} -
                {{ \Carbon\Carbon::parse($booking->previousSecondSchedule->end_time)->format('H:i') }}
            </span>
        </div>
    </div>
    @endif

</div>
