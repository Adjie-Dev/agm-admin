<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FaseBulan extends Model
{
    use HasFactory;

    protected $table = 'fase_bulan';

    protected $fillable = [
        'tanggal',
        'fase',
        'iluminasi',
        'hari_lunar',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'iluminasi' => 'decimal:2',
    ];

    /**
     * Dapatkan acara Buddhist yang terkait dengan fase bulan ini
     */
    public function acaraBuddhist()
    {
        return $this->hasOne(AcaraBuddhist::class, 'fase_bulan_id');
    }

    /**
     * Dapatkan aturan Uposatha untuk fase ini
     */
    public function aturanUposatha()
    {
        return AturanUposatha::where('fase_bulan', $this->fase)
            ->where('aktif', true)
            ->first();
    }

    /**
     * Cek apakah tanggal ini adalah hari Uposatha
     */
    public function adalahHariUposatha(): bool
    {
        return in_array($this->fase, ['bulan_baru', 'paruh_pertama', 'purnama', 'paruh_akhir']);
    }

    /**
     * Dapatkan nama tampilan fase
     */
    public function getNamaTampilanAttribute(): string
    {
        return match($this->fase) {
            'bulan_baru' => 'Bulan Baru',
            'paruh_pertama' => 'Paruh Pertama',
            'purnama' => 'Purnama',
            'paruh_akhir' => 'Paruh Akhir',
            default => $this->fase,
        };
    }
}