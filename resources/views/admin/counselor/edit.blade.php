<x-admin.app>

    <div class="py-2">

        <form action="{{ route('admin.counselor.update', $counselor->id) }}"
              method="POST"
              x-data="counselorForm"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            <div class="flex xl:flex-row flex-col gap-2.5">

                {{-- MAIN FORM --}}
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                    <div class="px-6">
                        <h2 class="text-2xl font-semibold mb-1">Edit Counselor</h2>
                        <p class="text-gray-500 mb-6">Update counselor information.</p>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                    {{-- ACCOUNT INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Account Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- NAME --}}
                            <div>
                                <label>Name</label>
                                <input type="text" class="form-input"
                                       name="name"
                                       value="{{ old('name', $counselor->user->name) }}"
                                       required>
                            </div>

                            {{-- EMAIL --}}
                            <div>
                                <label>Email</label>
                                <input type="email" class="form-input"
                                       name="email"
                                       value="{{ old('email', $counselor->user->email) }}"
                                       required>
                            </div>

                            {{-- PASSWORD (optional) --}}
                            <div>
                                <label>Password (Leave empty if unchanged)</label>
                                <input type="password" class="form-input"
                                       name="password"
                                       placeholder="New Password (optional)">
                            </div>

                            {{-- PHONE --}}
                            <div>
                                <label>Phone</label>
                                <input type="text" class="form-input"
                                       name="phone"
                                       value="{{ old('phone', $counselor->user->phone) }}">
                            </div>

                            {{-- PROFILE PIC --}}
                            <div class="md:col-span-2">
                                <label>Profile Picture</label>

                                <input type="file" class="form-input"
                                       name="profile_pic"
                                       accept="image/*">

                                @if ($counselor->user->profile_pic)
                                    <div class="mt-2">
                                        <p class="text-sm text-gray-500">Current Image:</p>
                                        <img src="{{ asset('storage/' . $counselor->user->profile_pic) }}"
                                             class="w-20 h-20 object-cover rounded-md border">
                                    </div>
                                @endif
                            </div>

                        </div>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">

                    {{-- PROFESSIONAL INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Professional Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            {{-- EDUCATION --}}
                            <div>
                                <label>Education</label>
                                <input type="text" class="form-input"
                                       name="education"
                                       value="{{ old('education', $counselor->education) }}"
                                       required>
                            </div>

                            {{-- SPECIALIZATION --}}
                            <div>
                                <label>Specialization</label>
                                <input type="text" class="form-input"
                                       name="specialization"
                                       value="{{ old('specialization', $counselor->specialization) }}"
                                       required>
                            </div>

                            {{-- DESCRIPTION --}}
                            <div class="md:col-span-2">
                                <label>Description</label>
                                <textarea class="form-textarea min-h-[120px]"
                                          name="description"
                                          required>{{ old('description', $counselor->description) }}</textarea>
                            </div>

                            {{-- PRICE --}}
                            <div>
                                <label>Price per Session (IDR)</label>
                                <input type="number" class="form-input"
                                       name="price_per_session"
                                       value="{{ old('price_per_session', $counselor->price_per_session) }}"
                                       required>
                            </div>

                            {{-- STATUS --}}
                            <div>
                                <label>Status</label>
                                <select class="form-select" name="status">
                                    <option value="active" {{ $counselor->status === 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="inactive" {{ $counselor->status === 'inactive' ? 'selected' : '' }}>Inactive</option>
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
                                <path d="M12 2v18M5 9l7 7 7-7"
                                      stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Update Counselor
                        </button>

                        <a href="{{ route('admin.counselor.index') }}" class="btn btn-secondary w-full">
                            Cancel
                        </a>
                    </div>
                </div>

            </div>

        </form>
    </div>

</x-admin.app>
