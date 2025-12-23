<x-admin.app>

   <div class="py-2">
    <form action="{{ route('admin.workday.store') }}" method="POST" x-data="workdayForm">
        @csrf

        <div class="flex xl:flex-row flex-col gap-2.5">

            {{-- MAIN FORM --}}
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                <div class="px-6">
                    <h2 class="text-2xl font-semibold mb-1 text-gray-900">
                        Buat Jadwal Kerja Konselor
                    </h2>
                    <p class="text-gray-500 mb-6">
                        Atur hari dan jam kerja untuk konselor yang dipilih.
                    </p>
                </div>

                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                {{-- WORKDAY FORM --}}
                <div class="px-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Pengaturan Hari Kerja
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- COUNSELOR --}}
                        <div>
                            <label class="form-label">Konselor</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="counselor_id"
                                x-model="form.counselor_id"
                                required
                            >
                                <option value="">-- Pilih Konselor --</option>
                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}">
                                        {{ $counselor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DAY --}}
                        <div>
                            <label class="form-label">Hari</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="day_of_week"
                                x-model="form.day_of_week"
                                required
                            >
                                <option value="">-- Pilih Hari --</option>
                                <option value="monday">Senin</option>
                                <option value="tuesday">Selasa</option>
                                <option value="wednesday">Rabu</option>
                                <option value="thursday">Kamis</option>
                                <option value="friday">Jumat</option>
                                <option value="saturday">Sabtu</option>
                                <option value="sunday">Minggu</option>
                            </select>
                        </div>

                        {{-- START TIME --}}
                        <div>
                            <label class="form-label">Jam Mulai</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="start_time"
                                x-model="form.start_time"
                                required
                            >
                                <option value="">-- Pilih Jam Mulai --</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $time = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- END TIME --}}
                        <div>
                            <label class="form-label">Jam Selesai</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="end_time"
                                x-model="form.end_time"
                                required
                            >
                                <option value="">-- Pilih Jam Selesai --</option>
                                @for ($i = 1; $i <= 24; $i++)
                                    @php $time = sprintf('%02d:00', $i == 24 ? 23 : $i); @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- STATUS --}}
                        <div>
                            <label class="form-label">Status</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="is_active"
                                x-model="form.is_active"
                            >
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel p-5">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Aksi
                    </h3>

                    {{-- SAVE --}}
                    <button
                        type="submit"
                        class="btn bg-primary hover:bg-primary/80 text-white w-full mb-3 flex items-center justify-center gap-2"
                    >
                        <svg width="20" height="20" fill="none">
                            <path d="M12 2v18M5 9l7 7 7-7"
                                  stroke="currentColor"
                                  stroke-width="1.5"
                                  stroke-linecap="round"
                                  stroke-linejoin="round"/>
                        </svg>
                        Simpan Hari Kerja
                    </button>

                    {{-- CANCEL --}}
                    <a
                        href="{{ route('admin.workday.index') }}"
                        class="btn w-full border border-gray-300 text-gray-700 hover:bg-gray-100 text-center"
                    >
                        Batal
                    </a>
                </div>
            </div>

        </div>
    </form>
</div>


    {{-- ALPINE JS --}}
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('workdayForm', () => ({
                form: {
                    counselor_id: '',
                    day_of_week: '',
                    start_time: '',
                    end_time: '',
                    is_active: 1,
                }
            }))
        });
    </script>

</x-admin.app>
