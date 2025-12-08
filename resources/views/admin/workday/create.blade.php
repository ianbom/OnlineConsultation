<x-admin.app>

    <div class="py-2">
        <form action="{{ route('admin.workday.store') }}" method="POST" x-data="workdayForm">
            @csrf

            <div class="flex xl:flex-row flex-col gap-2.5">

                {{-- MAIN FORM --}}
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                    <div class="px-6">
                        <h2 class="text-2xl font-semibold mb-1">Create Counselor Workday</h2>
                        <p class="text-gray-500 mb-6">Set the working days and hours for the selected counselor.</p>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                    {{-- WORKDAY FORM --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Workday Settings</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- SELECT COUNSELOR --}}
                            <div>
                                <label>Counselor</label>
                                <select class="form-select" name="counselor_id" x-model="form.counselor_id" required>
                                    <option value="">-- Select Counselor --</option>
                                    @foreach($counselors as $counselor)
                                        <option value="{{ $counselor->id }}">
                                            {{ $counselor->user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- DAY OF WEEK --}}
                            <div>
                                <label>Day of Week</label>
                                <select class="form-select" name="day_of_week" x-model="form.day_of_week" required>
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
                                <label>Start Time</label>
                                <select class="form-select" name="start_time" x-model="form.start_time" required>
                                    <option value="">-- Select Start Time --</option>
                                    @for ($i = 0; $i < 24; $i++)
                                        @php $time = sprintf('%02d:00', $i); @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                </select>
                            </div>

                            {{-- END TIME --}}
                            <div>
                                <label>End Time</label>
                                <select class="form-select" name="end_time" x-model="form.end_time" required>
                                    <option value="">-- Select End Time --</option>
                                    @for ($i = 1; $i <= 24; $i++)
                                        @php $time = sprintf('%02d:00', $i == 24 ? 23 : $i); @endphp
                                        <option value="{{ $time }}">{{ $time }}</option>
                                    @endfor
                                </select>
                            </div>


                            {{-- STATUS --}}
                            <div>
                                <label>Status</label>
                                <select class="form-select" name="is_active" x-model="form.is_active">
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
                        <h3 class="text-lg font-semibold mb-4">Actions</h3>

                        <button type="submit" class="btn btn-success w-full mb-3">
                            <svg width="22" height="22" fill="none" class="mr-2">
                                <path d="M12 2v18M5 9l7 7 7-7" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Save Workday
                        </button>

                        <a href="{{ route('admin.workday.index') }}" class="btn btn-secondary w-full">
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
