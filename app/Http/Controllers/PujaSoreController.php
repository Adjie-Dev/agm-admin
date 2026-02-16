<?php

namespace App\Http\Controllers;

use App\Models\PujaSore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;

class PujaSoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pujaSores = PujaSore::urut()->get();
        return view('pujasore.index', compact('pujaSores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari urutan berikutnya yang tersedia
        $nextUrutan = PujaSore::max('urutan') + 1;
        if ($nextUrutan > 17) {
            $nextUrutan = null; // Sudah penuh
        }

        return view('pujasore.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:puja_sore,urutan',
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
            $fileName = 'pujasore_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/pujasore', $fileName, 'public');

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

        PujaSore::create($data);

        return redirect()
            ->route('puja-sore.index')
            ->with('success', 'Puja Sore berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PujaSore $pujaSore)
    {
        return view('pujasore.show', compact('pujaSore'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PujaSore $pujaSore)
    {
        return view('pujasore.edit', compact('pujaSore'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PujaSore $pujaSore)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:puja_sore,urutan,' . $pujaSore->id,
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
            if ($pujaSore->audio_path && Storage::disk('public')->exists($pujaSore->audio_path)) {
                Storage::disk('public')->delete($pujaSore->audio_path);
            }

            $audioFile = $request->file('audio');

            $fileName = 'pujasore_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/pujasore', $fileName, 'public');

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

        $pujaSore->update($data);

        return redirect()
            ->route('puja-sore.index')
            ->with('success', 'Puja Sore berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PujaSore $pujaSore)
    {
        // Hapus file audio jika ada
        if ($pujaSore->audio_path && Storage::disk('public')->exists($pujaSore->audio_path)) {
            Storage::disk('public')->delete($pujaSore->audio_path);
        }

        $pujaSore->delete();

        return redirect()
            ->route('puja-sore.index')
            ->with('success', 'Puja Sore berhasil dihapus!');
    }
}