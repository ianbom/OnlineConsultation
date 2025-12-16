@props(['booking'])

@if($booking->reschedule_status !== 'none')
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Informasi Reschedule</h2>

    {{-- STATUS KETERSEDIAAN JADWAL --}}
    @php
        $mainAvailable = $booking->schedule?->is_available;
        $secondAvailable = $booking->secondSchedule?->is_available;

        $anyUnavailable =
            ($booking->schedule && !$booking->schedule->is_available) ||
            ($booking->secondSchedule && !$booking->secondSchedule->is_available);

        $allAvailable =
            ($booking->schedule && $booking->schedule->is_available) &&
            (!$booking->secondSchedule || $booking->secondSchedule->is_available);
    @endphp

    {{-- Jika PENDING dan ada jadwal tidak tersedia --}}
    @if($booking->reschedule_status === 'pending' && $anyUnavailable)
        <div class="mt-3 p-3 bg-red-100 border border-red-300 rounded-lg">
            <p class="text-sm font-semibold text-red-700">
                ⚠️ Jadwal yang diminta tidak tersedia. Silakan hubungi klien untuk memilih jadwal lain.
            </p>
        </div>
    @endif

    {{-- Jika PENDING dan semua jadwal tersedia --}}
    @if($booking->reschedule_status === 'pending' && $allAvailable)
        <div class="mt-3 p-3 bg-green-100 border border-green-300 rounded-lg">
            <p class="text-sm font-semibold text-green-700">
                ✅ Jadwal yang diminta tersedia. Anda bisa menyetujui permintaan ini.
            </p>
        </div>
    @endif


    <div class="space-y-3 mt-4">

        {{-- Status --}}
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Status Reschedule</span>
            <span class="px-3 py-1 rounded-full text-xs font-semibold
                @if($booking->reschedule_status === 'pending') bg-yellow-100 text-yellow-800
                @elseif($booking->reschedule_status === 'approved') bg-green-100 text-green-800
                @elseif($booking->reschedule_status === 'rejected') bg-red-100 text-red-800
                @else bg-gray-100 text-gray-800
                @endif">
                {{ ucfirst($booking->reschedule_status) }}
            </span>
        </div>

        {{-- Requested by --}}
        <div class="flex justify-between items-center pb-3 border-b">
            <span class="text-gray-600">Diminta Oleh</span>
            <span class="font-semibold text-gray-900">
                {{ ucfirst($booking->reschedule_requested_by) }}
            </span>
        </div>

        {{-- Reason --}}
        @if($booking->reschedule_reason)
        <div class="pb-3 border-b">
            <span class="text-gray-600 text-sm">Alasan Reschedule</span>
            <p class="mt-1 text-gray-800">{{ $booking->reschedule_reason }}</p>
        </div>
        @endif

    </div>

    {{-- APPROVE / REJECT BUTTONS --}}
    @if($booking->reschedule_status === 'pending')
    <div class="mt-4 flex flex-col md:flex-row gap-3">

        {{-- Approve --}}
        <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="statusReschedule" value="approved">

            <button
                type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 disabled:opacity-50 disabled:cursor-not-allowed"
                @if($anyUnavailable) disabled @endif
            >
                ✅ Setujui Reschedule
            </button>
        </form>

        {{-- Reject --}}
        <form method="POST" action="{{ route('counselor.change.reshceduleStatus', $booking->id) }}">
            @csrf
            @method('PUT')
            <input type="hidden" name="statusReschedule" value="rejected">

            <input
                type="text"
                name="rejection_reason"
                placeholder="Alasan penolakan (opsional)"
                class="border rounded-lg px-3 py-2 w-full md:w-60 text-sm"
            >

            <button
                type="submit"
                class="mt-2 md:mt-0 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700"
            >
                ❌ Tolak Reschedule
            </button>
        </form>

    </div>
    @endif
</div>
@endif
