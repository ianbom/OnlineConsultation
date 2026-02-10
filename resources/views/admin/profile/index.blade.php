<x-admin.app>

{{-- Cropper.js CSS --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">

<div class="space-y-6">
    {{-- Breadcrumb --}}
    <ul class="flex items-center space-x-2 rtl:space-x-reverse text-sm">
        <li>
            <a href="{{ route('admin.dashboard') }}" class="text-primary hover:underline font-medium">Admin</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-2 rtl:before:ml-2 before:text-gray-400">
            <span class="text-gray-600">Profile Settings</span>
        </li>
    </ul>

    {{-- Header --}}
    <div class="flex items-center justify-between">
        <div>
            <h5 class="font-bold text-2xl text-gray-800">Pengaturan Profil Admin</h5>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi profil dan kredensial Anda</p>
        </div>
    </div>

    {{-- Main Form --}}
    <div class="bg-white rounded-lg shadow-sm border border-gray-200">
        <form action="{{ route('admin.profile.update') }}"
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
                               id="profile-pic-input"
                               accept="image/jpeg,image/jpg,image/png,image/gif"
                               class="block w-full text-sm text-gray-600
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-lg file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary/10 file:text-primary
                                      hover:file:bg-primary/20
                                      cursor-pointer transition-all">
                        <input type="hidden" name="profile_pic" id="cropped-image-data">
                        <p class="text-xs text-gray-500 mt-2">JPG, PNG atau GIF (max. 2MB) - Rasio 1:1</p>
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
                    <div class="form-group sm:col-span-2">
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

            {{-- Action Buttons --}}
            <div class="p-6 bg-gray-50 rounded-b-lg">
                <div class="flex flex-col sm:flex-row items-center justify-end gap-3">
                    <a href="{{ route('admin.dashboard') }}"
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

{{-- Modal Crop Image --}}
<div id="crop-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-2xl w-full max-h-[90vh] overflow-hidden">
        {{-- Modal Header --}}
        <div class="p-4 border-b border-gray-200 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Crop Foto Profil</h3>
            <button type="button" id="close-crop-modal" class="text-gray-400 hover:text-gray-600 transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        {{-- Modal Body --}}
        <div class="p-4 overflow-auto max-h-[calc(90vh-160px)]">
            <div class="bg-gray-100 rounded-lg overflow-hidden">
                <img id="image-to-crop" src="" alt="Image to crop" class="max-w-full">
            </div>
            <p class="text-sm text-gray-600 mt-3 text-center">Geser dan zoom untuk menyesuaikan area foto (rasio 1:1)</p>
        </div>

        {{-- Modal Footer --}}
        <div class="p-4 border-t border-gray-200 flex items-center justify-end gap-3">
            <button type="button" id="cancel-crop" class="btn bg-white border border-gray-300 text-gray-700 hover:bg-gray-50 px-5 py-2 rounded-lg font-medium transition">
                Batal
            </button>
            <button type="button" id="apply-crop" class="btn btn-primary px-5 py-2 rounded-lg font-medium shadow-sm hover:shadow transition">
                Terapkan Crop
            </button>
        </div>
    </div>
</div>

{{-- Cropper.js Library --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>

<script>
    let cropper = null;
    const modal = document.getElementById('crop-modal');
    const imageToCrop = document.getElementById('image-to-crop');
    const profilePicInput = document.getElementById('profile-pic-input');
    const previewImage = document.getElementById('preview-image');
    const croppedImageData = document.getElementById('cropped-image-data');

    profilePicInput.addEventListener('change', function(e) {
        const file = e.target.files[0];

        if (file) {
            const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Format file tidak didukung. Gunakan JPG, PNG, atau GIF.');
                e.target.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file terlalu besar. Maksimal 2MB.');
                e.target.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(event) {
                imageToCrop.src = event.target.result;
                modal.classList.remove('hidden');

                imageToCrop.onload = function() {
                    if (cropper) {
                        cropper.destroy();
                    }

                    cropper = new Cropper(imageToCrop, {
                        aspectRatio: 1 / 1,
                        viewMode: 2,
                        dragMode: 'move',
                        autoCropArea: 1,
                        restore: false,
                        guides: true,
                        center: true,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
            };
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('apply-crop').addEventListener('click', function() {
        if (cropper) {
            const canvas = cropper.getCroppedCanvas({
                width: 500,
                height: 500,
                imageSmoothingEnabled: true,
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob(function(blob) {
                const reader = new FileReader();
                reader.onloadend = function() {
                    const base64data = reader.result;
                    previewImage.src = base64data;
                    croppedImageData.value = base64data;
                    modal.classList.add('hidden');

                    if (cropper) {
                        cropper.destroy();
                        cropper = null;
                    }
                };
                reader.readAsDataURL(blob);
            }, 'image/jpeg', 0.9);
        }
    });

    function closeModal() {
        modal.classList.add('hidden');
        profilePicInput.value = '';
        if (cropper) {
            cropper.destroy();
            cropper = null;
        }
    }

    document.getElementById('cancel-crop').addEventListener('click', closeModal);
    document.getElementById('close-crop-modal').addEventListener('click', closeModal);

    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            closeModal();
        }
    });
</script>

</x-admin.app>
