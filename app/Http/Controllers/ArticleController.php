<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     * OPTIMASI: Select only needed columns, efficient pagination
     */
    public function index()
    {
        // Hanya select kolom yang benar-benar diperlukan untuk tampilan list
        $articles = Article::select(
                'id',
                'title',
                'thumbnail',
                'author',
                'published_at',
                'created_at',
                'updated_at'
            )
            ->latest()
            ->paginate(10);

        return view('articles.index', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     * OPTIMASI: Efficient file upload handling
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_html' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validated['author'] = auth()->user()->name;
        $validated['created_by'] = auth()->id();
        $validated['updated_by'] = auth()->id();

        // OPTIMASI: Handle file upload dengan putFileAs untuk custom naming
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['thumbnail'] = $file->storeAs('articles/thumbnails', $filename, 'public');
        }

        Article::create($validated);

        // Clear cache setelah create
        $this->clearArticleCache();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dibuat!');
    }

    /**
     * Display the specified resource.
     * OPTIMASI: Select only needed columns with relationships
     */
    public function show(Article $article)
    {
        // Load hanya kolom yang diperlukan dari relasi
        $article->load([
            'creator:id,name',
            'updater:id,name'
        ]);

        return view('articles.show', compact('article'));
    }

    /**
     * Show the form for editing the specified resource.
     * OPTIMASI: Select only needed columns with relationships
     */
    public function edit(Article $article)
    {
        // Load hanya kolom yang diperlukan dari relasi
        $article->load([
            'creator:id,name',
            'updater:id,name'
        ]);

        return view('articles.edit', compact('article'));
    }

    /**
     * Update the specified resource in storage.
     * OPTIMASI: Efficient update with selective file handling
     */
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content_html' => 'required',
            'thumbnail' => 'nullable|image|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $validated['author'] = auth()->user()->name;
        $validated['updated_by'] = auth()->id();

        // OPTIMASI: Hanya proses file jika ada file baru
        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail jika ada
            if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
                Storage::disk('public')->delete($article->thumbnail);
            }

            // Upload new thumbnail
            $file = $request->file('thumbnail');
            $filename = time() . '_' . $file->getClientOriginalName();
            $validated['thumbnail'] = $file->storeAs('articles/thumbnails', $filename, 'public');
        }

        // OPTIMASI: Update hanya field yang berubah
        $article->update($validated);

        // Clear cache setelah update
        $this->clearArticleCache();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     * OPTIMASI: Efficient file deletion
     */
    public function destroy(Article $article)
    {
        // OPTIMASI: Check file existence sebelum delete
        if ($article->thumbnail && Storage::disk('public')->exists($article->thumbnail)) {
            Storage::disk('public')->delete($article->thumbnail);
        }

        $article->delete();

        // Clear cache setelah delete
        $this->clearArticleCache();

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil dihapus!');
    }

    /**
     * Upload image untuk TinyMCE editor
     * OPTIMASI: Efficient image upload handling
     */
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:2048',
        ]);

        // OPTIMASI: Custom filename untuk menghindari conflict
        $file = $request->file('file');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('articles/images', $filename, 'public');

        return response()->json([
            'location' => asset('storage/' . $path)
        ]);
    }

    /**
     * Clear all article-related cache
     * PRIVATE METHOD untuk internal use
     */
    private function clearArticleCache()
    {
        Cache::forget('dashboard.count.articles');
        Cache::forget('dashboard.recent_articles');
    }
}
