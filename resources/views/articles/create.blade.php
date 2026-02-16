@extends('layouts.app')

@section('title', 'Buat Artikel')

@section('header', 'Buat Artikel Baru')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Back Button -->
    <div class="mb-4 sm:mb-6">
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium text-sm sm:text-base">Kembali ke Artikel</span>
        </a>
    </div>

    <!-- Author Info -->
    <div class="mb-4 sm:mb-6 bg-slate-800/50 backdrop-blur-sm rounded-xl p-3 sm:p-4 border border-slate-700/50">
        <div class="flex items-center space-x-3">
            @if(auth()->user()->profile_photo)
            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-8 h-8 sm:w-10 sm:h-10 rounded-full object-cover border-2 border-indigo-500">
            @else
            <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-full bg-indigo-600 flex items-center justify-center border-2 border-indigo-500">
                <span class="text-white font-semibold text-xs sm:text-sm">{{ substr(auth()->user()->name, 0, 1) }}</span>
            </div>
            @endif
            <div>
                <p class="text-xs text-gray-400">Penulis</p>
                <p class="text-xs sm:text-sm font-semibold text-white">{{ auth()->user()->name }}</p>
            </div>
        </div>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-4 sm:p-6 lg:p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('articles.store') }}" method="POST" enctype="multipart/form-data" id="articleForm">
            @csrf

            <!-- Title -->
            <div class="mb-4 sm:mb-6">
                <label for="title" class="block text-xs sm:text-sm font-semibold text-gray-300 mb-2">
                    Judul <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title') }}"
                       class="w-full px-3 py-2 sm:px-4 sm:py-3 text-sm sm:text-base bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                       placeholder="Masukkan judul artikel"
                       required>
                @error('title')
                <p class="mt-2 text-xs sm:text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content HTML with Quill Editor -->
            <div class="mb-4 sm:mb-6">
                <label class="block text-xs sm:text-sm font-semibold text-gray-300 mb-2">
                    Konten <span class="text-red-400">*</span>
                </label>

                <!-- Quill Editor Container -->
                <div id="editor-wrapper" class="rounded-xl overflow-hidden border border-slate-700">
                    <div id="editor" style="min-height: 250px;"></div>
                </div>

                <!-- Hidden textarea untuk submit -->
                <textarea name="content_html" id="content_html" class="hidden">{{ old('content_html') }}</textarea>

                <p class="mt-2 text-xs text-gray-500">Gunakan toolbar untuk memformat teks dan menambahkan gambar</p>
                <p id="content-error" class="mt-2 text-xs sm:text-sm text-red-400 hidden">Konten artikel harus diisi</p>
                @error('content_html')
                <p class="mt-2 text-xs sm:text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Thumbnail -->
            <div class="mb-4 sm:mb-6">
                <label for="thumbnail" class="block text-xs sm:text-sm font-semibold text-gray-300 mb-2">
                    Gambar Thumbnail
                </label>
                <div class="relative">
                    <input type="file"
                           name="thumbnail"
                           id="thumbnail"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">
                    <label for="thumbnail"
                           class="flex items-center justify-center w-full px-3 py-6 sm:px-4 sm:py-8 bg-slate-900/50 border-2 border-dashed border-slate-700 rounded-xl cursor-pointer hover:border-indigo-500 transition-all duration-200">
                        <div class="text-center" id="upload-placeholder">
                            <svg class="mx-auto w-10 h-10 sm:w-12 sm:h-12 text-gray-500 mb-2 sm:mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-xs sm:text-sm text-gray-400 mb-1">Klik untuk upload thumbnail</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                        </div>
                        <div class="hidden" id="image-preview">
                            <img id="preview" class="max-h-32 sm:max-h-48 rounded-lg" alt="Preview">
                        </div>
                    </label>
                </div>
                @error('thumbnail')
                <p class="mt-2 text-xs sm:text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden field untuk published_at -->
            <input type="hidden" name="published_at" id="published_at" value="">

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 sm:gap-0">
                <a href="{{ route('articles.index') }}"
                   class="w-full sm:w-auto px-4 py-2.5 sm:px-6 sm:py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-300 text-center text-sm sm:text-base">
                    Batal
                </a>

                <div class="flex flex-col sm:flex-row items-center gap-3 sm:gap-4">
                    <!-- Simpan sebagai Draft -->
                    <button type="button"
                            onclick="submitAsDraft()"
                            class="w-full sm:w-auto px-4 py-2.5 sm:px-6 sm:py-3 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-300 flex items-center justify-center space-x-2 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Simpan sebagai Draft</span>
                    </button>

                    <!-- Publish Artikel -->
                    <button type="button"
                            onclick="submitAsPublished()"
                            class="w-full sm:w-auto px-4 py-2.5 sm:px-6 sm:py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>Publish Artikel</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">

