@props(['status', 'size' => 'default'])

@php
$sizeClasses = $size === 'small' ? 'px-3 py-1 text-xs' : 'px-4 py-1.5 text-sm';
$iconSize = $size === 'small' ? 'text-[14px]' : 'text-[16px]';
@endphp

@if($status === 'pending')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-amber-100 text-amber-800 border border-amber-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">schedule</span>
    Permintaan Jadwal Ulang
</span>
@elseif($status === 'approved')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-green-100 text-green-800 border border-green-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">event_available</span>
    Jadwal Ulang Disetujui
</span>
@elseif($status === 'rejected')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-red-100 text-red-800 border border-red-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">event_busy</span>
    Jadwal Ulang Ditolak
</span>
@endif
