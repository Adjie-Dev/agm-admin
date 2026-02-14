<?php

namespace App\Http\Controllers;

use App\Models\AcaraBuddhist;
use App\Models\FaseBulan;
use App\Models\AturanUposatha;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class KalenderBuddhistController extends Controller
{
    /**
     * Tampilkan kalender Buddhist
     */
    public function index(Request $request)
    {
        try {
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

            // Dapatkan semua acara untuk tahun ini (untuk yearly view)
            $tahunStart = Carbon::create($tahun, 1, 1);
            $tahunEnd = Carbon::create($tahun, 12, 31);

            $acaraBuddhistYear = AcaraBuddhist::aktif()
                ->whereBetween('tanggal', [
                    $tahunStart->format('Y-m-d'),
                    $tahunEnd->format('Y-m-d')
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
                'aturanUposatha',
                'acaraBuddhistYear'
            ));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memuat kalender: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form tambah acara
     */
    public function create(Request $request)
    {
        try {
            $tahun = $request->get('tahun');
            $bulan = $request->get('bulan');

            // Kalau ada parameter, set default tanggal ke tanggal 1 bulan tersebut
            $defaultTanggal = null;
            if ($tahun && $bulan) {
                $defaultTanggal = Carbon::create($tahun, $bulan, 1)->format('Y-m-d');
            }

            return view('kalender-buddhist.create', compact('defaultTanggal'));
        } catch (Exception $e) {
            return redirect()->route('kalender-buddhist.index')
                ->with('error', 'Terjadi kesalahan saat membuka form tambah acara.');
        }
    }

    /**
     * Simpan acara baru
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'tipe_acara' => 'required|in:uposatha,waisak,magha_puja,asalha_puja,kathina,vassa_mulai,vassa_selesai,pavarana,custom',
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal' => 'required|date',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
                'warna' => 'required|string|max:30',
                'berulang' => 'boolean',
            ], [
                'tipe_acara.required' => 'Tipe acara harus dipilih.',
                'tipe_acara.in' => 'Tipe acara tidak valid.',
                'nama.required' => 'Nama acara harus diisi.',
                'nama.max' => 'Nama acara maksimal 255 karakter.',
                'tanggal.required' => 'Tanggal acara harus dipilih.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'waktu_mulai.date_format' => 'Format waktu mulai harus HH:MM.',
                'waktu_selesai.date_format' => 'Format waktu selesai harus HH:MM.',
                'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
                'warna.required' => 'Warna acara harus dipilih.',
            ]);

            $validated['tahun'] = Carbon::parse($validated['tanggal'])->year;
            $validated['aktif'] = true;

            AcaraBuddhist::create($validated);

            return redirect()->route('kalender-buddhist.index')
                ->with('success', 'Acara "' . $validated['nama'] . '" berhasil ditambahkan!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang diinput.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat menyimpan acara: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan form edit acara
     */
    public function edit(AcaraBuddhist $acaraBuddhist)
    {
        try {
            return view('kalender-buddhist.edit', compact('acaraBuddhist'));
        } catch (Exception $e) {
            return redirect()->route('kalender-buddhist.index')
                ->with('error', 'Terjadi kesalahan saat membuka form edit acara.');
        }
    }

    /**
     * Update acara
     */
    public function update(Request $request, AcaraBuddhist $acaraBuddhist)
    {
        try {
            $validated = $request->validate([
                'tipe_acara' => 'required|in:uposatha,waisak,magha_puja,asalha_puja,kathina,vassa_mulai,vassa_selesai,pavarana,custom',
                'nama' => 'required|string|max:255',
                'deskripsi' => 'nullable|string',
                'tanggal' => 'required|date',
                'waktu_mulai' => 'nullable|date_format:H:i',
                'waktu_selesai' => 'nullable|date_format:H:i|after:waktu_mulai',
                'warna' => 'required|string|max:30',
                'berulang' => 'boolean',
                'aktif' => 'boolean',
            ], [
                'tipe_acara.required' => 'Tipe acara harus dipilih.',
                'tipe_acara.in' => 'Tipe acara tidak valid.',
                'nama.required' => 'Nama acara harus diisi.',
                'nama.max' => 'Nama acara maksimal 255 karakter.',
                'tanggal.required' => 'Tanggal acara harus dipilih.',
                'tanggal.date' => 'Format tanggal tidak valid.',
                'waktu_mulai.date_format' => 'Format waktu mulai harus HH:MM.',
                'waktu_selesai.date_format' => 'Format waktu selesai harus HH:MM.',
                'waktu_selesai.after' => 'Waktu selesai harus setelah waktu mulai.',
                'warna.required' => 'Warna acara harus dipilih.',
            ]);

            $validated['tahun'] = Carbon::parse($validated['tanggal'])->year;

            $acaraBuddhist->update($validated);

            return redirect()->route('kalender-buddhist.index')
                ->with('success', 'Acara "' . $validated['nama'] . '" berhasil diperbarui!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput()
                ->with('error', 'Validasi gagal. Periksa kembali data yang diinput.');
        } catch (Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan saat memperbarui acara: ' . $e->getMessage());
        }
    }

    /**
     * Hapus acara
     */
    public function destroy(AcaraBuddhist $acaraBuddhist)
    {
        try {
            $namaAcara = $acaraBuddhist->nama;
            $acaraBuddhist->delete();

            return redirect()->route('kalender-buddhist.index')
                ->with('success', 'Acara "' . $namaAcara . '" berhasil dihapus!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus acara: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status aktif acara
     */
    public function toggleAktif(AcaraBuddhist $acaraBuddhist)
    {
        try {
            $statusBaru = !$acaraBuddhist->aktif;

            $acaraBuddhist->update([
                'aktif' => $statusBaru
            ]);

            $statusText = $statusBaru ? 'diaktifkan' : 'dinonaktifkan';

            return back()->with('success', 'Acara "' . $acaraBuddhist->nama . '" berhasil ' . $statusText . '!');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengubah status acara: ' . $e->getMessage());
        }
    }

    /**
     * API endpoint - Dapatkan events untuk bulan tertentu (JSON)
     */
    public function getEventsJson(Request $request)
    {
        try {
            $tahun = $request->get('tahun', now()->year);
            $bulan = $request->get('bulan', now()->month);

            // Validasi sederhana
            $tahun = max(2000, min(2100, (int)$tahun));
            $bulan = max(1, min(12, (int)$bulan));

            $tanggalPertama = Carbon::create($tahun, $bulan, 1);
            $tanggalTerakhir = $tanggalPertama->copy()->endOfMonth();

            $acaraBuddhist = AcaraBuddhist::aktif()
                ->whereBetween('tanggal', [
                    $tanggalPertama->format('Y-m-d'),
                    $tanggalTerakhir->format('Y-m-d')
                ])
                ->get();

            $eventsForJs = [];
            foreach ($acaraBuddhist as $acara) {
                $tanggalKey = $acara->tanggal instanceof Carbon
                    ? $acara->tanggal->format('Y-m-d')
                    : (string)$acara->tanggal;

                $eventsForJs[$tanggalKey] = [
                    'nama' => $acara->nama,
                    'deskripsi' => $acara->deskripsi ?? '',
                    'waktu_mulai' => $acara->waktu_mulai ?? '',
                    'waktu_selesai' => $acara->waktu_selesai ?? '',
                    'warna' => $acara->warna
                ];
            }

            return response()->json($eventsForJs);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat mengambil data events.',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Batch delete - Hapus beberapa acara sekaligus
     */
    public function batchDelete(Request $request)
    {
        try {
            $validated = $request->validate([
                'acara_ids' => 'required|array|min:1',
                'acara_ids.*' => 'required|exists:acara_buddhist,id'
            ], [
                'acara_ids.required' => 'Tidak ada acara yang dipilih.',
                'acara_ids.min' => 'Pilih minimal 1 acara untuk dihapus.',
                'acara_ids.*.exists' => 'Beberapa acara tidak ditemukan.',
            ]);

            $jumlahDihapus = AcaraBuddhist::whereIn('id', $validated['acara_ids'])->delete();

            return redirect()->route('kalender-buddhist.index')
                ->with('success', $jumlahDihapus . ' acara berhasil dihapus!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()
                ->with('error', 'Validasi gagal: ' . implode(', ', $e->errors()['acara_ids'] ?? ['Error tidak diketahui']));
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat menghapus acara: ' . $e->getMessage());
        }
    }

    /**
     * Export acara ke format tertentu (opsional - untuk fitur masa depan)
     */
    public function export(Request $request)
    {
        try {
            $format = $request->get('format', 'json');
            $tahun = $request->get('tahun', now()->year);

            $acara = AcaraBuddhist::whereYear('tanggal', $tahun)
                ->orderBy('tanggal')
                ->get();

            if ($format === 'json') {
                return response()->json($acara);
            }

            // Format lain bisa ditambahkan di sini (CSV, PDF, dll)

            return redirect()->back()
                ->with('info', 'Format export yang diminta belum tersedia.');
        } catch (Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat export acara: ' . $e->getMessage());
        }
    }
}
