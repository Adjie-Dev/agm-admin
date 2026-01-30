@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('header', 'Edit Artikel')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Kembali ke Artikel</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl p-8 border border-slate-700/50 shadow-xl">
        <form action="{{ route('articles.update', $article) }}" method="POST" enctype="multipart/form-data" id="articleForm">
            @csrf
            @method('PUT')

            <!-- Title -->
            <div class="mb-6">
                <label for="title" class="block text-sm font-semibold text-gray-300 mb-2">
                    Judul <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       name="title"
                       id="title"
                       value="{{ old('title', $article->title) }}"
                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                       placeholder="Masukkan judul artikel"
                       required>
                @error('title')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Author -->
            <div class="mb-6">
                <label for="author" class="block text-sm font-semibold text-gray-300 mb-2">
                    Penulis <span class="text-red-400">*</span>
                </label>
                <input type="text"
                       name="author"
                       id="author"
                       value="{{ old('author', $article->author) }}"
                       class="w-full px-4 py-3 bg-slate-900/50 border border-slate-700 rounded-xl text-white placeholder-gray-500 focus:outline-none focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500/20 transition-all duration-200"
                       placeholder="Masukkan nama penulis"
                       required>
                @error('author')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Content HTML with Quill Editor -->
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-300 mb-2">
                    Konten <span class="text-red-400">*</span>
                </label>

                <!-- Quill Editor Container -->
                <div id="editor-wrapper" class="rounded-xl overflow-hidden border border-slate-700">
                    <div id="editor" style="min-height: 400px;"></div>
                </div>

                <!-- Hidden textarea untuk submit -->
                <textarea name="content_html" id="content_html" class="hidden">{{ old('content_html', $article->content_html) }}</textarea>

                <p class="mt-2 text-xs text-gray-500">Gunakan toolbar untuk memformat teks dan menambahkan gambar</p>
                <p id="content-error" class="mt-2 text-sm text-red-400 hidden">Konten artikel harus diisi</p>
                @error('content_html')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Current Thumbnail -->
            @if($article->thumbnail)
            <div class="mb-4">
                <label class="block text-sm font-semibold text-gray-300 mb-2">Thumbnail Saat Ini</label>
                <img src="{{ asset('storage/' . $article->thumbnail) }}"
                     alt="{{ $article->title }}"
                     class="w-48 h-48 object-cover rounded-xl border border-slate-600">
            </div>
            @endif

            <!-- Thumbnail -->
            <div class="mb-6">
                <label for="thumbnail" class="block text-sm font-semibold text-gray-300 mb-2">
                    {{ $article->thumbnail ? 'Ganti Thumbnail' : 'Gambar Thumbnail' }}
                </label>
                <div class="relative">
                    <input type="file"
                           name="thumbnail"
                           id="thumbnail"
                           accept="image/*"
                           class="hidden"
                           onchange="previewImage(event)">
                    <label for="thumbnail"
                           class="flex items-center justify-center w-full px-4 py-8 bg-slate-900/50 border-2 border-dashed border-slate-700 rounded-xl cursor-pointer hover:border-indigo-500 transition-all duration-200">
                        <div class="text-center" id="upload-placeholder">
                            <svg class="mx-auto w-12 h-12 text-gray-500 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                            </svg>
                            <p class="text-sm text-gray-400 mb-1">Klik untuk upload thumbnail baru</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF maksimal 2MB</p>
                        </div>
                        <div class="hidden" id="image-preview">
                            <img id="preview" class="max-h-48 rounded-lg" alt="Preview">
                        </div>
                    </label>
                </div>
                @error('thumbnail')
                <p class="mt-2 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            <!-- Hidden field untuk published_at -->
            <input type="hidden" name="published_at" id="published_at" value="{{ old('published_at', $article->published_at ? $article->published_at->format('Y-m-d H:i:s') : '') }}">

            <!-- Status Info -->
            @if($article->published_at)
            <div class="mb-6 p-4 bg-green-500/10 border border-green-500/30 rounded-xl">
                <div class="flex items-center space-x-2 text-green-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span class="font-semibold">Status: Published</span>
                </div>
                <p class="text-sm text-gray-400 mt-1 ml-7">Dipublikasikan pada {{ $article->published_at->format('d M Y, H:i') }}</p>
            </div>
            @else
            <div class="mb-6 p-4 bg-yellow-500/10 border border-yellow-500/30 rounded-xl">
                <div class="flex items-center space-x-2 text-yellow-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <span class="font-semibold">Status: Draft</span>
                </div>
                <p class="text-sm text-gray-400 mt-1 ml-7">Artikel ini belum dipublikasikan</p>
            </div>
            @endif

            <!-- Action Buttons -->
            <div class="flex items-center justify-between">
                <a href="{{ route('articles.index') }}"
                   class="px-6 py-3 bg-slate-700 hover:bg-slate-600 text-white font-semibold rounded-xl transition-all duration-300">
                    Batal
                </a>

                <div class="flex items-center space-x-4">
                    <!-- Simpan sebagai Draft -->
                    <button type="button"
                            onclick="submitAsDraft()"
                            class="px-6 py-3 bg-slate-600 hover:bg-slate-500 text-white font-semibold rounded-xl transition-all duration-300 flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        <span>Simpan sebagai Draft</span>
                    </button>

                    <!-- Publish/Update Artikel -->
                    <button type="button"
                            onclick="submitAsPublished()"
                            class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        <span>{{ $article->published_at ? 'Update & Publish' : 'Publish Artikel' }}</span>
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

/* Toolbar styling */
.ql-toolbar.ql-snow {
    border: none;
    border-bottom: 1px solid #334155;
    background: #1e293b;
    padding: 12px;
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
</style>

<!-- Quill JS -->
<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

<script>
// Initialize Quill Editor
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

// Load existing content ke Quill editor
const existingContent = document.getElementById('content_html').value;
if (existingContent) {
    quill.root.innerHTML = existingContent;
}

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
    // Jika sudah pernah dipublish, pertahankan tanggal original
    // Jika belum pernah, set ke waktu sekarang
    const currentPublishedAt = document.getElementById('published_at').value;

    if (!currentPublishedAt) {
        const now = new Date();
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0');
        const day = String(now.getDate()).padStart(2, '0');
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const seconds = String(now.getSeconds()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day} ${hours}:${minutes}:${seconds}`;
        document.getElementById('published_at').value = formattedDate;
    }

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
