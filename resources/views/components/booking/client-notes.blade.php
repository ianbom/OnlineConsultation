@props(['notes'])

@if($notes)
<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-3">Catatan Klien</h2>
    <div class="bg-secondary border-l-4 border-primary p-4 rounded">
        <p class="text-gray-700">{{ $notes }}</p>
    </div>
</div>
@endif
