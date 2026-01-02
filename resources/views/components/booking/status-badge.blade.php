@props(['status', 'size' => 'default'])

@php
$sizeClasses = $size === 'small' ? 'px-3 py-1 text-xs' : 'px-4 py-1.5 text-sm';
$iconSize = $size === 'small' ? 'text-[14px]' : 'text-[16px]';
@endphp

@if($status === 'paid')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-green-100 text-green-800 border border-green-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">check_circle</span>
    Lunas
</span>
@elseif($status === 'pending_payment')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-yellow-100 text-yellow-800 border border-yellow-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">pending</span>
    Menunggu Pembayaran
</span>
@elseif($status === 'completed')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-blue-100 text-blue-800 border border-blue-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">task_alt</span>
    Selesai
</span>
@elseif($status === 'cancelled')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-red-100 text-red-800 border border-red-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">cancel</span>
    Dibatalkan
</span>
@elseif($status === 'rescheduled')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-purple-100 text-purple-800 border border-purple-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">event_repeat</span>
    Dijadwalkan Ulang
</span>
@else
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-gray-100 text-gray-800 border border-gray-200">
    {{ ucfirst(str_replace('_', ' ', $status)) }}
</span>
@endif
