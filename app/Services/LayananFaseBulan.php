<?php

namespace App\Services;

use Solaris\MoonPhase;
use Carbon\Carbon;

class LayananFaseBulan
{
    /**
     * Generate fase bulan untuk rentang tahun
     *
     * @param int $tahunMulai
     * @param int $tahunSelesai
     * @return array
     */
    public function generateFaseUntukRentangTahun(int $tahunMulai, int $tahunSelesai): array
    {
        $semuaFase = [];

        for ($tahun = $tahunMulai; $tahun <= $tahunSelesai; $tahun++) {
            $fasePerTahun = $this->generateFaseUntukTahun($tahun);
            $semuaFase = array_merge($semuaFase, $fasePerTahun);
        }

        return $semuaFase;
    }

    /**
     * Generate fase bulan untuk tahun tertentu
     *
     * @param int $tahun
     * @return array
     */
    public function generateFaseUntukTahun(int $tahun): array
    {
        $semuaFase = [];
        $tanggalMulai = Carbon::create($tahun, 1, 1);
        $tanggalSelesai = Carbon::create($tahun, 12, 31);

        // Loop setiap hari dalam tahun
        for ($tanggal = $tanggalMulai->copy(); $tanggal->lte($tanggalSelesai); $tanggal->addDay()) {
            $faseBulan = new MoonPhase($tanggal->timestamp);

            // Dapatkan fase (0 = Bulan Baru, 0.5 = Purnama)
            $fase = $faseBulan->phase();
            $iluminasi = $faseBulan->illumination() * 100;

            // Tentukan kategori fase bulan
            $kategoriFase = $this->tentukanKategoriFase($fase);

            // Hanya simpan fase utama (Bulan Baru, Paruh Pertama, Purnama, Paruh Akhir)
            if ($kategoriFase !== null) {
                $semuaFase[] = [
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'fase' => $kategoriFase,
                    'iluminasi' => round($iluminasi, 2),
                    'hari_lunar' => $this->hitungHariLunar($fase),
                ];
            }
        }

        return $semuaFase;
    }

    /**
     * Tentukan kategori fase bulan berdasarkan nilai fase
     *
     * @param float $fase
     * @return string|null
     */
    private function tentukanKategoriFase(float $fase): ?string
    {
        // Rentang fase (dengan toleransi)
        // 0 atau 1 = Bulan Baru
        // 0.25 = Paruh Pertama
        // 0.5 = Purnama
        // 0.75 = Paruh Akhir

        $toleransi = 0.03;

        if ($fase < $toleransi || $fase > (1 - $toleransi)) {
            return 'bulan_baru';
        } elseif (abs($fase - 0.25) < $toleransi) {
            return 'paruh_pertama';
        } elseif (abs($fase - 0.5) < $toleransi) {
            return 'purnama';
        } elseif (abs($fase - 0.75) < $toleransi) {
            return 'paruh_akhir';
        }

        return null; // Bukan fase utama
    }

    /**
     * Hitung hari lunar (1-30) berdasarkan fase
     *
     * @param float $fase
     * @return int
     */
    private function hitungHariLunar(float $fase): int
    {
        // Bulan lunar sekitar 29.53 hari
        $hariLunar = round($fase * 29.53);

        return $hariLunar == 0 ? 1 : $hariLunar;
    }

    /**
     * Dapatkan fase bulan untuk tanggal tertentu
     *
     * @param Carbon $tanggal
     * @return array
     */
    public function dapatkanFaseUntukTanggal(Carbon $tanggal): array
    {
        $faseBulan = new MoonPhase($tanggal->timestamp);
        $fase = $faseBulan->phase();
        $iluminasi = $faseBulan->illumination() * 100;

        return [
            'tanggal' => $tanggal->format('Y-m-d'),
            'fase' => $this->tentukanKategoriFase($fase) ?? 'waxing',
            'iluminasi' => round($iluminasi, 2),
            'hari_lunar' => $this->hitungHariLunar($fase),
            'umur' => $faseBulan->age(),
        ];
    }

    /**
     * Cek apakah tanggal adalah hari Uposatha (fase bulan utama)
     *
     * @param Carbon $tanggal
     * @return bool
     */
    public function adalahHariUposatha(Carbon $tanggal): bool
    {
        $faseBulan = new MoonPhase($tanggal->timestamp);
        $fase = $faseBulan->phase();
        $kategoriFase = $this->tentukanKategoriFase($fase);

        return in_array($kategoriFase, ['bulan_baru', 'paruh_pertama', 'purnama', 'paruh_akhir']);
    }
}
