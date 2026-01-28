<?php

namespace App\Http\Controllers;

use App\Models\Dhammavachana;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use setasign\Fpdi\Fpdi;

class DhammavachanaController extends Controller
{
    public function index()
    {
        $dhammavachanas = Dhammavachana::latest()->paginate(10);
        return view('dhammavachana.index', compact('dhammavachanas'));
    }

    public function create()
    {
        return view('dhammavachana.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'pages' => 'nullable|integer',
            'language' => 'required|string',
            'pdf_file' => 'required|mimes:pdf|max:20480',
        ]);

        $pdfPath = null;
        $coverPath = null;
        $fileSize = null;
        $pageCount = null;

        if ($request->hasFile('pdf_file')) {
            $pdf = $request->file('pdf_file');
            $pdfPath = $pdf->store('pdfs', 'public');
            $fileSize = round($pdf->getSize() / 1024 / 1024, 2) . ' MB';

            // Extract first page as cover
            try {
                $pdfFullPath = storage_path('app/public/' . $pdfPath);

                // Get page count
                $fpdi = new Fpdi();
                $pageCount = $fpdi->setSourceFile($pdfFullPath);

                // Generate cover image from first page
                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($pdfFullPath . '[0]');
                $imagick->setImageFormat('jpg');
                $imagick->thumbnailImage(300, 400, true);

                $coverFilename = 'covers/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '.jpg';
                $coverFullPath = storage_path('app/public/' . $coverFilename);

                if (!file_exists(dirname($coverFullPath))) {
                    mkdir(dirname($coverFullPath), 0755, true);
                }

                $imagick->writeImage($coverFullPath);
                $imagick->clear();

                $coverPath = $coverFilename;
            } catch (\Exception $e) {
                // If cover generation fails, use placeholder
                $coverPath = null;
            }
        }

        Dhammavachana::create([
            'title' => $request->title,
            'author' => auth()->user()->name ?? 'Admin',
            'description' => $request->description,
            'category' => $request->category,
            'pages' => $pageCount ?? $request->pages,
            'file_size' => $fileSize,
            'language' => $request->language,
            'pdf_file' => $pdfPath,
            'cover_image' => $coverPath,
        ]);

        return redirect()->route('dhammavachana.index')->with('success', 'Dhammavachana berhasil ditambahkan!');
    }

    public function edit(Dhammavachana $dhammavachana)
    {
        return view('dhammavachana.edit', compact('dhammavachana'));
    }

    public function update(Request $request, Dhammavachana $dhammavachana)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string',
            'pages' => 'nullable|integer',
            'language' => 'required|string',
            'pdf_file' => 'nullable|mimes:pdf|max:20480',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'category' => $request->category,
            'pages' => $request->pages,
            'language' => $request->language,
        ];

        if ($request->hasFile('pdf_file')) {
            // Delete old files
            if ($dhammavachana->pdf_file) {
                Storage::disk('public')->delete($dhammavachana->pdf_file);
            }
            if ($dhammavachana->cover_image) {
                Storage::disk('public')->delete($dhammavachana->cover_image);
            }

            $pdf = $request->file('pdf_file');
            $pdfPath = $pdf->store('pdfs', 'public');
            $data['pdf_file'] = $pdfPath;
            $data['file_size'] = round($pdf->getSize() / 1024 / 1024, 2) . ' MB';

            // Extract cover
            try {
                $pdfFullPath = storage_path('app/public/' . $pdfPath);

                $fpdi = new Fpdi();
                $pageCount = $fpdi->setSourceFile($pdfFullPath);
                $data['pages'] = $pageCount;

                $imagick = new \Imagick();
                $imagick->setResolution(150, 150);
                $imagick->readImage($pdfFullPath . '[0]');
                $imagick->setImageFormat('jpg');
                $imagick->thumbnailImage(300, 400, true);

                $coverFilename = 'covers/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '.jpg';
                $coverFullPath = storage_path('app/public/' . $coverFilename);

                if (!file_exists(dirname($coverFullPath))) {
                    mkdir(dirname($coverFullPath), 0755, true);
                }

                $imagick->writeImage($coverFullPath);
                $imagick->clear();

                $data['cover_image'] = $coverFilename;
            } catch (\Exception $e) {
                // Continue without cover
            }
        }

        $dhammavachana->update($data);

        return redirect()->route('dhammavachana.index')->with('success', 'Dhammavachana berhasil diupdate!');
    }

    public function destroy(Dhammavachana $dhammavachana)
    {
        if ($dhammavachana->pdf_file) {
            Storage::disk('public')->delete($dhammavachana->pdf_file);
        }
        if ($dhammavachana->cover_image) {
            Storage::disk('public')->delete($dhammavachana->cover_image);
        }

        $dhammavachana->delete();

        return redirect()->route('dhammavachana.index')->with('success', 'Dhammavachana berhasil dihapus!');
    }
}