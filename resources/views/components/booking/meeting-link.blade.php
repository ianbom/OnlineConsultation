@props(['booking'])

<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] mb-4 flex items-center justify-between">
        <span>Meeting Link</span>
        @if(!$booking->meeting_link)
        <span class="text-xs font-normal text-[#83676c] px-2 py-1 bg-[#f8f6f6] rounded-lg border border-[#e6e0e0]">Not Set</span>
        @else
        <span class="text-xs font-normal text-[#83676c] px-2 py-1 bg-[#f8f6f6] rounded-lg border border-[#e6e0e0]">
            @if($booking->link_status)
            Status: {{ ucfirst($booking->link_status) }}
            @else
            Inactive until 15m before
            @endif
        </span>
        @endif
    </h3>
    @if($booking->meeting_link)
    <label class="block relative mb-3">
        <div class="flex w-full items-stretch rounded-xl h-11 border border-[#e6e0e0] overflow-hidden">
            <div class="bg-[#f8f6f6] px-3 flex items-center border-r border-[#e6e0e0] text-[#83676c]">
                <span class="material-symbols-outlined text-[20px]">link</span>
            </div>
            <input class="w-full border-none bg-[#f8f6f6] text-[#83676c] text-sm px-3 focus:ring-0 truncate" disabled value="{{ $booking->meeting_link }}"/>
            <button type="button" onclick="copyToClipboard('{{ $booking->meeting_link }}')" class="bg-white px-4 border-l border-[#e6e0e0] hover:bg-gray-50 text-[#7b1e2d] text-sm font-bold">Copy</button>
        </div>
    </label>
    <a href="{{ $booking->meeting_link }}" target="_blank" class="w-full h-10 rounded-xl bg-[#7b1e2d] text-white text-sm font-bold hover:bg-[#601723] transition-colors flex items-center justify-center gap-2">
        <span class="material-symbols-outlined text-[18px]">videocam</span>
        Open Meeting
    </a>
    @else
    <p class="text-sm text-[#83676c] mb-3">No meeting link has been set for this booking.</p>
    @endif
</section>
