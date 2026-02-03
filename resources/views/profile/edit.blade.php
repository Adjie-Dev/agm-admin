@extends('layouts.app')

@section('title', 'Edit Profile')

@section('header', 'Edit Profile')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css">
@endpush

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('profile.show') }}" class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Profile</span>
        </a>
    </div>

    <!-- Header -->
    <div class="bg-gradient-to-br from-indigo-600/20 to-indigo-800/20 backdrop-blur-sm rounded-2xl p-6 border border-indigo-500/30 shadow-xl mb-6">
        <div class="flex items-center space-x-4">
            <div class="relative">
                @if(Auth::user()->profile_photo)
                    <img src="{{ asset('storage/' . Auth::user()->profile_photo) }}?t={{ time() }}"
                         alt="Profile Photo"
                         id="preview-photo"
                         class="w-20 h-20 rounded-2xl object-cover border-2 border-indigo-500/50">
                @else
                    <div class="w-20 h-20 rounded-2xl bg-indigo-600/30 flex items-center justify-center" id="preview-initials">
                        <span class="text-2xl font-bold text-indigo-300">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</span>
                    </div>
                @endif

                <!-- Camera Icon Button - Bottom Right -->
                <label for="profile_photo_input" class="absolute -bottom-1 -right-1 w-8 h-8 bg-blue-600 hover:bg-blue-700 rounded-full flex items-center justify-center cursor-pointer shadow-lg transition-all duration-300 hover:scale-110 border-2 border-slate-800">
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </label>
                <input type="file" id="profile_photo_input" accept="image/*" class="hidden">
            </div>
            <div>
                <h2 class="text-2xl font-bold text-white">{{ Auth::user()->name }}</h2>
                <p class="text-indigo-300">{{ Auth::user()->email }}</p>
            </div>
        </div>
    </div>

    @if(session('photo_success'))
    <div class="mb-6 p-4 bg-emerald-600/20 border border-emerald-500/30 rounded-xl">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-emerald-300 font-medium">{{ session('photo_success') }}</p>
        </div>
    </div>
    @endif

    @if(session('success'))
    <div class="mb-6 p-4 bg-emerald-600/20 border border-emerald-500/30 rounded-xl">
        <div class="flex items-center space-x-2">
            <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <p class="text-emerald-300 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Form Update Profile -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl mb-6">
        <h3 class="text-xl font-bold text-white mb-6">Update Informasi Profile</h3>

        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
            @csrf
            @method('PATCH')

            <div>
                <label for="name" class="block text-sm font-semibold text-gray-300 mb-2">Nama</label>
                <input type="text"
                       name="name"
                       id="name"
                       value="{{ old('name', Auth::user()->name) }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
                @error('name')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="email" class="block text-sm font-semibold text-gray-300 mb-2">Email</label>
                <input type="email"
                       name="email"
                       id="email"
                       value="{{ old('email', Auth::user()->email) }}"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent transition"
                       required>
                @error('email')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>Simpan</span>
                </button>
            </div>
        </form>
    </div>

    <!-- Form Update Password -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 shadow-xl">
        <h3 class="text-xl font-bold text-white mb-6">Update Password</h3>

        @if(session('password_success'))
        <div class="mb-4 p-4 bg-emerald-600/20 border border-emerald-500/30 rounded-xl">
            <div class="flex items-center space-x-2">
                <svg class="w-5 h-5 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <p class="text-emerald-300 font-medium">{{ session('password_success') }}</p>
            </div>
        </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="current_password" class="block text-sm font-semibold text-gray-300 mb-2">Password Saat Ini</label>
                <input type="password"
                       name="current_password"
                       id="current_password"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
                @error('current_password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password" class="block text-sm font-semibold text-gray-300 mb-2">Password Baru</label>
                <input type="password"
                       name="password"
                       id="password"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
                @error('password')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-semibold text-gray-300 mb-2">Konfirmasi Password Baru</label>
                <input type="password"
                       name="password_confirmation"
                       id="password_confirmation"
                       class="w-full px-4 py-3 bg-slate-700/50 border border-slate-600/50 rounded-xl text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent transition"
                       required>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="px-6 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-xl font-semibold transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Update Password</span>
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Crop Photo -->
<div id="cropModal" class="hidden fixed inset-0 bg-black/80 flex items-center justify-center z-50 p-4">
    <div class="bg-slate-800 rounded-2xl max-w-2xl w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-xl font-bold text-white">Crop Foto Profile</h3>
            <button onclick="closeCropModal()" class="text-gray-400 hover:text-white transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <div class="mb-4">
            <div class="max-h-96 overflow-hidden rounded-xl bg-slate-900">
                <img id="cropImage" src="" alt="Crop" class="max-w-full">
            </div>
        </div>

        <div class="flex justify-end space-x-3">
            <button onclick="closeCropModal()" class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white rounded-xl font-semibold transition">
                Batal
            </button>
            <button onclick="uploadCroppedImage()" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-xl font-semibold transition flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span>Upload Foto</span>
            </button>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
<script>
let cropper = null;

document.getElementById('profile_photo_input').addEventListener('change', function(e) {
    const file = e.target.files[0];

    if (!file) return;

    // Validasi tipe file
    if (!file.type.match('image.*')) {
        alert('Hanya file gambar yang diperbolehkan!');
        e.target.value = '';
        return;
    }

    // Validasi ukuran file (max 5MB)
    if (file.size > 5 * 1024 * 1024) {
        alert('Ukuran file maksimal 5MB!');
        e.target.value = '';
        return;
    }

    // Tampilkan modal crop
    const reader = new FileReader();
    reader.onload = function(event) {
        const cropImage = document.getElementById('cropImage');
        cropImage.src = event.target.result;

        // Show modal
        document.getElementById('cropModal').classList.remove('hidden');

        // Destroy previous cropper if exists
        if (cropper) {
            cropper.destroy();
        }

        // Initialize cropper
        cropper = new Cropper(cropImage, {
            aspectRatio: 1,
            viewMode: 2,
            autoCropArea: 1,
            responsive: true,
            guides: true,
            center: true,
            highlight: true,
            cropBoxMovable: true,
            cropBoxResizable: true,
            toggleDragModeOnDblclick: false,
        });
    };
    reader.readAsDataURL(file);
});

function closeCropModal() {
    document.getElementById('cropModal').classList.add('hidden');
    document.getElementById('profile_photo_input').value = '';
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
}

function uploadCroppedImage() {
    if (!cropper) {
        alert('Tidak ada gambar untuk diupload');
        return;
    }

    // Tampilkan loading
    const loadingHtml = `
        <div id="upload-loading" class="fixed inset-0 bg-black/50 flex items-center justify-center z-[60]">
            <div class="bg-slate-800 rounded-xl p-6 text-center border border-slate-700">
                <div class="animate-spin rounded-full h-12 w-12 border-b-2 border-blue-500 mx-auto mb-4"></div>
                <p class="text-white font-semibold">Mengupload foto...</p>
            </div>
        </div>
    `;
    document.body.insertAdjacentHTML('beforeend', loadingHtml);

    // Get cropped canvas
    cropper.getCroppedCanvas({
        width: 400,
        height: 400,
        imageSmoothingEnabled: true,
        imageSmoothingQuality: 'high',
    }).toBlob(function(blob) {
        const formData = new FormData();
        formData.append('profile_photo', blob, 'profile.jpg');
        formData.append('_token', '{{ csrf_token() }}');

        fetch('{{ route("profile.photo.update") }}', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => {
            if (!response.ok) {
                return response.json().then(err => {
                    throw new Error(err.message || 'Upload gagal');
                });
            }
            return response.json();
        })
        .then(data => {
            document.getElementById('upload-loading')?.remove();
            if (data.success) {
                closeCropModal();
                // Reload halaman untuk menampilkan foto baru
                window.location.reload();
            } else {
                alert(data.message || 'Gagal mengupload foto');
            }
        })
        .catch(error => {
            document.getElementById('upload-loading')?.remove();
            console.error('Error:', error);
            alert('Terjadi kesalahan: ' + error.message);
        });
    }, 'image/jpeg', 0.9);
}
</script>
@endsection
