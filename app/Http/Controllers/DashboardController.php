<?php

namespace App\Http\Controllers;

use App\Models\Ebook;
use App\Models\Dhammavachana;
use App\Models\Article;
use App\Models\AcaraBuddhist;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil tahun dan bulan dari request, default ke sekarang
        $tahun = $request->get('tahun', now()->year);
        $bulan = $request->get('bulan', now()->month);

        // Buat tanggal pertama di bulan ini
        $tanggalPertama = Carbon::create($tahun, $bulan, 1);

        // Hitung total data
        $totalEbooks = Ebook::count();
        $totalDhammavachana = Dhammavachana::count();
        $totalArticles = Article::count();
        $totalAcara = AcaraBuddhist::count();

        // Ambil acara di bulan ini untuk kalender - FORMAT KEYBY BERDASARKAN TANGGAL
        $acaraBuddhist = AcaraBuddhist::select('tanggal', 'nama', 'nama_acara', 'deskripsi', 'warna', 'waktu_mulai', 'waktu_selesai')
            ->whereYear('tanggal', $tahun)
            ->whereMonth('tanggal', $bulan)
            ->get()
            ->keyBy(function($item) {
                return $item->tanggal instanceof \Carbon\Carbon
                    ? $item->tanggal->format('Y-m-d')
                    : (string)$item->tanggal;
            });

        // Ambil artikel terbaru (opsional, jika diperlukan)
        $recentArticles = Article::orderBy('created_at', 'desc')
            ->limit(5)
            ->get(['id', 'title', 'slug', 'created_at']);

        // Ambil acara mendatang (opsional, jika diperlukan)
        $upcomingEvents = AcaraBuddhist::where('tanggal', '>=', now())
            ->orderBy('tanggal', 'asc')
            ->limit(3)
            ->get(['id', 'nama_acara', 'tanggal', 'warna']);

        return view('dashboard', compact(
            'totalEbooks',
            'totalDhammavachana',
            'totalArticles',
            'totalAcara',
            'tahun',
            'bulan',
            'tanggalPertama',
            'acaraBuddhist',
            'recentArticles',
            'upcomingEvents'
        ));
    }
}
