<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dhammavachana extends Model
{
    use HasFactory;

    protected $table = 'dhammavachana';

    protected $fillable = [
        'title',
        'author',
        'description',
        'category',
        'pages',
        'file_size',
        'language',
        'pdf_file',
        'cover_image',
    ];
}