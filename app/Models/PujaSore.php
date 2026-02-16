<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PujaSore extends Model
{
    use HasFactory;

    protected $table = 'puja_sore';

    protected $fillable = [
        'urutan',
        'judul',
        'durasi',
        'audio_path',
        'audio_nama_asli',
        'audio_mime',
        'audio_ukuran_kb',
        'teks_pali',
        'terjemahan',
        'aktif',
    ];

    protected $casts = [
        'aktif' => 'boolean',
        'audio_ukuran_kb' => 'integer',
    ];

    /**
     * Scope untuk mengambil data yang aktif saja
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk mengurutkan berdasarkan urutan
     */
    public function scopeUrut($query)
    {
        return $query->orderBy('urutan');
    }

    /**
     * Accessor untuk format ukuran file
     */
    public function getAudioUkuranFormattedAttribute()
    {
        if (!$this->audio_ukuran_kb) {
            return '-';
        }

        if ($this->audio_ukuran_kb < 1024) {
            return $this->audio_ukuran_kb . ' KB';
        }

        return round($this->audio_ukuran_kb / 1024, 2) . ' MB';
    }
}