<!-- Custom Dark Theme for Quill -->
<style>
/* Dark Theme untuk Quill Editor */
#editor-wrapper {
    background: #0f172a;
}

/* Toolbar styling - WRAP agar SEMUA toolbar terlihat */
.ql-toolbar.ql-snow {
    border: none;
    border-bottom: 1px solid #334155;
    background: #1e293b;
    padding: 12px;
    display: flex;
    flex-wrap: wrap;
    gap: 4px;
}

/* Toolbar buttons */
.ql-snow .ql-stroke {
    stroke: #94a3b8;
}

.ql-snow .ql-fill {
    fill: #94a3b8;
}

.ql-snow .ql-picker-label {
    color: #94a3b8;
}

/* Hover state untuk toolbar buttons */
.ql-snow .ql-picker-label:hover,
.ql-snow button:hover .ql-stroke,
.ql-snow button:hover .ql-fill {
    stroke: #e0e7ff;
    fill: #e0e7ff;
    color: #e0e7ff;
}

/* Active state */
.ql-snow button.ql-active .ql-stroke,
.ql-snow .ql-picker-label.ql-active .ql-stroke {
    stroke: #818cf8;
}

.ql-snow button.ql-active .ql-fill,
.ql-snow .ql-picker-label.ql-active .ql-fill {
    fill: #818cf8;
}

/* Dropdown menu */
.ql-snow .ql-picker-options {
    background: #1e293b;
    border: 1px solid #334155;
}

.ql-snow .ql-picker-item {
    color: #cbd5e1;
}

.ql-snow .ql-picker-item:hover {
    background: #334155;
    color: #e0e7ff;
}

/* Editor content area */
.ql-container.ql-snow {
    border: none;
    background: #0f172a;
}

.ql-editor {
    color: #e2e8f0;
    font-size: 15px;
    line-height: 1.6;
    padding: 20px;
    min-height: 400px;
}

/* Placeholder text */
.ql-editor.ql-blank::before {
    color: #475569;
    font-style: italic;
}

/* Selected text */
.ql-editor ::selection {
    background: #3730a3;
    color: #e0e7ff;
}

/* Links dalam editor */
.ql-editor a {
    color: #818cf8;
}

/* Headings */
.ql-editor h1,
.ql-editor h2,
.ql-editor h3,
.ql-editor h4,
.ql-editor h5,
.ql-editor h6 {
    color: #f1f5f9;
}

/* Blockquote */
.ql-editor blockquote {
    border-left: 4px solid #4f46e5;
    padding-left: 16px;
    color: #cbd5e1;
}

/* Code block */
.ql-editor pre.ql-syntax {
    background: #1e293b;
    color: #94a3b8;
    border: 1px solid #334155;
    border-radius: 8px;
    padding: 12px;
}

/* Lists */
.ql-editor ul,
.ql-editor ol {
    color: #e2e8f0;
}

/* Tooltip */
.ql-snow .ql-tooltip {
    background: #1e293b;
    border: 1px solid #334155;
    color: #cbd5e1;
    box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
}

.ql-snow .ql-tooltip input[type=text] {
    background: #0f172a;
    border: 1px solid #334155;
    color: #e2e8f0;
    padding: 8px;
    border-radius: 6px;
}

.ql-snow .ql-tooltip a.ql-action::after,
.ql-snow .ql-tooltip a.ql-remove::before {
    color: #818cf8;
}

/* Scrollbar untuk editor */
.ql-editor::-webkit-scrollbar {
    width: 8px;
}

.ql-editor::-webkit-scrollbar-track {
    background: #1e293b;
}

.ql-editor::-webkit-scrollbar-thumb {
    background: #475569;
    border-radius: 4px;
}

.ql-editor::-webkit-scrollbar-thumb:hover {
    background: #64748b;
}

