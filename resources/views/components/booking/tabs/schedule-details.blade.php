@props(['booking'])

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    {{-- Jadwal Utama --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">event</span>
            Jadwal Utama
        </h4>
        @if($booking->schedule)
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">ID Jadwal</span>
                <span class="text-sm font-medium text-[#171213]">#{{ $booking->schedule->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Tanggal</span>
                <span class="text-sm font-medium text-[#171213]">{{ \Carbon\Carbon::parse($booking->schedule->date)->locale('id')->translatedFormat('l, d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Waktu</span>
                <span class="text-sm font-medium text-[#171213]">{{ $booking->schedule->start_time }} - {{ $booking->schedule->end_time }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Tersedia</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($booking->schedule->is_available) bg-green-100 text-green-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ $booking->schedule->is_available ? 'Ya' : 'Tidak' }}
                </span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">ID Konselor</span>
                <span class="text-sm font-medium text-[#171213]">#{{ $booking->schedule->counselor_id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">ID Hari Kerja</span>
                <span class="text-sm font-medium text-[#171213]">#{{ $booking->schedule->workday_id }}</span>
            </div>
        </div>
        @else
        <p class="text-sm text-[#83676c]">Tidak ada data jadwal</p>
        @endif
    </div>

    {{-- Jadwal Kedua (jika ada) --}}
    <div class="bg-[#f8f6f6] rounded-xl p-4 border border-[#e6e0e0]">
        <h4 class="text-sm font-bold text-[#171213] mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-[#7b1e2d] text-[18px]">event_repeat</span>
            Jadwal Kedua (Opsional)
        </h4>
        @if($booking->second_schedule_id && $booking->secondSchedule)
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">ID Jadwal</span>
                <span class="text-sm font-medium text-[#171213]">#{{ $booking->secondSchedule->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Tanggal</span>
                <span class="text-sm font-medium text-[#171213]">{{ \Carbon\Carbon::parse($booking->secondSchedule->date)->locale('id')->translatedFormat('l, d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Waktu</span>
                <span class="text-sm font-medium text-[#171213]">{{ $booking->secondSchedule->start_time }} - {{ $booking->secondSchedule->end_time }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-[#83676c]">Tersedia</span>
                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                    @if($booking->secondSchedule->is_available) bg-green-100 text-green-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ $booking->secondSchedule->is_available ? 'Ya' : 'Tidak' }}
                </span>
            </div>
        </div>
        @else
        <p class="text-sm text-[#83676c]">Tidak ada jadwal kedua</p>
        @endif
    </div>

    {{-- Jadwal Sebelumnya (jika ada) --}}
    @if($booking->previous_schedule_id && $booking->previousSchedule)
    <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
        <h4 class="text-sm font-bold text-amber-700 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-600 text-[18px]">history</span>
            Jadwal Sebelumnya (Sebelum Dijadwal Ulang)
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">ID Jadwal</span>
                <span class="text-sm font-medium text-amber-800">#{{ $booking->previousSchedule->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">Tanggal</span>
                <span class="text-sm font-medium text-amber-800">{{ \Carbon\Carbon::parse($booking->previousSchedule->date)->locale('id')->translatedFormat('l, d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">Waktu</span>
                <span class="text-sm font-medium text-amber-800">{{ $booking->previousSchedule->start_time }} - {{ $booking->previousSchedule->end_time }}</span>
            </div>
        </div>
    </div>
    @endif

    {{-- Jadwal Kedua Sebelumnya (jika ada) --}}
    @if($booking->previous_second_schedule_id && $booking->previousSecondSchedule)
    <div class="bg-amber-50 rounded-xl p-4 border border-amber-200">
        <h4 class="text-sm font-bold text-amber-700 mb-4 flex items-center gap-2">
            <span class="material-symbols-outlined text-amber-600 text-[18px]">history</span>
            Jadwal Kedua Sebelumnya (Sebelum Dijadwal Ulang)
        </h4>
        <div class="space-y-3">
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">ID Jadwal</span>
                <span class="text-sm font-medium text-amber-800">#{{ $booking->previousSecondSchedule->id }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">Tanggal</span>
                <span class="text-sm font-medium text-amber-800">{{ \Carbon\Carbon::parse($booking->previousSecondSchedule->date)->locale('id')->translatedFormat('l, d M Y') }}</span>
            </div>
            <div class="flex justify-between">
                <span class="text-sm text-amber-600">Waktu</span>
                <span class="text-sm font-medium text-amber-800">{{ $booking->previousSecondSchedule->start_time }} - {{ $booking->previousSecondSchedule->end_time }}</span>
            </div>
        </div>
    </div>
    @endif
</div>
