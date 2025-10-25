<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    // ✅ These fields can be mass assigned (used by Report::create)
    protected $fillable = [
        'category',
        'title',
        'description',
        'photo',
        'status',
        'location',
        'user_id',
    ];

    // ✅ Relationship: each report belongs to one user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
