@props(['booking'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Detail Konsultasi</h2>
    <div class="space-y-3">
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Tipe Konsultasi</span>
            <span class="flex items-center space-x-2">
                @if($booking->consultation_type === 'online')
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="font-semibold text-gray-900">Online</span>
                @else
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="font-semibold text-gray-900">Offline</span>
                @endif
            </span>
        </div>

        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Durasi</span>
            <span class="font-semibold text-gray-900">{{ $booking->duration_hours }} Jam</span>
        </div>

        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Harga</span>
            <span class="font-semibold text-gray-900">Rp {{ number_format($booking->price, 0, ',', '.') }}</span>
        </div>

        <div class="flex justify-between items-center">
            <span class="text-gray-600">Dibuat</span>
            <span class="text-sm text-gray-700">
                {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, H:i') }}
            </span>
        </div>
    </div>
</div>
