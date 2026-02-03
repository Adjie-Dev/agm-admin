<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Dhammavachana;
use App\Models\AcaraBuddhist;
use App\Models\FaseBulan;
use App\Models\Article; // ⭐ TAMBAHKAN INI - Sesuai model Article
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ⭐ STATISTIK - TAMBAHKAN ARTIKEL
        $totalEbooks = Ebook::count();
        $totalDhammavachana = Dhammavachana::count();
        $totalAcara = AcaraBuddhist::count();
        $totalArticles = Article::count(); // ⭐ TAMBAHKAN INI

        // ⭐ AMBIL 5 ARTIKEL TERBARU
        $recentArticles = Article::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Kalender
        $tahun = $request->input('tahun', now()->year);
        $bulan = $request->input('bulan', now()->month);

        $tanggalPertama = Carbon::createFromDate($tahun, $bulan, 1);

        // Ambil fase bulan untuk bulan ini
        $faseBulan = FaseBulan::whereBetween('tanggal', [
            $tanggalPertama->copy()->startOfMonth(),
            $tanggalPertama->copy()->endOfMonth()
        ])->get()->keyBy(function($item) {
            return $item->tanggal->format('Y-m-d');
        });

        // Ambil acara Buddhist untuk bulan ini
        $acaraBuddhist = AcaraBuddhist::whereBetween('tanggal', [
            $tanggalPertama->copy()->startOfMonth(),
            $tanggalPertama->copy()->endOfMonth()
        ])->get()->keyBy(function($item) {
            return $item->tanggal->format('Y-m-d');
        });

        // Aturan Uposatha
        $aturanUposatha = collect([
            'bulan_baru' => (object)[
                'nama_acara' => 'Uposatha',
                'warna' => '#06b6d4'
            ],
            'purnama' => (object)[
                'nama_acara' => 'Uposatha',
                'warna' => '#06b6d4'
            ]
        ]);

        // Acara mendatang (3 acara terdekat)
        $acaraMendatang = AcaraBuddhist::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->limit(3)
            ->get();

        return view('dashboard', compact(
            'totalEbooks',
            'totalDhammavachana',
            'totalAcara',
            'totalArticles',
            'recentArticles',
            'tahun',
            'bulan',
            'tanggalPertama',
            'faseBulan',
            'acaraBuddhist',
            'aturanUposatha',
            'acaraMendatang'
        ));
    }
}
