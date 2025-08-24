<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    // Specify the table name if it's not the plural form of the model name
    protected $table = 'support';

    // The attributes that are mass assignable
    protected $fillable = [
        'name',
        'email',
        'message',
    ];
}
