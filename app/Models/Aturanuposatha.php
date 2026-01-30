<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AturanUposatha extends Model
{
    use HasFactory;

    protected $table = 'aturan_uposatha';

    protected $fillable = [
        'fase_bulan',
        'nama_acara',
        'deskripsi',
        'warna',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
    ];

    /**
     * Scope untuk aturan aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Dapatkan semua fase bulan yang cocok dengan aturan ini
     */
    public function faseBulanTerkait()
    {
        return FaseBulan::where('fase', $this->fase_bulan)->get();
    }

    /**
     * Dapatkan nama tampilan fase
     */
    public function getFaseTampilanAttribute(): string
    {
        return match($this->fase_bulan) {
            'bulan_baru' => 'Bulan Baru',
            'paruh_pertama' => 'Paruh Pertama',
            'purnama' => 'Purnama',
            'paruh_akhir' => 'Paruh Akhir',
            default => $this->fase_bulan,
        };
    }
}