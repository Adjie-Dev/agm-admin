<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcaraBuddhist extends Model
{
    use HasFactory;

    protected $table = 'acara_buddhist';

    protected $fillable = [
        'tipe_acara',
        'nama',
        'deskripsi',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'fase_bulan_id',
        'berulang',
        'warna',
        'aktif',
        'tahun',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'berulang' => 'boolean',
        'aktif' => 'boolean',
    ];

    /**
     * Dapatkan fase bulan yang terkait dengan acara ini
     */
    public function faseBulan()
    {
        return $this->belongsTo(FaseBulan::class, 'fase_bulan_id');
    }

    /**
     * Scope untuk acara aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk tahun tertentu
     */
    public function scopeUntukTahun($query, $tahun)
    {
        return $query->where(function($q) use ($tahun) {
            $q->whereYear('tanggal', $tahun)
              ->orWhere('berulang', true);
        });
    }

    /**
     * Scope untuk tipe acara tertentu
     */
    public function scopeTipeAcara($query, $tipe)
    {
        return $query->where('tipe_acara', $tipe);
    }

    /**
     * Dapatkan nama tampilan tipe acara
     */
    public function getTipeTampilanAttribute(): string
    {
        return match($this->tipe_acara) {
            'uposatha' => 'Hari Uposatha',
            'waisak' => 'Hari Raya Waisak',
            'magha_puja' => 'Magha Puja',
            'asalha_puja' => 'Asalha Puja',
            'kathina' => 'Kathina',
            'vassa_mulai' => 'Awal Vassa',
            'vassa_selesai' => 'Akhir Vassa',
            'pavarana' => 'Pavarana',
            'custom' => 'Khusus',
            default => $this->tipe_acara,
        };
    }
}
