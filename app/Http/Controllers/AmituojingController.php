<?php

namespace App\Http\Controllers;

use App\Models\Amituojing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;

class AmituojingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $amituojings = Amituojing::urut()->get();
        return view('amituojing.index', compact('amituojings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari urutan berikutnya yang tersedia
        $nextUrutan = Amituojing::max('urutan') + 1;
        if ($nextUrutan > 17) {
            $nextUrutan = null; // Sudah penuh
        }

        return view('amituojing.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:amituojing,urutan',
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg|max:51200', // Max 50MB
            'teks_pali' => 'nullable|string',
            'terjemahan' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $data = [
            'urutan' => $validated['urutan'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'teks_pali' => $validated['teks_pali'] ?? null,
            'terjemahan' => $validated['terjemahan'] ?? null,
            'aktif' => $request->has('aktif') ? true : false,
        ];

        // Handle audio upload
        if ($request->hasFile('audio')) {
            $audioFile = $request->file('audio');

            // Generate nama file
            $fileName = 'amituojing_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/amituojing', $fileName, 'public');

            $data['audio_path'] = $path;
            $data['audio_nama_asli'] = $audioFile->getClientOriginalName();
            $data['audio_mime'] = $audioFile->getMimeType();
            $data['audio_ukuran_kb'] = round($audioFile->getSize() / 1024);

            // Get durasi menggunakan getID3 (jika library tersedia)
            try {
                $getID3 = new getID3();
                $fileInfo = $getID3->analyze(storage_path('app/public/' . $path));
                if (isset($fileInfo['playtime_string'])) {
                    $data['durasi'] = $fileInfo['playtime_string'];
                }
            } catch (\Exception $e) {
                // Jika gagal, biarkan durasi kosong
            }
        }

        Amituojing::create($data);

        return redirect()
            ->route('amituojing.index')
            ->with('success', 'Amituojing berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Amituojing $amituojing)
    {
        return view('amituojing.show', compact('amituojing'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Amituojing $amituojing)
    {
        return view('amituojing.edit', compact('amituojing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Amituojing $amituojing)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:amituojing,urutan,' . $amituojing->id,
            'judul' => 'required|string|max:150',
            'deskripsi' => 'nullable|string',
            'audio' => 'nullable|file|mimes:mp3,wav,ogg|max:51200',
            'teks_pali' => 'nullable|string',
            'terjemahan' => 'nullable|string',
            'aktif' => 'boolean',
        ]);

        $data = [
            'urutan' => $validated['urutan'],
            'judul' => $validated['judul'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'teks_pali' => $validated['teks_pali'] ?? null,
            'terjemahan' => $validated['terjemahan'] ?? null,
            'aktif' => $request->has('aktif') ? true : false,
        ];

        // Handle audio upload
        if ($request->hasFile('audio')) {
            // Hapus audio lama
            if ($amituojing->audio_path && Storage::disk('public')->exists($amituojing->audio_path)) {
                Storage::disk('public')->delete($amituojing->audio_path);
            }

            $audioFile = $request->file('audio');

            $fileName = 'amituojing_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/amituojing', $fileName, 'public');

            $data['audio_path'] = $path;
            $data['audio_nama_asli'] = $audioFile->getClientOriginalName();
            $data['audio_mime'] = $audioFile->getMimeType();
            $data['audio_ukuran_kb'] = round($audioFile->getSize() / 1024);

            try {
                $getID3 = new getID3();
                $fileInfo = $getID3->analyze(storage_path('app/public/' . $path));
                if (isset($fileInfo['playtime_string'])) {
                    $data['durasi'] = $fileInfo['playtime_string'];
                }
            } catch (\Exception $e) {
                // Jika gagal, biarkan durasi kosong
            }
        }

        $amituojing->update($data);

        return redirect()
            ->route('amituojing.index')
            ->with('success', 'Amituojing berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Amituojing $amituojing)
    {
        // Hapus file audio jika ada
        if ($amituojing->audio_path && Storage::disk('public')->exists($amituojing->audio_path)) {
            Storage::disk('public')->delete($amituojing->audio_path);
        }

        $amituojing->delete();

        return redirect()
            ->route('amituojing.index')
            ->with('success', 'Amituojing berhasil dihapus!');
    }
}
