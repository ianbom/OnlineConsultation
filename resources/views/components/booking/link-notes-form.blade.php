@props(['booking', 'action' => null])

@if($booking->status === 'paid')
<section class="bg-white rounded-2xl border border-[#e6e0e0] shadow-sm p-6">
    <h3 class="text-lg font-bold text-[#171213] flex items-center gap-2 mb-4">
        <span class="material-symbols-outlined text-[#7b1e2d]">edit</span>
        Update Booking
    </h3>
    <form action="{{ $action ?? route('counselor.booking.inputLinkandNotes', $booking->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="space-y-4">
            @if($booking->consultation_type === 'online')
            <div>
                <label class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1 block">Meeting Link</label>
                <input type="url" name="meeting_link" value="{{ old('meeting_link', $booking->meeting_link) }}" class="w-full rounded-xl border border-[#e6e0e0] bg-[#f8f6f6] text-sm px-4 py-2.5 focus:ring-[#7b1e2d] focus:border-[#7b1e2d]" placeholder="https://zoom.us/j/...">
            </div>
            <div>
                <label class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1 block">Link Status</label>
                <select name="link_status" class="w-full rounded-xl border border-[#e6e0e0] bg-[#f8f6f6] text-sm px-4 py-2.5 focus:ring-[#7b1e2d] focus:border-[#7b1e2d]">
                    <option value="pending" {{ $booking->link_status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="sent" {{ $booking->link_status == 'sent' ? 'selected' : '' }}>Sent</option>
                </select>
            </div>
            @endif
            <div>
                <label class="text-xs font-semibold text-[#83676c] uppercase tracking-wider mb-1 block">Counselor Notes</label>
                <textarea name="counselor_notes" rows="3" class="w-full rounded-xl border border-[#e6e0e0] bg-[#f8f6f6] text-sm px-4 py-2.5 focus:ring-[#7b1e2d] focus:border-[#7b1e2d]" placeholder="Add notes...">{{ old('counselor_notes', $booking->counselor_notes) }}</textarea>
            </div>
            <button type="submit" class="w-full h-10 rounded-xl bg-[#7b1e2d] text-white text-sm font-bold hover:bg-[#601723] transition-colors flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[18px]">save</span>
                Save Changes
            </button>
        </div>
    </form>
</section>
@endif
