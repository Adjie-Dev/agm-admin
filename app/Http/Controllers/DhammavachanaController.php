<?php

namespace App\Http\Controllers;

use App\Models\Dhammavachana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;
use Spatie\PdfToImage\Pdf;

class DhammavachanaController extends Controller
{
    private function generatePdfThumbnail($pdfPath)
{
    try {
        $fullPdfPath = storage_path('app/public/' . $pdfPath);
        $thumbnailName = 'covers/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '_thumb.jpg';
        $fullThumbnailPath = storage_path('app/public/' . $thumbnailName);

        if (!file_exists(dirname($fullThumbnailPath))) {
            mkdir(dirname($fullThumbnailPath), 0755, true);
        }

        $pdf = new Pdf($fullPdfPath);
        $pdf->setPage(1)
            ->setResolution(150)
            ->saveImage($fullThumbnailPath);

        if (file_exists($fullThumbnailPath)) {
            return $thumbnailName;
        }

        return null;
    } catch (\Exception $e) {
        \Log::error('Generate thumbnail error: ' . $e->getMessage());
        return null;
    }
}

    public function index()
    {
        $dhammavachanas = Dhammavachana::with('uploader')
            ->latest()
            ->paginate(12);

        return view('dhammavachana.index', compact('dhammavachanas'));
    }

    public function create()
    {
        return view('dhammavachana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $pdfFile = $request->file('pdf_file');
            $pdfPath = $pdfFile->store('dhammavachana', 'public');
            $fullPath = storage_path('app/public/' . $pdfPath);

            // Set default values
            $title = $request->input('title');
            $pageCount = 0;
            $coverImage = null;

            // Try to parse PDF for metadata
            try {
                $parser = new Parser();
                $pdf = $parser->parseFile($fullPath);

                // Get title from PDF if not provided
                if (empty($title)) {
                    $details = $pdf->getDetails();
                    $title = $details['Title'] ?? '';
                }

                // Get page count
                $pageCount = count($pdf->getPages());
            } catch (\Exception $e) {
                \Log::warning('PDF parsing failed: ' . $e->getMessage());
            }

            // Fallback to filename if title still empty
            if (empty($title)) {
                $title = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
            }

            // Generate thumbnail (independent of parsing)
            $coverImage = $this->generatePdfThumbnail($pdfPath);

            // Create record - SIMPLE, NO array_filter
            $dhammavachana = new Dhammavachana();
            $dhammavachana->title = $title;
            $dhammavachana->description = $request->input('description');
            $dhammavachana->pdf_path = $pdfPath;
            $dhammavachana->cover_image = $coverImage;
            $dhammavachana->page_count = $pageCount;
            $dhammavachana->uploaded_by = Auth::id();
            $dhammavachana->save();

            return redirect()
                ->route('dhammavachana.index')
                ->with('success', 'Dhammavachana berhasil diupload!');

        } catch (\Exception $e) {
            if (isset($pdfPath) && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            \Log::error('Store dhammavachana error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupload dhammavachana: ' . $e->getMessage());
        }
    }

    public function show(Dhammavachana $dhammavachana)
    {
        return view('dhammavachana.show', compact('dhammavachana'));
    }

    public function edit(Dhammavachana $dhammavachana)
    {
        return view('dhammavachana.edit', compact('dhammavachana'));
    }

    public function update(Request $request, Dhammavachana $dhammavachana)
    {
        $request->validate([
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $dhammavachana->title = $request->input('title');
            $dhammavachana->description = $request->input('description');

            if ($request->hasFile('pdf_file')) {
                $pdfFile = $request->file('pdf_file');
                $pdfPath = $pdfFile->store('dhammavachana', 'public');
                $fullPath = storage_path('app/public/' . $pdfPath);

                // Set default values
                $pageCount = 0;
                $coverImage = null;

                // Try to parse PDF for metadata
                try {
                    $parser = new Parser();
                    $pdf = $parser->parseFile($fullPath);
                    $pageCount = count($pdf->getPages());
                } catch (\Exception $e) {
                    \Log::warning('PDF parsing failed during update: ' . $e->getMessage());
                }

                // Generate thumbnail (independent of parsing)
                $coverImage = $this->generatePdfThumbnail($pdfPath);

                // Delete old files
                if ($dhammavachana->pdf_path && Storage::disk('public')->exists($dhammavachana->pdf_path)) {
                    Storage::disk('public')->delete($dhammavachana->pdf_path);
                }

                if ($dhammavachana->cover_image && Storage::disk('public')->exists($dhammavachana->cover_image)) {
                    Storage::disk('public')->delete($dhammavachana->cover_image);
                }

                $dhammavachana->pdf_path = $pdfPath;
                $dhammavachana->cover_image = $coverImage;
                $dhammavachana->page_count = $pageCount;
            }

            $dhammavachana->save();

            return redirect()
                ->route('dhammavachana.index')
                ->with('success', 'Dhammavachana berhasil diupdate!');

        } catch (\Exception $e) {
            if (isset($pdfPath) && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            \Log::error('Update dhammavachana error: ' . $e->getMessage());

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui dhammavachana: ' . $e->getMessage());
        }
    }

    public function destroy(Dhammavachana $dhammavachana)
    {
        try {
            if ($dhammavachana->pdf_path && Storage::disk('public')->exists($dhammavachana->pdf_path)) {
                Storage::disk('public')->delete($dhammavachana->pdf_path);
            }

            if ($dhammavachana->cover_image && Storage::disk('public')->exists($dhammavachana->cover_image)) {
                Storage::disk('public')->delete($dhammavachana->cover_image);
            }

            $dhammavachana->delete();

            return redirect()
                ->route('dhammavachana.index')
                ->with('success', 'Dhammavachana berhasil dihapus!');

        } catch (\Exception $e) {
            \Log::error('Delete dhammavachana error: ' . $e->getMessage());

            return redirect()
                ->route('dhammavachana.index')
                ->with('error', 'Gagal menghapus dhammavachana: ' . $e->getMessage());
        }
    }
}
