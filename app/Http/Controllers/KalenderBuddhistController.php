<?php

namespace App\Http\Controllers;

use App\Models\AcaraBuddhist;
use App\Models\FaseBulan;
use App\Models\AturanUposatha;
use Illuminate\Http\Request;
use Carbon\Carbon;

class KalenderBuddhistController extends Controller
{
    /**
     * Tampilkan kalender Buddhist
     */
    public function index(Request $request)
    {
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->month);

        // Dapatkan tanggal pertama dan terakhir bulan ini
        $tanggalPertama = Carbon::create($tahun, $bulan, 1);
        $tanggalTerakhir = $tanggalPertama->copy()->endOfMonth();

        // Dapatkan fase bulan untuk bulan ini
        $faseBulan = FaseBulan::whereBetween('tanggal', [
            $tanggalPertama->format('Y-m-d'),
            $tanggalTerakhir->format('Y-m-d')
        ])->get()->keyBy('tanggal');

        // Dapatkan acara Buddhist untuk bulan ini
        $acaraBuddhist = AcaraBuddhist::aktif()
        ->whereBetween('tanggal', [
            $tanggalPertama->format('Y-m-d'),
            $tanggalTerakhir->format('Y-m-d')
        ])
        ->get()
        ->keyBy(function($item) {
            return $item->tanggal->format('Y-m-d');
        });

        // Dapatkan aturan Uposatha aktif
        $aturanUposatha = AturanUposatha::aktif()->get()->keyBy('fase_bulan');

            return view('kalender-buddhist.index', compact(
            'tahun',
            'bulan',
            'tanggalPertama',
            'faseBulan',
            'acaraBuddhist',
            'aturanUposatha'
        ));
    }

    /**
     * Tampilkan form tambah acara
     */
    public function create()
    {
        return view('kalender-buddhist.create');
    }

    /**
     * Simpan acara baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tipe_acara' => 'required|in:uposatha,waisak,magha_puja,asalha_puja,kathina,vassa_mulai,vassa_selesai,pavarana,custom',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'warna' => 'required|string|max:30',
            'berulang' => 'boolean',
        ]);

        $validated['tahun'] = Carbon::parse($validated['tanggal'])->year;
        $validated['aktif'] = true;

        AcaraBuddhist::create($validated);

        return redirect()->route('kalender-buddhist.index')
            ->with('success', 'Acara berhasil ditambahkan!');
    }

    /**
     * Tampilkan form edit acara
     */
    public function edit(AcaraBuddhist $acaraBuddhist)
    {
        return view('kalender-buddhist.edit', compact('acaraBuddhist'));
    }

    /**
     * Update acara
     */
    public function update(Request $request, AcaraBuddhist $acaraBuddhist)
    {
        $validated = $request->validate([
            'tipe_acara' => 'required|in:uposatha,waisak,magha_puja,asalha_puja,kathina,vassa_mulai,vassa_selesai,pavarana,custom',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tanggal' => 'required|date',
            'waktu_mulai' => 'nullable|date_format:H:i',
            'waktu_selesai' => 'nullable|date_format:H:i',
            'warna' => 'required|string|max:30',
            'berulang' => 'boolean',
            'aktif' => 'boolean',
        ]);

        $validated['tahun'] = Carbon::parse($validated['tanggal'])->year;

        $acaraBuddhist->update($validated);

        return redirect()->route('kalender-buddhist.index')
            ->with('success', 'Acara berhasil diupdate!');
    }

    /**
     * Hapus acara
     */
    public function destroy(AcaraBuddhist $acaraBuddhist)
    {
        $acaraBuddhist->delete();

        return redirect()->route('kalender-buddhist.index')
            ->with('success', 'Acara berhasil dihapus!');
    }

    /**
     * Toggle status aktif acara
     */
    public function toggleAktif(AcaraBuddhist $acaraBuddhist)
    {
        $acaraBuddhist->update([
            'aktif' => !$acaraBuddhist->aktif
        ]);

        return back()->with('success', 'Status acara berhasil diubah!');
    }
}