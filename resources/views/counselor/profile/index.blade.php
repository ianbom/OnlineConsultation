<x-counselor.app>

<div class="space-y-6">
    {{-- Breadcrumb --}}
    <ul class="flex items-center space-x-2 rtl:space-x-reverse text-sm">
        <li>
            <a href="javascript:;" class="text-primary hover:underline font-medium">Counselor</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2 before:text-gray-400">
            <span class="text-gray-600">Profile Settings</span>
        </li>
    </ul>

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h5 class="font-bold text-2xl text-gray-800">Pengaturan Profil Konselor</h5>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan kredensial Anda</p>
        </div>
    </div>


    {{-- Main Form --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('counselor.profile.update') }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf
            @method('PUT')

            {{-- Profile Picture Section --}}
            <div class="p-6 border-b border-gray-200">
                <h6 class="text-lg font-semibold text-gray-800 mb-4">Foto Profil</h6>

                <div class="flex flex-col sm:flex-row items-center gap-6">
                    <div class="relative">
                        <img src="{{ $profile->profile_pic ? asset('storage/'.$profile->profile_pic) : '/assets/images/profile-34.jpeg' }}"
                             alt="Profile Picture"
                             id="preview-image"
                             class="w-32 h-32 rounded-full object-cover border-4 border-gray-100 shadow-md">
                        <div class="absolute bottom-0 right-0 bg-primary rounded-full p-2 shadow-lg">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="flex-1 text-center sm:text-left">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Pilih Foto Baru
                        </label>
                        <input type="file"
                               name="profile_pic"
                               id="profile-pic-input"
                               accept="image/jpeg,image/jpg,image/png,image/gif"
                               class="block w-full text-sm text-gray-600
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary/10 file:text-primary
                                      hover:file:bg-primary/20
                                      cursor-pointer transition-all">
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG atau GIF (max. 2MB)</p>
                        @error('profile_pic')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- General Information --}}
            <div class="p-6 border-b border-gray-200">
                <h6 class="text-lg font-semibold text-gray-800 mb-5">Informasi Umum</h6>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- NAMA --}}
                    <div class="form-group">
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                            Nama Lengkap <span class="text-red-500">*</span>
                        </label>
                        <input id="name"
                               name="name"
                               type="text"
                               class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 @error('name') border-red-500 @enderror"
                               value="{{ old('name', $profile->name) }}"
                               placeholder="Masukkan nama lengkap"
                               required>
                        @error('name')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- EMAIL --}}
                    <div class="form-group">
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email <span class="text-red-500">*</span>
                        </label>
                        <input id="email"
                               name="email"
                               type="email"
                               class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 @error('email') border-red-500 @enderror"
                               value="{{ old('email', $profile->email) }}"
                               placeholder="email@example.com"
                               required>
                        @error('email')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- NOMOR HP --}}
                    <div class="form-group">
                        <label for="phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor HP
                        </label>
                        <input id="phone"
                               name="phone"
                               type="text"
                               class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 @error('phone') border-red-500 @enderror"
                               value="{{ old('phone', $profile->phone) }}"
                               placeholder="08xxxxxxxxxx">
                        @error('phone')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- PENDIDIKAN --}}
                    <div class="form-group">
                        <label for="education" class="block text-sm font-medium text-gray-700 mb-2">
                            Pendidikan <span class="text-red-500">*</span>
                        </label>
                        <input id="education"
                               name="education"
                               type="text"
                               class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 @error('education') border-red-500 @enderror"
                               placeholder="Contoh: S1 Psikologi, M.Psi"
                               value="{{ old('education', $profile->counselor->education) }}"
                               required>
                        @error('education')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

             {{-- Password Update --}}
                <div class="p-6 border-b border-gray-200">
                    <h6 class="text-lg font-semibold text-gray-800 mb-5">Ubah Password</h6>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                        {{-- PASSWORD BARU --}}
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Password Baru
                            </label>
                            <input id="password"
                                   name="password"
                                   type="password"
                                   class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/20 @error('password') border-red-500 @enderror"
                                   placeholder="Kosongkan jika tidak ingin mengubah password">
                            @error('password')
                                <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- KONFIRMASI PASSWORD --}}
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password Baru
                            </label>
                            <input id="password_confirmation"
                                   name="password_confirmation"
                                   type="password"
                                   class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring-primary/20"
                                   placeholder="Ulangi password baru">
                        </div>

                    </div>

                    <p class="text-xs text-gray-500 mt-2">
                        * Password hanya akan berubah jika Anda mengisi kedua kolom di atas.
                    </p>
                </div>

            {{-- Professional Information --}}
            <div class="p-6 border-b border-gray-200">
                <h6 class="text-lg font-semibold text-gray-800 mb-5">Informasi Profesional</h6>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">

                    {{-- SPESIALISASI --}}
                    <div class="form-group">
                        <label for="specialization" class="block text-sm font-medium text-gray-700 mb-2">
                            Spesialisasi <span class="text-red-500">*</span>
                        </label>
                        <input id="specialization"
                               name="specialization"
                               type="text"
                               class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 @error('specialization') border-red-500 @enderror"
                               placeholder="Contoh: Kesehatan Mental, Pernikahan"
                               value="{{ old('specialization', $profile->counselor->specialization) }}"
                               required>
                        @error('specialization')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- DESKRIPSI --}}
                    <div class="form-group sm:col-span-2">
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                            Deskripsi / Bio Konselor <span class="text-red-500">*</span>
                        </label>
                        <textarea id="description"
                                  name="description"
                                  rows="5"
                                  class="form-input w-full rounded-lg border-gray-300 focus:border-primary focus:ring focus:ring-primary/20 resize-none @error('description') border-red-500 @enderror"
                                  placeholder="Tuliskan deskripsi lengkap tentang pengalaman, pendekatan konseling, sertifikasi yang dimiliki, dan informasi relevan lainnya..."
                                  required>{{ old('description', $profile->counselor->description) }}</textarea>
                        <p class="text-xs text-gray-500 mt-2">Minimal 100 karakter untuk deskripsi yang informatif</p>
                        @error('description')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                </div>
            </div>

            {{-- Action Buttons --}}
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ url()->previous() }}"
                       class="btn bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 w-full sm:w-auto px-6 py-2.5 rounded-lg font-medium transition-all">
                        Batal
                    </a>
                    <button type="submit"
                            class="btn btn-primary w-full sm:w-auto px-8 py-2.5 rounded-lg font-medium shadow-sm hover:shadow transition-all">
                        <span class="flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Simpan Perubahan
                        </span>
                    </button>
                </div>
            </div>

        </form>
    </div>

</div>

<script>
    // Preview image before upload
    document.getElementById('profile-pic-input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('preview-image').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>

</x-counselor.app>
