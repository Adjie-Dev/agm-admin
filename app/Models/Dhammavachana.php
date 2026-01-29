<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dhammavachana extends Model
{
    protected $table = 'dhammavachana'; // TAMBAH INI

    protected $fillable = [
        'title',
        'description',
        'pdf_path',
        'cover_image',
        'page_count',
        'uploaded_by',
        'author',
        'category',
        'language',
        'pages',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
