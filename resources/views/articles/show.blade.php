@extends('layouts.app')

@section('title', $article->title)

@section('header', 'Detail Artikel')

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

    <!-- Article Card -->
    <article class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <!-- Thumbnail -->
        @if($article->thumbnail)
        <div class="w-full h-48 sm:h-64 md:h-80 overflow-hidden">
            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover"
                 loading="lazy"
                 decoding="async">
        </div>
        @endif

        <!-- Content -->
        <div class="p-4 sm:p-6 lg:p-8">
            <!-- Status Badge -->
            <div class="mb-3 sm:mb-4">
                @if($article->published_at)
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-green-500/10 text-green-400">
                    Published
                </span>
                @else
                <span class="inline-block px-3 py-1 text-xs font-semibold rounded-lg bg-gray-500/10 text-gray-400">
                    Draft
                </span>
                @endif
            </div>

            <!-- Title -->
            <h1 class="text-xl sm:text-2xl lg:text-3xl font-bold text-white mb-3 sm:mb-4">
                {{ $article->title }}
            </h1>

            <!-- Meta Information -->
            <div class="flex flex-wrap items-center gap-2 sm:gap-4 mb-4 sm:mb-6 pb-4 sm:pb-6 border-b border-slate-700/50">
                <!-- Author -->
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm text-gray-400">{{ $article->author }}</span>
                </div>

                <!-- Published Date -->
                @if($article->published_at)
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-xs sm:text-sm text-gray-400">{{ $article->published_at->format('d M Y, H:i') }}</span>
                </div>
                @endif

                <!-- Updated Date -->
                @if($article->updated_at && $article->updated_at != $article->created_at)
                <div class="flex items-center space-x-2">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    <span class="text-xs sm:text-sm text-gray-400">Updated {{ $article->updated_at->format('d M Y') }}</span>
                </div>
                @endif
            </div>

            <!-- Article Content -->
            <div class="prose prose-sm sm:prose lg:prose-lg prose-invert max-w-none">
                <div class="article-content text-sm sm:text-base text-gray-300 leading-relaxed">
                    {!! $article->content_html !!}
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="px-4 py-4 sm:px-6 sm:py-5 lg:px-8 lg:py-6 bg-slate-900/50 border-t border-slate-700/50">
            <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
                <a href="{{ route('articles.edit', $article) }}"
                   class="flex-1 px-4 py-2.5 sm:px-6 sm:py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 text-sm sm:text-base">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Artikel</span>
                </a>

                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="flex-1">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus artikel ini?')"
                            class="w-full px-4 py-2.5 sm:px-6 sm:py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center justify-center space-x-2 text-sm sm:text-base">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Hapus Artikel</span>
                    </button>
                </form>
            </div>
        </div>
    </article>
</div>

<style>
/* Article Content Styling */
.article-content {
    word-wrap: break-word;
    overflow-wrap: break-word;
}

.article-content img {
    max-width: 100%;
    height: auto;
    border-radius: 0.75rem;
    margin: 1.5rem 0;
}

.article-content h1,
.article-content h2,
.article-content h3,
.article-content h4,
.article-content h5,
.article-content h6 {
    color: #f1f5f9;
    font-weight: 700;
    margin-top: 1.5rem;
    margin-bottom: 1rem;
}

.article-content h1 {
    font-size: 1.875rem;
    line-height: 2.25rem;
}

.article-content h2 {
    font-size: 1.5rem;
    line-height: 2rem;
}

.article-content h3 {
    font-size: 1.25rem;
    line-height: 1.75rem;
}

.article-content p {
    margin-bottom: 1rem;
}

.article-content a {
    color: #818cf8;
    text-decoration: underline;
}

.article-content a:hover {
    color: #a5b4fc;
}

.article-content ul,
.article-content ol {
    margin: 1rem 0;
    padding-left: 1.5rem;
}

.article-content li {
    margin-bottom: 0.5rem;
}

.article-content blockquote {
    border-left: 4px solid #4f46e5;
    padding-left: 1rem;
    margin: 1.5rem 0;
    font-style: italic;
    color: #cbd5e1;
}

.article-content pre {
    background: #1e293b;
    border: 1px solid #334155;
    border-radius: 0.5rem;
    padding: 1rem;
    overflow-x: auto;
    margin: 1.5rem 0;
}

.article-content code {
    background: #1e293b;
    padding: 0.25rem 0.5rem;
    border-radius: 0.25rem;
    font-size: 0.875em;
}

.article-content pre code {
    background: transparent;
    padding: 0;
}

.article-content table {
    width: 100%;
    border-collapse: collapse;
    margin: 1.5rem 0;
}

.article-content table th,
.article-content table td {
    border: 1px solid #334155;
    padding: 0.75rem;
    text-align: left;
}

.article-content table th {
    background: #1e293b;
    font-weight: 600;
}

/* Mobile Responsive */
@media (max-width: 640px) {
    .article-content h1 {
        font-size: 1.5rem;
        line-height: 2rem;
    }

    .article-content h2 {
        font-size: 1.25rem;
        line-height: 1.75rem;
    }

    .article-content h3 {
        font-size: 1.125rem;
        line-height: 1.5rem;
    }

    .article-content img {
        margin: 1rem 0;
    }

    .article-content pre {
        font-size: 0.75rem;
        padding: 0.75rem;
    }

    .article-content table {
        font-size: 0.875rem;
    }

    .article-content table th,
    .article-content table td {
        padding: 0.5rem;
    }
}
</style>
@endsection
