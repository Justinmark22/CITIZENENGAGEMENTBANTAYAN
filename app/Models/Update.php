<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Update extends Model
{
    use HasFactory;

    // Allow mass assignment on these fields
    protected $fillable = [
        'title',
        'message', // Assuming 'message' is used, not 'content' as in your original model.
        'location', // You might want to include location if needed.
        'update_date', // Add 'update_date' to the fillable fields
    ];
}

