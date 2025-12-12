<x-admin.app>

   <div class="py-2">
    <form action="{{ route('admin.workday.store') }}" method="POST" x-data="workdayForm">
        @csrf

        <div class="flex xl:flex-row flex-col gap-2.5">

            {{-- MAIN FORM --}}
            <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                <div class="px-6">
                    <h2 class="text-2xl font-semibold mb-1 text-gray-900">
                        Create Counselor Workday
                    </h2>
                    <p class="text-gray-500 mb-6">
                        Set the working days and hours for the selected counselor.
                    </p>
                </div>

                <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                {{-- WORKDAY FORM --}}
                <div class="px-6">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Workday Settings
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        {{-- COUNSELOR --}}
                        <div>
                            <label class="form-label">Counselor</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="counselor_id"
                                x-model="form.counselor_id"
                                required
                            >
                                <option value="">-- Select Counselor --</option>
                                @foreach($counselors as $counselor)
                                    <option value="{{ $counselor->id }}">
                                        {{ $counselor->user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- DAY --}}
                        <div>
                            <label class="form-label">Day of Week</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="day_of_week"
                                x-model="form.day_of_week"
                                required
                            >
                                <option value="">-- Select Day --</option>
                                <option value="monday">Monday</option>
                                <option value="tuesday">Tuesday</option>
                                <option value="wednesday">Wednesday</option>
                                <option value="thursday">Thursday</option>
                                <option value="friday">Friday</option>
                                <option value="saturday">Saturday</option>
                                <option value="sunday">Sunday</option>
                            </select>
                        </div>

                        {{-- START TIME --}}
                        <div>
                            <label class="form-label">Start Time</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="start_time"
                                x-model="form.start_time"
                                required
                            >
                                <option value="">-- Select Start Time --</option>
                                @for ($i = 0; $i < 24; $i++)
                                    @php $time = sprintf('%02d:00', $i); @endphp
                                    <option value="{{ $time }}">{{ $time }}</option>
                                @endfor
                            </select>
                        </div>

                        {{-- END TIME --}}
                        <div>
                            <label class="form-label">End Time</label>
                            <select
                                class="form-select focus:border-primary focus:ring-primary"
                                name="end_time"
                                x-model="form.end_time"
                                required
                            >
                                <option value="">-- Select End Time --</option>
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
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                    </div>
                </div>
            </div>

            {{-- RIGHT SIDEBAR --}}
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel p-5">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">
                        Actions
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
                        Save Workday
                    </button>

                    {{-- CANCEL --}}
                    <a
                        href="{{ route('admin.workday.index') }}"
                        class="btn w-full border border-gray-300 text-gray-700 hover:bg-gray-100 text-center"
                    >
                        Cancel
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
