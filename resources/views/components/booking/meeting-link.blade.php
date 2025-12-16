@props(['booking'])

@if($booking->consultation_type === 'online' && $booking->meeting_link)
<div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-lg shadow-sm p-6 text-white">
    <h2 class="text-lg font-semibold mb-3">Link Meeting</h2>
    <div class="bg-white bg-opacity-20 rounded-lg p-3 mb-3">
        <p class="text-sm break-all">{{ $booking->meeting_link }}</p>
    </div>
    <div class="flex space-x-2">
        <a href="{{ $booking->meeting_link }}" target="_blank"
           class="flex-1 bg-white text-blue-600 text-center py-2 px-4 rounded-lg font-semibold hover:bg-blue-50 transition">
            Buka Meeting
        </a>
        <button onclick="copyToClipboard('{{ $booking->meeting_link }}')"
                class="bg-white bg-opacity-20 hover:bg-opacity-30 py-2 px-4 rounded-lg transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
            </svg>
        </button>
    </div>
    @if($booking->link_status)
    <p class="text-xs mt-3 text-blue-100">
        Status: {{ ucfirst($booking->link_status) }}
    </p>
    @endif
</div>
@endif
