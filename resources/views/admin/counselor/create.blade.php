<x-admin.app>

    <div class="py-2">
         <form action="{{ route('admin.counselor.store') }}" method="POST" x-data="counselorForm" enctype="multipart/form-data">
            @csrf
            <div class="flex xl:flex-row flex-col gap-2.5">

                {{-- MAIN FORM --}}
                <div class="panel px-0 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">

                    <div class="px-6">
                        <h2 class="text-2xl font-semibold mb-1">Tambah Konselor Baru</h2>
                        <p class="text-gray-500 mb-6">Isi formulir di bawah untuk menambahkan konselor baru.</p>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] mb-6">

                    {{-- COUNSELOR USER INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Informasi Akun</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label>Nama</label>
                                <input type="text" class="form-input" name="name" placeholder="Nama Konselor" x-model="form.name" required>
                            </div>

                            <div>
                                <label>Email</label>
                                <input type="email" class="form-input" name="email" placeholder="Email Konselor" x-model="form.email" required>
                            </div>

                            <div>
                                <label>Kata Sandi</label>
                                <input type="password" class="form-input" name="password" placeholder="Kata sandi" x-model="form.password" required>
                            </div>

                            <div>
                                <label>No. Telepon</label>
                                <input type="text" class="form-input" name="phone" placeholder="Nomor telepon" x-model="form.phone">
                            </div>

                           <div class="md:col-span-2">
                                <label>Foto Profil</label>
                                <input type="file" class="form-input" name="profile_pic" accept="image/*" x-model="form.profile_pic">
                            </div>

                        </div>
                    </div>

                    <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">

                    {{-- COUNSELOR PROFESSIONAL INFO --}}
                    <div class="px-6">
                        <h3 class="text-lg font-semibold mb-4">Detail Profesional</h3>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                            <div>
                                <label>Pendidikan</label>
                                <input type="text" class="form-input" name="education" placeholder="S.Psi, M.Psi, etc." x-model="form.education" required>
                            </div>

                            <div>
                                <label>Spesialisasi</label>
                                <input type="text" class="form-input" name="specialization" placeholder="Keluarga, Depresi, Pernikahan..." x-model="form.specialization" required>
                            </div>

                            <div class="md:col-span-2">
                                <label>Deskripsi</label>
                                <textarea class="form-textarea min-h-[120px]" name="description" placeholder="Bio singkat atau deskripsi..."
                                    x-model="form.description" required></textarea>
                            </div>

                            <div>
                                <label>Harga per Sesi (IDR)</label>
                                <input type="number" class="form-input" name="price_per_session" placeholder="Contoh: 150000"
                                    x-model="form.price" required>
                            </div>

                            <div>
                                <label>Harga Online per Sesi (IDR)</label>
                                <input type="number" class="form-input" name="online_price_per_session" placeholder="Contoh: 120000"
                                    x-model="form.online_price" required>
                            </div>

                            <div>
                                <label>Status</label>
                                <select class="form-select" name="status" x-model="form.status">
                                    <option value="active">Aktif</option>
                                    <option value="inactive">Nonaktif</option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>

                <input type="text" class="form-input" hidden name="role" value="counselor" x-model="form.role" >


                {{-- RIGHT SIDEBAR --}}
                <div class="xl:w-96 w-full xl:mt-0 mt-6">

                    <div class="panel p-5">
                        <h3 class="text-lg font-semibold mb-4">Aksi</h3>

                        <button type="submit" class="btn btn-primary w-full mb-3">
                            <svg width="22" height="22" fill="none" class="mr-2">
                                <path d="M12 2v18M5 9l7 7 7-7" stroke="currentColor" stroke-width="1.5"/>
                            </svg>
                            Simpan Konselor
                        </button>

                        <a href="{{ route('admin.counselor.index') }}" class="btn btn-outline-primary w-full">
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
                    online_price: '',
                    status: 'active'
                }
            }))
        });
    </script>

</x-admin.app>
