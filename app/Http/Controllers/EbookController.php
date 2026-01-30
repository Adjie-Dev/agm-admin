<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Smalot\PdfParser\Parser;

class EbookController extends Controller
{
    /**
     * Generate thumbnail dari PDF menggunakan Ghostscript
     */
    private function generatePdfThumbnail($pdfPath)
    {
        try {
            $fullPdfPath = storage_path('app/public/' . $pdfPath);
            $thumbnailName = 'covers/' . pathinfo($pdfPath, PATHINFO_FILENAME) . '_thumb.jpg';
            $fullThumbnailPath = storage_path('app/public/' . $thumbnailName);

            // Buat folder covers jika belum ada
            if (!file_exists(dirname($fullThumbnailPath))) {
                mkdir(dirname($fullThumbnailPath), 0755, true);
            }

            // Ambil path Ghostscript dari .env
            $gsPath = env('GHOSTSCRIPT_PATH', 'gswin64c');

            // Command untuk generate thumbnail dengan aspect ratio preserved
            $command = sprintf(
                '"%s" -dSAFER -dBATCH -dNOPAUSE -sDEVICE=jpeg -dFirstPage=1 -dLastPage=1 -dJPEGQ=95 -dPDFFitPage -dFIXEDMEDIA -dDEVICEWIDTHPOINTS=595 -dDEVICEHEIGHTPOINTS=842 -r150 -sOutputFile="%s" "%s" 2>&1',
                $gsPath,
                $fullThumbnailPath,
                $fullPdfPath
            );

            exec($command, $output, $returnCode);

            // Cek apakah thumbnail berhasil dibuat
            if ($returnCode === 0 && file_exists($fullThumbnailPath)) {
                return $thumbnailName;
            }

            return null;

        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ebooks = Ebook::with('uploader')
            ->latest()
            ->paginate(10);

        return view('ebooks.index', compact('ebooks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('ebooks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'pdf_file' => 'required|file|mimes:pdf|max:51200', // Max 50MB
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            // Upload PDF file
            $pdfFile = $request->file('pdf_file');
            $pdfPath = $pdfFile->store('ebooks', 'public');

            // Dapatkan path lengkap file untuk parsing
            $fullPath = storage_path('app/public/' . $pdfPath);

            // Parse PDF untuk mendapatkan informasi
            $parser = new Parser();
            $pdf = $parser->parseFile($fullPath);

            // Ambil judul dari PDF jika tidak diisi manual
            $title = $request->title;
            if (empty($title)) {
                $details = $pdf->getDetails();
                $title = $details['Title'] ?? 'Untitled';

                // Jika title masih kosong, gunakan nama file
                if (empty($title) || $title === 'Untitled') {
                    $title = pathinfo($pdfFile->getClientOriginalName(), PATHINFO_FILENAME);
                }
            }

            // Hitung jumlah halaman
            $pageCount = count($pdf->getPages());

            // Generate thumbnail dari halaman pertama PDF
            $coverImage = $this->generatePdfThumbnail($pdfPath);

            // Simpan data ke database
            $ebook = Ebook::create([
                'title' => $title,
                'description' => $request->description,
                'pdf_file' => $pdfPath,
                'cover_image' => $coverImage,
                'page_count' => $pageCount,
                'uploader_id' => Auth::id(),
            ]);

            return redirect()
                ->route('ebooks.index')
                ->with('success', 'E-Book berhasil ditambahkan!');

        } catch (\Exception $e) {
            // Jika terjadi error, hapus file yang sudah diupload
            if (isset($pdfPath) && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal mengupload e-book: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Ebook $ebook)
    {
        return view('ebooks.show', compact('ebook'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ebook $ebook)
    {
        return view('ebooks.edit', compact('ebook'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ebook $ebook)
    {
        // Validasi input
        $request->validate([
            'pdf_file' => 'nullable|file|mimes:pdf|max:51200', // Max 50MB
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $data = [
                'title' => $request->title,
                'description' => $request->description,
            ];

            // Jika ada file PDF baru
            if ($request->hasFile('pdf_file')) {
                // Upload PDF baru
                $pdfFile = $request->file('pdf_file');
                $pdfPath = $pdfFile->store('ebooks', 'public');

                // Dapatkan path lengkap file untuk parsing
                $fullPath = storage_path('app/public/' . $pdfPath);

                // Parse PDF untuk mendapatkan jumlah halaman
                $parser = new Parser();
                $pdf = $parser->parseFile($fullPath);
                $pageCount = count($pdf->getPages());

                // Generate thumbnail dari halaman pertama PDF
                $coverImage = $this->generatePdfThumbnail($pdfPath);

                // Hapus file lama
                if ($ebook->pdf_file && Storage::disk('public')->exists($ebook->pdf_file)) {
                    Storage::disk('public')->delete($ebook->pdf_file);
                }

                // Hapus cover lama jika ada
                if ($ebook->cover_image && Storage::disk('public')->exists($ebook->cover_image)) {
                    Storage::disk('public')->delete($ebook->cover_image);
                }

                // Update data dengan file baru
                $data['pdf_file'] = $pdfPath;
                $data['cover_image'] = $coverImage;
                $data['page_count'] = $pageCount;
            }

            // Update database
            $ebook->update($data);

            return redirect()
                ->route('ebooks.index')
                ->with('success', 'E-Book berhasil diperbarui!');

        } catch (\Exception $e) {
            // Jika terjadi error dan ada file baru yang diupload, hapus file tersebut
            if (isset($pdfPath) && Storage::disk('public')->exists($pdfPath)) {
                Storage::disk('public')->delete($pdfPath);
            }

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal memperbarui e-book: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ebook $ebook)
    {
        try {
            // Hapus file PDF dari storage
            if ($ebook->pdf_file && Storage::disk('public')->exists($ebook->pdf_file)) {
                Storage::disk('public')->delete($ebook->pdf_file);
            }

            // Hapus cover image dari storage
            if ($ebook->cover_image && Storage::disk('public')->exists($ebook->cover_image)) {
                Storage::disk('public')->delete($ebook->cover_image);
            }

            // Hapus data dari database
            $ebook->delete();

            return redirect()
                ->route('ebooks.index')
                ->with('success', 'E-Book berhasil dihapus!');

        } catch (\Exception $e) {
            return redirect()
                ->route('ebooks.index')
                ->with('error', 'Gagal menghapus e-book: ' . $e->getMessage());
        }
    }
}