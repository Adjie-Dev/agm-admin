<?php

namespace App\Http\Controllers;

use App\Models\PujaPagi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use getID3;

class PujaPagiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pujaPagis = PujaPagi::urut()->get();
        return view('pujapagi.index', compact('pujaPagis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Cari urutan berikutnya yang tersedia
        $nextUrutan = PujaPagi::max('urutan') + 1;

        return view('pujapagi.create', compact('nextUrutan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|unique:puja_pagi,urutan',
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
            $fileName = 'puja_pagi_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/puja-pagi', $fileName, 'public');

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

        PujaPagi::create($data);

        return redirect()
            ->route('puja-pagi.index')
            ->with('success', 'Puja Pagi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(PujaPagi $pujaPagi)
    {
        return view('pujapagi.show', compact('pujaPagi'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PujaPagi $pujaPagi)
    {
        return view('pujapagi.edit', compact('pujaPagi'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PujaPagi $pujaPagi)
    {
        $validated = $request->validate([
            'urutan' => 'required|integer|min:1|unique:puja_pagi,urutan,' . $pujaPagi->id,
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
            if ($pujaPagi->audio_path && Storage::disk('public')->exists($pujaPagi->audio_path)) {
                Storage::disk('public')->delete($pujaPagi->audio_path);
            }

            $audioFile = $request->file('audio');

            $fileName = 'puja_pagi_' . $validated['urutan'] . '_' . time() . '.' . $audioFile->getClientOriginalExtension();
            $path = $audioFile->storeAs('audio/puja-pagi', $fileName, 'public');

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

        $pujaPagi->update($data);

        return redirect()
            ->route('puja-pagi.index')
            ->with('success', 'Puja Pagi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PujaPagi $pujaPagi)
    {
        // Hapus file audio jika ada
        if ($pujaPagi->audio_path && Storage::disk('public')->exists($pujaPagi->audio_path)) {
            Storage::disk('public')->delete($pujaPagi->audio_path);
        }

        $pujaPagi->delete();

        return redirect()
            ->route('puja-pagi.index')
            ->with('success', 'Puja Pagi berhasil dihapus!');
    }
}