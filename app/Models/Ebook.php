<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ebook extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'pdf_file',
        'cover_image',
        'page_count',
        'uploader_id',
    ];

    /**
     * Get the user who uploaded this ebook
     */
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}