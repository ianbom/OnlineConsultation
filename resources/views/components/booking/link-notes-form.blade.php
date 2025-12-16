@props(['booking'])

<div class="bg-white rounded-lg shadow-sm p-6">
    <h2 class="text-lg font-semibold text-gray-900 mb-4">Input Link Meeting & Catatan Konselor</h2>

    <form action="{{ route('counselor.booking.inputLinkandNotes', $booking->id) }}" method="POST" class="space-y-4">
        @csrf
        @method('PUT')
        {{-- Meeting Link --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Link Meeting (Zoom/Google Meet)
            </label>
            <input type="text"
                   name="meeting_link"
                   value="{{ old('meeting_link', $booking->meeting_link) }}"
                   class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                   placeholder="https://zoom.us/j/...">
        </div>

        {{-- Link Status --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Status Link
            </label>
            <select name="link_status"
                    class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500">
                <option value="active" {{ $booking->link_status == 'active' ? 'selected' : '' }}>Active</option>
                <option value="inactive" {{ $booking->link_status == 'inactive' ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        {{-- Counselor Notes --}}
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">
                Catatan Konselor
            </label>
            <textarea name="counselor_notes"
                      rows="4"
                      class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500"
                      placeholder="Tambahkan catatan tentang sesi konseling...">{{ old('counselor_notes', $booking->counselor_notes) }}</textarea>
        </div>

        {{-- Submit Button --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                Simpan
            </button>
        </div>

    </form>
</div>
