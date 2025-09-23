<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostAnnounce extends Model
{
    use HasFactory;

    protected $table = 'post_announce'; // specify custom table name

    // Include 'location' so it can be mass-assigned
    protected $fillable = ['title', 'description', 'category', 'location'];
}
