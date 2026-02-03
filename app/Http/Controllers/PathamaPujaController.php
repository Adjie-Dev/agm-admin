<?php

namespace App\Http\Controllers;

use App\Models\PathamaPuja;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;

class PathamaPujaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pathamaPujas = PathamaPuja::urut()->get();
        return view('pathamapuja.index', compact('pathamaPujas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari urutan berikutnya yang tersedia
        $nextUrutan = PathamaPuja::max('urutan') + 1;
        if ($nextUrutan > 17) {
            $nextUrutan = null; // Sudah penuh
        }

        return view('pathamapuja.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:pathama_puja,urutan',
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
            $fileName = 'pathama_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/pathama', $fileName, 'public');

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

        PathamaPuja::create($data);

        return redirect()
            ->route('pathama-puja.index')
            ->with('success', 'Pathama Puja berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PathamaPuja $pathamaPuja)
    {
        return view('pathamapuja.show', compact('pathamaPuja'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PathamaPuja $pathamaPuja)
    {
        return view('pathamapuja.edit', compact('pathamaPuja'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PathamaPuja $pathamaPuja)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|max:17|unique:pathama_puja,urutan,' . $pathamaPuja->id,
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
            if ($pathamaPuja->audio_path && Storage::disk('public')->exists($pathamaPuja->audio_path)) {
                Storage::disk('public')->delete($pathamaPuja->audio_path);
            }

            $audioFile = $request->file('audio');

            $fileName = 'pathama_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/pathama', $fileName, 'public');

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

        $pathamaPuja->update($data);

        return redirect()
            ->route('pathama-puja.index')
            ->with('success', 'Pathama Puja berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PathamaPuja $pathamaPuja)
    {
        // Hapus file audio jika ada
        if ($pathamaPuja->audio_path && Storage::disk('public')->exists($pathamaPuja->audio_path)) {
            Storage::disk('public')->delete($pathamaPuja->audio_path);
        }

        $pathamaPuja->delete();

        return redirect()
            ->route('pathama-puja.index')
            ->with('success', 'Pathama Puja berhasil dihapus!');
    }
}
