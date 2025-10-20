<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'engagement_id', // ✅ required for mass assignment
        'name',
        'message',
    ];

    public function engagement()
    {
        return $this->belongsTo(Engagement::class);
    }
}


