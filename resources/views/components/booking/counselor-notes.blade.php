@props(['booking'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-3">Catatan Konselor</h2>
    @if($booking->counselor_notes)
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded">
            <p class="text-gray-700">{{ $booking->counselor_notes }}</p>
        </div>
    @else
        <p class="text-gray-500 italic">Belum ada catatan dari konselor</p>
        @if($booking->status === 'completed')
        <button class="mt-3 px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            Tambah Catatan
        </button>
        @endif
    @endif
</div>