/* Mobile Responsive - WRAP agar SEMUA toolbar terlihat */
@media (max-width: 640px) {
    .ql-toolbar.ql-snow {
        padding: 10px 8px;
        gap: 6px;
    }

    .ql-editor {
        font-size: 14px;
        padding: 12px;
        min-height: 250px;
    }

    .ql-snow .ql-formats {
        display: inline-flex;
        flex-wrap: nowrap;
        align-items: center;
    }

    .ql-snow.ql-toolbar button {
        width: 32px;
        height: 32px;
        padding: 5px;
    }

    .ql-snow .ql-picker {
        font-size: 12px;
    }

    .ql-snow .ql-picker-label {
        padding: 5px 6px;
    }
}
</style>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
// Initialize Quill Editor dengan SEMUA toolbar lengkap
var quill = new Quill('#editor', {
    theme: 'snow',
    modules: {
        toolbar: [
            [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
            [{ 'font': [] }],
            [{ 'size': ['small', false, 'large', 'huge'] }],
            ['bold', 'italic', 'underline', 'strike'],
            [{ 'color': [] }, { 'background': [] }],
            [{ 'script': 'sub'}, { 'script': 'super' }],
            [{ 'list': 'ordered'}, { 'list': 'bullet' }],
            [{ 'indent': '-1'}, { 'indent': '+1' }],
            [{ 'align': [] }],
            ['blockquote', 'code-block'],
            ['link', 'image', 'video'],
            ['clean']
        ]
    },
    placeholder: 'Tulis konten artikel di sini...'
});

// Handle image upload
quill.getModule('toolbar').addHandler('image', function() {
    selectLocalImage();
});

function selectLocalImage() {
    const input = document.createElement('input');
    input.setAttribute('type', 'file');
    input.setAttribute('accept', 'image/*');
    input.click();

    input.onchange = () => {
        const file = input.files[0];

        if (file) {
            const formData = new FormData();
            formData.append('file', file);

            fetch('{{ route("articles.upload-image") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData
            })
            .then(response => response.json())
            .then(result => {
                const range = quill.getSelection();
                quill.insertEmbed(range.index, 'image', result.location);
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal upload gambar');
            });
        }
    };
}

// Fungsi untuk submit sebagai draft
function submitAsDraft() {
    // Set published_at kosong untuk draft
    document.getElementById('published_at').value = '';

    // Validasi dan submit form
    validateAndSubmit();
}

// Fungsi untuk submit sebagai published
function submitAsPublished() {
    // Set published_at ke waktu sekarang
    const now = new Date();
    const year = now.getFullYear();
    const month = String(now.getMonth() + 1).padStart(2, '0');
    const day = String(now.getDate()).padStart(2, '0');
    const hours = String(now.getHours()).padStart(2, '0');
    const minutes = String(now.getMinutes()).padStart(2, '0');
    const seconds = String(now.getSeconds()).padStart(2, '0');

    const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
    document.getElementById('published_at').value = formattedDate;

    // Validasi dan submit form
    validateAndSubmit();
}

// Fungsi untuk validasi dan submit
function validateAndSubmit() {
    // Update textarea dengan konten dari Quill
    const content = quill.root.innerHTML;
    document.getElementById('content_html').value = content;

    // Validasi konten tidak boleh kosong
    const text = quill.getText().trim();
    if (text.length === 0) {
        // Tampilkan pesan error
        const errorElement = document.getElementById('content-error');
        errorElement.classList.remove('hidden');

        // Scroll ke editor
        document.getElementById('editor-wrapper').scrollIntoView({
            behavior: 'smooth',
            block: 'center'
        });

        // Fokus ke editor
        quill.focus();

        // Tambahkan border merah ke editor
        document.getElementById('editor-wrapper').style.borderColor = '#f87171';

        // Hapus border merah setelah 3 detik
        setTimeout(() => {
            document.getElementById('editor-wrapper').style.borderColor = '';
        }, 3000);

        return false;
    }

    // Sembunyikan error jika ada
    document.getElementById('content-error').classList.add('hidden');

    // Submit form
    document.getElementById('articleForm').submit();
}

// Prevent default form submission
document.getElementById('articleForm').onsubmit = function(e) {
    e.preventDefault();
    return false;
};

// Preview thumbnail
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('upload-placeholder').classList.add('hidden');
            document.getElementById('image-preview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
