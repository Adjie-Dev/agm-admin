<?php

namespace App\Http\Controllers;

use App\Models\Dhammavachana;
use Illuminate\Http\Request;
use setasign\Fpdi\Fpdi;

class DhammavachanaController extends Controller
{
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'required|file|mimes:pdf|max:10240',
        ]);

        // Upload PDF
        $pdfPath = $request->file('pdf_file')->store('dhammavachana', 'public');
        $pdfFullPath = storage_path('app/public/' . $pdfPath);

        // Get page count
        $pageCount = 0;
        $coverFilename = null;

        try {
            $fpdi = new Fpdi();
            $pageCount = $fpdi->setSourceFile($pdfFullPath);

            // Generate cover menggunakan Ghostscript (jika tersedia)
            $coverFilename = $this->generateCoverWithGhostscript($pdfPath, $pdfFullPath);

        } catch (\Exception $e) {
            \Log::error('PDF processing error: ' . $e->getMessage());
            // Lanjutkan tanpa cover
        }

        // Save to database
        Dhammavachana::create([
            'title' => $request->title,
            'description' => $request->description,
            'pdf_path' => $pdfPath,
            'cover_image' => $coverFilename,
            'page_count' => $pageCount,
            'uploaded_by' => auth()->id(),
            'author' => $request->author ?? 'Unknown',
            'category' => $request->category ?? 'umum',
            'language' => $request->language ?? 'Indonesia',
            'pages' => $request->pages ?? 0,
        ]);

        return redirect()->route('dhammavachana.index')
            ->with('success', 'Dhammavachana berhasil diupload');
    }

    private function generateCoverWithGhostscript($pdfPath, $pdfFullPath)
    {
        $coverFilename = 'covers/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '.jpg';
        $coverFullPath = storage_path('app/public/' . $coverFilename);

        if (!file_exists(dirname($coverFullPath))) {
            mkdir(dirname($coverFullPath), 0755, true);
        }

        // Cek apakah Ghostscript tersedia
        $gsCommand = stripos(PHP_OS, 'WIN') === 0 ? 'gswin64c' : 'gs';

        exec("$gsCommand -version 2>&1", $output, $returnCode);

        if ($returnCode === 0) {
            // Ghostscript tersedia, generate cover
            $command = "$gsCommand -dNOPAUSE -sDEVICE=jpeg -dFirstPage=1 -dLastPage=1 -sOutputFile=\"$coverFullPath\" -r150 -dBATCH -q \"$pdfFullPath\"";
            exec($command, $output, $returnCode);

            if ($returnCode === 0 && file_exists($coverFullPath)) {
                return $coverFilename;
            }
        }

        // Jika Ghostscript tidak tersedia, return null (gunakan default cover)
        return null;
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'pdf_file' => 'nullable|file|mimes:pdf|max:10240',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
        ];

        // Jika ada file PDF baru
        if ($request->hasFile('pdf_file')) {
            // Hapus file lama
            if ($dhammavachana->pdf_path) {
                \Storage::disk('public')->delete($dhammavachana->pdf_path);
            }
            if ($dhammavachana->cover_image) {
                \Storage::disk('public')->delete($dhammavachana->cover_image);
            }

            // Upload file baru
            $pdfPath = $request->file('pdf_file')->store('dhammavachana', 'public');
            $pdfFullPath = storage_path('app/public/' . $pdfPath);

            try {
                $fpdi = new Fpdi();
                $pageCount = $fpdi->setSourceFile($pdfFullPath);
                $coverFilename = $this->generateCoverWithGhostscript($pdfPath, $pdfFullPath);

                $data['pdf_path'] = $pdfPath;
                $data['cover_image'] = $coverFilename;
                $data['page_count'] = $pageCount;
            } catch (\Exception $e) {
                \Log::error('PDF processing error: ' . $e->getMessage());
            }
        }

        $dhammavachana->update($data);

        return redirect()->route('dhammavachana.index')
            ->with('success', 'Dhammavachana berhasil diupdate');
    }

    public function destroy(Dhammavachana $dhammavachana)
    {
        // Hapus file
        if ($dhammavachana->pdf_path) {
            \Storage::disk('public')->delete($dhammavachana->pdf_path);
        }
        if ($dhammavachana->cover_image) {
            \Storage::disk('public')->delete($dhammavachana->cover_image);
        }

        $dhammavachana->delete();

        return redirect()->route('dhammavachana.index')
            ->with('success', 'Dhammavachana berhasil dihapus');
    }
}
