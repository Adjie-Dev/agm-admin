<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dhammavachana extends Model
{
    protected $table = 'dhammavachana';

    protected $fillable = [
        'title',
        'description',
        'pdf_path',
        'cover_image',
        'page_count',
        'uploaded_by',
    ];

    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
