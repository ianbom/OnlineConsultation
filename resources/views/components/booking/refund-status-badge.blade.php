@props(['status', 'size' => 'default'])

@php
$sizeClasses = $size === 'small' ? 'px-3 py-1 text-xs' : 'px-4 py-1.5 text-sm';
$iconSize = $size === 'small' ? 'text-[14px]' : 'text-[16px]';
@endphp

@if($status !== 'none')
@if($status === 'requested')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-orange-100 text-orange-800 border border-orange-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">currency_exchange</span>
    Refund Requested
</span>
@elseif($status === 'processed')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-blue-100 text-blue-800 border border-blue-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">currency_exchange</span>
    Refund Processed
</span>
@elseif($status === 'done')
<span class="inline-flex items-center gap-1.5 {{ $sizeClasses }} rounded-full font-bold bg-green-100 text-green-800 border border-green-200">
    <span class="material-symbols-outlined {{ $iconSize }} icon-filled">currency_exchange</span>
    Refund Done
</span>
@endif
@endif
