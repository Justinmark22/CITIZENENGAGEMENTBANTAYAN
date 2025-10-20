<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Engagement extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'host',
        'start_date',
        'end_date',
    ];public function comments()
{
    return $this->hasMany(Comment::class);
}

}
