<x-admin.app>

    <div class="py-2">
         <form action="{{ route('admin.counselor.store') }}" method="POST" x-data="counselorForm" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">

                {{-- MAIN FORM --}}
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                    <div class="px-6">
                        <h2 class="text-2xl font-semibold mb-1">Create New Counselor</h2>
                        <p class="text-gray-500 mb-6">Fill the form below to add a new counselor.</p>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                    {{-- COUNSELOR USER INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Account Information</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label>Name</label>
                                <input type="text" class="form-input" name="name" placeholder="Counselor Name" x-model="form.name" required>
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" class="form-input" name="email" placeholder="Counselor Email" x-model="form.email" required>
                            </div>

                            <div>
                                <label>Password</label>
                                <input type="password" class="form-input" name="password" placeholder="Password" x-model="form.password" required>
                            </div>

                            <div>
                                <label>Phone</label>
                                <input type="text" class="form-input" name="phone" placeholder="Phone number" x-model="form.phone">
                            </div>

                           <div class="md:col-span-2">
                                <label>Profile Picture</label>
                                <input type="file" class="form-input" name="profile_pic" accept="image/*" x-model="form.profile_pic">
                            </div>

                        </div>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">

                    {{-- COUNSELOR PROFESSIONAL INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Professional Details</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label>Education</label>
                                <input type="text" class="form-input" name="education" placeholder="S.Psi, M.Psi, etc." x-model="form.education" required>
                            </div>

                            <div>
                                <label>Specialization</label>
                                <input type="text" class="form-input" name="specialization" placeholder="Family, Depression, Marriage..." x-model="form.specialization" required>
                            </div>

                            <div class="md:col-span-2">
                                <label>Description</label>
                                <textarea class="form-textarea min-h-[120px]" name="description" placeholder="Short bio or description..."
                                    x-model="form.description" required></textarea>
                            </div>

                            <div>
                                <label>Price per Session (IDR)</label>
                                <input type="number" class="form-input" name="price_per_session" placeholder="Example: 150000"
                                    x-model="form.price" required>
                            </div>

                            <div>
                                <label>Status</label>
                                <select class="form-select" name="status" x-model="form.status">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <input type="text" class="form-input" hidden name="role" value="counselor" x-model="form.role" >


                {{-- RIGHT SIDEBAR --}}
                <div class="xl:w-96 w-full xl:mt-0 mt-6">

                    <div class="panel p-5">
                        <h3 class="text-lg font-semibold mb-4">Actions</h3>

                        <button type="submit" class="btn btn-success w-full mb-3">
                            <svg width="22" height="22" fill="none" class="mr-2">
                                <path d="M12 2v18M5 9l7 7 7-7" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Save Counselor
                        </button>

                        <a href="{{ route('admin.counselor.index') }}" class="btn btn-secondary w-full">
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
            Alpine.data('counselorForm', () => ({
                form: {
                    name: '',
                    email: '',
                    password: '',
                    phone: '',
                    profile_pic: '',
                    education: '',
                    specialization: '',
                    description: '',
                    price: '',
                    status: 'active'
                }
            }))
        });
    </script>

</x-admin.app>
