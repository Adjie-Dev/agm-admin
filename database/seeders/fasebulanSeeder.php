<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\LayananFaseBulan;
use App\Models\FaseBulan;
use Illuminate\Support\Facades\DB;

class SeedFaseBulan extends Command
{
    /**
     * Nama dan signature command
     *
     * @var string
     */
    protected $signature = 'buddhist:seed-fase-bulan {tahunMulai=2020} {tahunSelesai=2100}';

    /**
     * Deskripsi command
     *
     * @var string
     */
    protected $description = 'Seed fase bulan untuk kalender Buddhist (default 2020-2100)';

    protected LayananFaseBulan $layananFaseBulan;

    public function __construct(LayananFaseBulan $layananFaseBulan)
    {
        parent::__construct();
        $this->layananFaseBulan = $layananFaseBulan;
    }

    /**
     * Jalankan command
     */
    public function handle()
    {
        $tahunMulai = (int) $this->argument('tahunMulai');
        $tahunSelesai = (int) $this->argument('tahunSelesai');

        $this->info("🌙 Generating fase bulan dari {$tahunMulai} sampai {$tahunSelesai}...");
        $this->info("⏱️  Estimasi waktu: ~" . ($tahunSelesai - $tahunMulai + 1) . " detik...");

        $bar = $this->output->createProgressBar($tahunSelesai - $tahunMulai + 1);
        $bar->start();

        $totalDiinput = 0;

        for ($tahun = $tahunMulai; $tahun <= $tahunSelesai; $tahun++) {
            $semuaFase = $this->layananFaseBulan->generateFaseUntukTahun($tahun);

            // Batch insert untuk performa lebih baik
            $chunks = array_chunk($semuaFase, 100);
            foreach ($chunks as $chunk) {
                DB::table('fase_bulan')->insertOrIgnore($chunk);
                $totalDiinput += count($chunk);
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("✅ Berhasil input {$totalDiinput} data fase bulan!");
        $this->info("📅 Rentang tanggal: {$tahunMulai}-01-01 sampai {$tahunSelesai}-12-31");

        return Command::SUCCESS;
    }
}
