<x-admin.app>

<div class="py-2">
    <form action="{{ route('admin.workday.update', $workday->id) }}" method="POST" x-data="workdayForm">
        @csrf
        @method('PUT')

        <div class="flex xl:flex-row flex-col gap-2.5">

            {{-- MAIN FORM --}}
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                <div class="px-6">
                    <h2 class="text-2xl font-semibold mb-1">Edit Jadwal Kerja Konselor</h2>
                    <p class="text-gray-500 mb-6">Perbarui hari kerja dan jam kerja untuk konselor yang dipilih.</p>
                </div>

                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                {{-- FORM --}}
                <div class="px-6">
                    <h3 class="text-lg font-semibold mb-4">Pengaturan Jadwal</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- CONSSELOR --}}
                        <div>
                            <label class="font-medium">Konselor</label>
                            <select class="form-select"
                                    name="counselor_id"
                                    x-model="form.counselor_id"
                                    required>
                                <option value="">-- Pilih Konselor --</option>

                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}"
                                        {{ $counselor->id == $workday->counselor_id ? 'selected' : '' }}>
                                        {{ $counselor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DAY OF WEEK --}}
                        <div>
                            <label class="font-medium">Hari Kerja</label>
                            <select class="form-select"
                                    name="day_of_week"
                                    x-model="form.day_of_week"
                                    required>
                                <option value="">-- Pilih Hari --</option>
                                @php
                                    $days = [
                                        'monday' => 'Senin', 'tuesday' => 'Selasa', 'wednesday' => 'Rabu',
                                        'thursday' => 'Kamis', 'friday' => 'Jumat', 'saturday' => 'Sabtu', 'sunday' => 'Minggu'
                                    ];
                                @endphp

                                @foreach($days as $key => $day)
                                    <option value="{{ $key }}"
                                        {{ $workday->day_of_week == $key ? 'selected' : '' }}>
                                        {{ $day }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- START TIME --}}
                        <div>
                            <label class="font-medium">Jam Mulai</label>
                            <select class="form-select"
                                    name="start_time"
                                    x-model="form.start_time"
                                    required>
                                <option value="">-- Pilih Jam Mulai --</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $time = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $time }}"
                                        {{ $workday->start_time == $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- END TIME --}}
                        <div>
                            <label class="font-medium">Jam Selesai</label>
                            <select class="form-select"
                                    name="end_time"
                                    x-model="form.end_time"
                                    required>
                                <option value="">-- Pilih Jam Selesai --</option>
                                @for ($i = 1; $i <= 24; $i++)
                                    @php $time = sprintf('%02d:00', $i == 24 ? 23 : $i); @endphp
                                    <option value="{{ $time }}"
                                        {{ $workday->end_time == $time ? 'selected' : '' }}>
                                        {{ $time }}
                                    </option>
                                @endfor
                            </select>
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label class="font-medium">Status</label>
                            <select class="form-select"
                                    name="is_active"
                                    x-model="form.is_active">
                                <option value="1" {{ $workday->is_active ? 'selected' : '' }}>Aktif</option>
                                <option value="0" {{ !$workday->is_active ? 'selected' : '' }}>Tidak Aktif</option>
                            </select>
                        </div>

                    </div>
                </div>

            </div>

            {{-- SIDEBAR BUTTONS --}}
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel p-5">
                    <h3 class="text-lg font-semibold mb-4">Aksi</h3>

                    <button type="submit" class="btn btn-success w-full mb-3">
                        <svg width="22" height="22" fill="none" class="mr-2">
                            <path d="M12 2v18M5 9l7 7 7-7" stroke="currentColor" stroke-width="1.5"/>
                        </svg>
                        Simpan Perubahan
                    </button>

                    <a href="{{ route('admin.workday.index') }}"
                       class="btn btn-secondary w-full">
                        Batal
                    </a>
                </div>
            </div>

        </div>

    </form>
</div>

{{-- ALPINE JS DEFAULT VALUES --}}
<script>
document.addEventListener("alpine:init", () => {
    Alpine.data('workdayForm', () => ({
        form: {
            counselor_id: '{{ $workday->counselor_id }}',
            day_of_week: '{{ $workday->day_of_week }}',
            start_time: '{{ $workday->start_time }}',
            end_time: '{{ $workday->end_time }}',
            is_active: '{{ $workday->is_active }}',
        }
    }))
});
</script>


</x-admin.app>
