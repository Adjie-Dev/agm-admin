<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AturanUposatha;
use App\Models\AcaraBuddhist;

class KalenderBuddhistSeeder extends Seeder
{
    public function run(): void
    {
        // Seed Aturan Uposatha
        $this->seedAturanUposatha();

        // Seed Acara Buddhist Utama (2026 aja dulu)
        $this->seedAcaraUtama2026();

        $this->command->info('✅ Kalender Buddhist berhasil di-seed!');
    }

    private function seedAturanUposatha(): void
    {
        $aturan = [
            [
                'fase_bulan' => 'bulan_baru',
                'nama_acara' => 'Hari Uposatha (Bulan Baru)',
                'deskripsi' => 'Hari suci umat Buddha untuk melatih diri dengan 8 aturan moral (Atthasila)',
                'warna' => '#1e293b',
                'aktif' => true,
            ],
            [
                'fase_bulan' => 'paruh_pertama',
                'nama_acara' => 'Hari Uposatha (Paruh Pertama)',
                'deskripsi' => 'Hari suci umat Buddha untuk melatih diri dengan 8 aturan moral (Atthasila)',
                'warna' => '#334155',
                'aktif' => true,
            ],
            [
                'fase_bulan' => 'purnama',
                'nama_acara' => 'Hari Uposatha (Purnama)',
                'deskripsi' => 'Hari suci umat Buddha untuk melatih diri dengan 8 aturan moral (Atthasila)',
                'warna' => '#06b6d4',
                'aktif' => true,
            ],
            [
                'fase_bulan' => 'paruh_akhir',
                'nama_acara' => 'Hari Uposatha (Paruh Akhir)',
                'deskripsi' => 'Hari suci umat Buddha untuk melatih diri dengan 8 aturan moral (Atthasila)',
                'warna' => '#475569',
                'aktif' => true,
            ],
        ];

        foreach ($aturan as $data) {
            AturanUposatha::create($data);
        }

        $this->command->info('  ✓ Aturan Uposatha dibuat');
    }

    private function seedAcaraUtama2026(): void
    {
        $acara = [
            [
                'tipe_acara' => 'magha_puja',
                'nama' => 'Magha Puja',
                'deskripsi' => 'Memperingati berkumpulnya 1.250 bhikkhu secara spontan',
                'tanggal' => '2026-02-11',
                'warna' => '#8b5cf6',
                'berulang' => false,
                'tahun' => 2026,
            ],
            [
                'tipe_acara' => 'waisak',
                'nama' => 'Hari Raya Waisak',
                'deskripsi' => 'Memperingati kelahiran, pencapaian kesempurnaan, dan wafatnya Buddha',
                'tanggal' => '2026-05-11',
                'warna' => '#f59e0b',
                'berulang' => false,
                'tahun' => 2026,
            ],
            [
                'tipe_acara' => 'asalha_puja',
                'nama' => 'Asalha Puja',
                'deskripsi' => 'Memperingati khotbah pertama Buddha',
                'tanggal' => '2026-07-09',
                'warna' => '#10b981',
                'berulang' => false,
                'tahun' => 2026,
            ],
            [
                'tipe_acara' => 'vassa_mulai',
                'nama' => 'Awal Vassa',
                'deskripsi' => 'Awal masa retret musim hujan',
                'tanggal' => '2026-07-10',
                'warna' => '#3b82f6',
                'berulang' => false,
                'tahun' => 2026,
            ],
            [
                'tipe_acara' => 'vassa_selesai',
                'nama' => 'Akhir Vassa',
                'deskripsi' => 'Akhir masa retret musim hujan',
                'tanggal' => '2026-10-07',
                'warna' => '#3b82f6',
                'berulang' => false,
                'tahun' => 2026,
            ],
            [
                'tipe_acara' => 'kathina',
                'nama' => 'Kathina',
                'deskripsi' => 'Hari bakti umat kepada Sangha',
                'tanggal' => '2026-10-08',
                'warna' => '#ec4899',
                'berulang' => false,
                'tahun' => 2026,
            ],
        ];

        foreach ($acara as $data) {
            AcaraBuddhist::create($data);
        }

        $this->command->info('  ✓ Acara Buddhist 2026 dibuat');
    }
}
