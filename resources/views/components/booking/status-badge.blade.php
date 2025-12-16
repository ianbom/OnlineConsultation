@props(['status'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">Status Booking</h2>
        <span class="px-4 py-2 rounded-full text-sm font-semibold
            @if($status === 'completed') bg-green-100 text-green-800
            @elseif($status === 'paid') bg-blue-100 text-blue-800
            @elseif($status === 'pending_payment') bg-yellow-100 text-yellow-800
            @elseif($status === 'cancelled') bg-red-100 text-red-800
            @elseif($status === 'rescheduled') bg-purple-100 text-purple-800
            @else bg-gray-100 text-gray-800
            @endif">
            {{ ucfirst(str_replace('_', ' ', $status)) }}
        </span>
    </div>
</div>
