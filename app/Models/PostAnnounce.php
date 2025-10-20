<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAnnounce extends Model
{
    use HasFactory;

    protected $table = 'post_announce'; // 👈 force Laravel to use this table

    protected $fillable = [
        'title',
        'description',
        'category',
        'location',
        'photo',
    ];
}

