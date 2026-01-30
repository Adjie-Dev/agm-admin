<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'content_html',
        'published_at',
        'thumbnail',
        'author',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];
}