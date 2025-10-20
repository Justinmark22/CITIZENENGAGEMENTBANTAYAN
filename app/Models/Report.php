<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'category',
        'title',
        'description',
        'photo',
        'status',
        'location',
        'user_id',
    ];

    // Move this outside the fillable block
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
