<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Announcement extends Model
{
  protected $fillable = [
    'title',
    'message',
    'location',
    'start_date',
    'end_date',
    'user_id',  // ✅ Add this
];



}
