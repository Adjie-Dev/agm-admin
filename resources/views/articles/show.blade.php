@extends('layouts.app')

@section('title', $article->title)

@section('header', 'Article Detail')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Back Button -->
    <div class="mb-6">
        <a href="{{ route('articles.index') }}"
           class="inline-flex items-center space-x-2 text-gray-400 hover:text-white transition-colors duration-200">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            <span class="font-medium">Back to Articles</span>
        </a>
    </div>

    <!-- Article Card -->
    <div class="bg-slate-800/70 backdrop-blur-sm rounded-2xl border border-slate-700/50 shadow-xl overflow-hidden">
        <!-- Thumbnail -->
        @if($article->thumbnail)
        <div class="w-full h-96 overflow-hidden">
            <img src="{{ asset('storage/' . $article->thumbnail) }}"
                 alt="{{ $article->title }}"
                 class="w-full h-full object-cover">
        </div>
        @endif

        <!-- Content -->
        <div class="p-8">
            <!-- Header -->
            <div class="mb-6">
                <h1 class="text-3xl font-bold text-white mb-4">{{ $article->title }}</h1>

                <div class="flex items-center space-x-6 text-sm text-gray-400">
                    <!-- Author -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <span>{{ $article->author }}</span>
                    </div>

                    <!-- Published Date -->
                    <div class="flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        @if($article->published_at)
                        <span>{{ $article->published_at->format('F d, Y') }}</span>
                        @else
                        <span class="px-3 py-1 text-xs font-semibold rounded-lg bg-gray-500/10 text-gray-400">
                            Draft
                        </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mb-6"></div>

            <!-- Article Content -->
            <div class="prose prose-invert prose-lg max-w-none">
                <div class="text-gray-300 leading-relaxed">
                    {!! $article->content_html !!}
                </div>
            </div>

            <!-- Divider -->
            <div class="border-t border-slate-700/50 mt-8 mb-6"></div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('articles.edit', $article) }}"
                   class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>Edit Article</span>
                </a>
                <form action="{{ route('articles.destroy', $article) }}" method="POST" class="inline-block">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            onclick="return confirm('Are you sure you want to delete this article?')"
                            class="px-6 py-3 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl transition-all duration-300 shadow-lg hover:shadow-xl flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        <span>Delete Article</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Prose Styles for Content */
    .prose h1 { @apply text-3xl font-bold text-white mb-4 mt-8; }
    .prose h2 { @apply text-2xl font-bold text-white mb-3 mt-6; }
    .prose h3 { @apply text-xl font-bold text-white mb-2 mt-4; }
    .prose p { @apply mb-4; }
    .prose ul { @apply list-disc list-inside mb-4; }
    .prose ol { @apply list-decimal list-inside mb-4; }
    .prose li { @apply mb-2; }
    .prose a { @apply text-indigo-400 hover:text-indigo-300 underline; }
    .prose strong { @apply font-bold text-white; }
    .prose em { @apply italic; }
    .prose code { @apply bg-slate-900 px-2 py-1 rounded text-cyan-400 text-sm; }
    .prose pre { @apply bg-slate-900 p-4 rounded-xl overflow-x-auto mb-4; }
    .prose blockquote { @apply border-l-4 border-indigo-500 pl-4 italic text-gray-400 my-4; }
    .prose img { @apply rounded-xl my-4; }
</style>
@endsection
